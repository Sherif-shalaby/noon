<?php

namespace App\Http\Controllers;


use App\Models\AddStockLine;
use App\Models\CashRegisterTransaction;
use App\Models\Currency;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
use App\Models\User;
use App\Utils\MoneySafeUtil;
use App\Utils\ProductUtil;
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


    public function __construct(Util $commonUtil,ProductUtil $productUtil,MoneySafeUtil $moneySafeUtil, StockTransactionUtil $stockTransactionUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->moneysafeUtil = $moneySafeUtil;
        $this->productUtil = $productUtil;
        $this->stockTransactionUtil = $stockTransactionUtil;

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
        $exchange_rate = $transaction->transaction_payments()->latest()->first()->exchange_rate;
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



}
