<?php

namespace App\Http\Controllers;


use App\Models\AddStockLine;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\ReceiveDiscount;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
use App\Models\TransactionSellLine;
use App\Models\User;
use App\Utils\MoneySafeUtil;
use App\Utils\ProductUtil;
use App\Utils\ReportsFilters;
use App\Utils\StockTransactionUtil;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddStockController extends Controller
{

    protected $commonUtil;
    protected $moneysafeUtil;
    protected $productUtil;
    protected $stockTransactionUtil;
    protected $reportsFilters;



    public function __construct(Util $commonUtil,ProductUtil $productUtil,MoneySafeUtil $moneySafeUtil, StockTransactionUtil $stockTransactionUtil,ReportsFilters $reportsFilters)
    {
        $this->commonUtil = $commonUtil;
        $this->moneysafeUtil = $moneySafeUtil;
        $this->productUtil = $productUtil;
        $this->stockTransactionUtil = $stockTransactionUtil;
        $this->reportsFilters = $reportsFilters;


    }
    public function index(){
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::pluck('name','id');
        $categories = Category::where('parent_id',1)->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories1 = Category::where('parent_id',2)->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories2 = Category::where('parent_id',3)->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories3 = Category::where('parent_id',4)->orderBy('created_at', 'desc')->pluck('name','id');
        $payment_status_array = $this->commonUtil->getPaymentStatusArray();
        $stores = Store::orderBy('created_at', 'desc')->pluck('name','id');
        $branches = Branch::where('type','branch')->orderBy('created_at', 'desc')->pluck('name','id');
        $stocks  = $this->reportsFilters->addStockFilter();
        // foreach($stocks as $index => $stock){
        //     return $stock->add_stock_lines->sum('cash_discount');
        // }
       

        return view('add-stock.index')->with(compact('stocks','suppliers','users','brands','categories',
            'subcategories1','subcategories2','subcategories3','payment_status_array','branches','stores'));
    }

    public function show($id)
    {
        $add_stock = StockTransaction::find($id);
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $users = User::Notview()->pluck('name', 'id');

        return view('add-stock.show')->with(compact(
            'add_stock',
            'payment_type_array',
            'users',
        ));
    }
    public function destroy($id)
    {
        try {
            $add_stock = StockTransaction::find($id);

            $add_stock_lines = $add_stock->add_stock_lines;

            DB::beginTransaction();

            if ($add_stock->status != 'received') {
                $add_stock_lines->delete();
            } else {
                $delete_add_stock_line_ids = [];
                foreach ($add_stock_lines as $line) {
                    $delete_add_stock_line_ids[] = $line->id;
                    $this->productUtil->decreaseProductQuantity($line->product_id, $line->variation_id, $add_stock->store_id, $line->quantity);
                }

                if (!empty($delete_add_stock_line_ids)) {
                    AddStockLine::where('stock_transaction_id', $id)->whereIn('id', $delete_add_stock_line_ids)->delete();
                }
            }

            $add_stock->delete();
            CashRegisterTransaction::where('transaction_id', $id)
                ->where('type','add_stock')->delete();
            MoneySafeTransaction::where('transaction_id', $id)
                ->where('type','add_stock')->delete();

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
            dd($e);
        }

        return $output;
    }

    public function addPayment($transaction_id){

        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $transaction = StockTransaction::find($transaction_id);
        $users = User::Notview()->pluck('name', 'id');
//        dd(count($transaction->transaction_payments) > 0 );
        $exchange_rate = count($transaction->transaction_payments) > 0 ? $transaction->transaction_payments->last()->exchange_rate : System::getProperty('dollar_exchange');
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $pending_amount = $this->calculatePendingAmount($transaction_id);
        $supplier = $transaction->supplier->id;

        if(isset($supplier->exchange_rate)) {
            $exchange_rate = number_format($supplier->exchange_rate, 2);
        }

        return view('add-stock.partials.add-payment')->with(compact(
            'payment_type_array',
            'transaction_id',
            'transaction',
            'users',
            'exchange_rate',
            'selected_currencies',
            'pending_amount'
        ));
    }

    public function storePayment(Request $request,$transaction_id){

        try {
            $data = $request->except('_token');


            $transaction = StockTransaction::find($transaction_id);

            // add Stock Payment.

            $payment_data = [
                'stock_transaction_id' =>  $transaction_id,
                'amount' => $this->commonUtil->num_uf($request->amount),
                'method' => $data['method'],
                'paid_on' => $this->commonUtil->uf_date($data['paid_on']) . ' ' . date('H:i:s'),
                'exchange_rate' => $request->exchange_rate,
                'created_by' => Auth::user()->id,
                'paying_currency' => $request->paying_currency,
            ];
            DB::beginTransaction();

            $transaction_payment = StockTransactionPayment::create($payment_data);

            //update Exchange Rate to supplier.

            if(isset($request->change_exchange_rate_to_supplier)){
                $transaction->supplier->update(['exchange_rate' => $request->exchange_rate]);
            }
            // check user and add money to user.
            if ($data['method'] == 'cash') {
                $user_id = null;
                if (!empty($request->source_id)) {
                    if ($request->source_type == 'pos') {
                        $user_id = StorePos::where('id', $request->source_id)->first()->user_id;
                    }
                    if ($request->source_type == 'user') {
                        $user_id = $request->source_id;
                    }
                    if ($request->source_type == 'safe') {
                        $money_safe = MoneySafe::find($request->source_id);
                        $payment_data['currency_id'] = $transaction->paying_currency_id;
                        $this->moneysafeUtil->updatePayment($transaction, $payment_data, 'debit', $transaction_payment->id, null, $money_safe);
                    }

                    $register =  $this->getCurrentCashRegisterOrCreate($user_id);
                    if (!empty($user_id)) {
                        $payments_formatted[] = new CashRegisterTransaction([
                            'amount' => $this->amount,
                            'pay_method' => $this->method,
                            'type' => 'debit',
                            'transaction_type' => 'add_stock',
                            'transaction_id' => $transaction->id,
                            'transaction_payment_id' => null
                        ]);
                    }
                    if (!empty($payments_formatted) && !empty($register)) {
                        $register->cash_register_transactions()->saveMany($payments_formatted);
                    }
                }
            }


            $this->stockTransactionUtil->updateTransactionPaymentStatus($transaction->id);

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
            dd($e);
        }


        return redirect()->back()->with('status', $output);
    }

    public function receive_discount_view($transaction_id){
        // $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $transaction = StockTransaction::find($transaction_id);
        $received_discounts = ReceiveDiscount::where('stock_transaction_id', $transaction_id)->get();
    
        if(!empty($transaction->add_stock_lines)){
            $seasonal_discount = $transaction->add_stock_lines->where('used_currency', '!=', 2)->sum('seasonal_discount');
            $annual_discount = $transaction->add_stock_lines->where('used_currency', '!=', 2)->sum('annual_discount');
    
            $sum_received_seasonal = $received_discounts->where('discount_type', 'seasonal_discount')->sum('received_amount');
            $seasonal_discount -= $sum_received_seasonal;
    
            $sum_received_annual = $received_discounts->where('discount_type', 'annual_discount')->sum('received_amount');
            $annual_discount -= $sum_received_annual;
    
            $seasonal_discount_dollar = $transaction->add_stock_lines->where('used_currency', 2)->sum('seasonal_discount') - $received_discounts->sum('received_amount_dollar');
            $annual_discount_dollar = $transaction->add_stock_lines->where('used_currency', 2)->sum('annual_discount') - $received_discounts->sum('received_amount_dollar');
        } else {
            $seasonal_discount = 0;
            $annual_discount = 0;
            $seasonal_discount_dollar = 0;
            $annual_discount_dollar = 0;
        }
    
        return view('add-stock.partials.receive_discount')->with(compact(
            'transaction_id',
            'transaction',
            'seasonal_discount',
            'annual_discount',
            'seasonal_discount_dollar',
            'annual_discount_dollar'
        ));
    }
    public function receive_discount(Request $request,$transaction_id){

        try {
            $data = $request->except('_token');


            $transaction = StockTransaction::find($transaction_id);

            // add Stock Payment.

            $payment_data = [
                'stock_transaction_id' =>  $transaction_id,
                'amount' => $this->commonUtil->num_uf($request->amount),
                'method' => $data['method'],
                'paid_on' => $this->commonUtil->uf_date($data['paid_on']) . ' ' . date('H:i:s'),
                'exchange_rate' => $request->exchange_rate,
                'created_by' => Auth::user()->id,
                'paying_currency' => $request->paying_currency,
            ];
            DB::beginTransaction();

            $transaction_payment = StockTransactionPayment::create($payment_data);

            //update Exchange Rate to supplier.

            if(isset($request->change_exchange_rate_to_supplier)){
                $transaction->supplier->update(['exchange_rate' => $request->exchange_rate]);
            }
            // check user and add money to user.
            if ($data['method'] == 'cash') {
                $user_id = null;
                if (!empty($request->source_id)) {
                    if ($request->source_type == 'pos') {
                        $user_id = StorePos::where('id', $request->source_id)->first()->user_id;
                    }
                    if ($request->source_type == 'user') {
                        $user_id = $request->source_id;
                    }
                    if ($request->source_type == 'safe') {
                        $money_safe = MoneySafe::find($request->source_id);
                        $payment_data['currency_id'] = $transaction->paying_currency_id;
                        $this->moneysafeUtil->updatePayment($transaction, $payment_data, 'debit', $transaction_payment->id, null, $money_safe);
                    }

                    $register =  $this->getCurrentCashRegisterOrCreate($user_id);
                    if (!empty($user_id)) {
                        $payments_formatted[] = new CashRegisterTransaction([
                            'amount' => $this->amount,
                            'pay_method' => $this->method,
                            'type' => 'debit',
                            'transaction_type' => 'add_stock',
                            'transaction_id' => $transaction->id,
                            'transaction_payment_id' => null
                        ]);
                    }
                    if (!empty($payments_formatted) && !empty($register)) {
                        $register->cash_register_transactions()->saveMany($payments_formatted);
                    }
                }
            }


            $this->stockTransactionUtil->updateTransactionPaymentStatus($transaction->id);

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
            dd($e);
        }


        return redirect()->back()->with('status', $output);
    }

    public function getSourceByTypeDropdown($type = null)
    {
        if ($type == 'user') {
            $array = User::Notview()->pluck('name', 'id');
        }
        if ($type == 'pos') {
            $array = StorePos::pluck('name', 'id');
        }
        if ($type == 'store') {
            $array = Store::pluck('name', 'id');
        }
        if ($type == 'safe') {
            $array = MoneySafe::pluck('name', 'id');
        }

        return $this->commonUtil->createDropdownHtml($array, __('lang.please_select'));
    }

    public function  getPayingCurrency(Request $request,$currency)
    {
        $transaction_id = $request->query('transaction');
        $pending_amount = $request->query('pending_amount');
        $exchange_rate = $request->query('exchange_rate');
        $amount = 0;
        $transaction = StockTransaction::find($transaction_id);
        if(!empty($currency)){
            if($transaction->transaction_currency == 2){
                if($currency == 2){
                    $amount = $pending_amount;
                }

                else{
                    $amount = round_250($pending_amount * $exchange_rate);
                }
            }
            else{
                if($currency == 2){
                    $amount = $pending_amount / $exchange_rate;
                }
                else{
                    $amount = round($pending_amount);
                }
            }
        }
        else{
            $amount = round($pending_amount);
        }

        return $amount;
    }

    public function calculatePendingAmount($transaction_id): string
    {
        $transaction = StockTransaction::find($transaction_id);
        $final_total = 0;
        $pending = 0;
        $amount = 0;
        $payments = $transaction->transaction_payments;
        if($transaction->transaction_currency == 2){
            $final_total = $transaction->dollar_final_total;
            foreach ($payments as $payment){
                if($payment->paying_currency == 2){
                    $amount += $payment->amount;
                    $pending = $final_total - $amount;
                }
                else{
                    $amount += $payment->amount / $payment->exchange_rate ?? System::getProperty('dollar_exchange');
                    $pending = $final_total - $amount;
                }
            }
        }
        else {
            $final_total = $transaction->final_total;
            foreach ($payments as $payment){
                if($payment->paying_currency == 2){
                    $amount += $payment->amount * $payment->exchange_rate ?? System::getProperty('dollar_exchange');
                    $pending = $final_total - $amount;
                }
                else{
                    $amount += $payment->amount;
                    $pending = $final_total - $amount;;
                }
            }
        }

        return number_format($pending,3);
    }

    public function calculatePaidAmount($transaction_id): string
    {
        $transaction = StockTransaction::find($transaction_id);
        $final_total = 0;
        $paid = 0;
        $payments = $transaction->transaction_payments;
        if($transaction->transaction_currency == 2){
            $final_total = $transaction->dollar_final_total;
            foreach ($payments as $payment){
                if($payment->paying_currency == 2){
                    $paid = $payment->amount;
                }
                else{
                    $paid = $payment->amount / $payment->exchange_rate ?? System::getProperty('dollar_exchange');
                }
            }
        }
        else {
            $final_total = $transaction->final_total;
            foreach ($payments as $payment){
                if($payment->paying_currency == 2){
                    $paid = $payment->amount * $payment->exchange_rate ?? System::getProperty('dollar_exchange');
                }
                else{
                    $paid = $payment->amount;
                }
            }
        }

        return number_format($paid,3);
    }

    public function recentTransactions(Request $request){
        $sell_lines = TransactionSellLine::query();

        // Check if the user is a superadmin or admin
        if (auth()->user()->is_superadmin == 1 || auth()->user()->is_admin == 1) {
            $sell_lines = $sell_lines->orderBy('created_at', 'desc');
        } else {
            $sell_lines = $sell_lines->where('created_by', auth()->user()->id)->orderBy('created_at', 'desc');
        }
        if (!empty(request()->from)) {
            $sell_lines->whereDate('transaction_sell_lines.created_at', '>=', request()->from);
        }
        if (!empty(request()->to)) {
            $sell_lines->whereDate('transaction_sell_lines.created_at', '<=', request()->to);
        }
        if (!empty(request()->customer_id)) {
            $sell_lines->where('transaction_sell_lines.customer_id', request()->customer_id);
        }
        if (!empty(request()->deliveryman_id)) {
            $sell_lines->where('transaction_sell_lines.deliveryman_id', request()->deliveryman_id);
        }
        if (!empty(request()->created_by)) {
            $sell_lines->where('transaction_sell_lines.created_by', request()->created_by);
        }
        if (!empty(request()->method)) {
            $sell_lines->where('payment_transaction_sell_lines.method', request()->method);
        }
        $sell_lines = $sell_lines->paginate(10);

        $customers=Customer::latest()->pluck('name','id')->toArray();
        $payment_types = $this->getPaymentTypeArrayForPos();
        $users=User::latest()->pluck('name','id')->toArray();
        $pos_users=StorePos::pluck('user_id')->toArray();
        $employees=Employee::whereIn('user_id',$pos_users)->pluck('employee_name','id')->toArray();
        $job_type_id=JobType::where('title','deliveryman')->first()->id??0;
        $delivery_men=Employee::where('job_type_id',$job_type_id)->pluck('employee_name','id')->toArray();
        return view('invoices.partials.recent_transactions',compact('sell_lines','customers','payment_types','users','employees','delivery_men'));
    }
    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
            'card' => __('lang.credit_card'),
            'cheque' => __('lang.cheque'),
            'gift_card' => __('lang.gift_card'),
            'bank_transfer' => __('lang.bank_transfer'),
            'deposit' => __('lang.use_the_balance'),
//            'paypal' => __('lang.paypal'),
        ];
    }


}
