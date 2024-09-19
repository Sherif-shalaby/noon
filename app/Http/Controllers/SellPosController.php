<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomerType;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\MoneySafe;
use App\Models\StorePos;
use App\Utils\MoneySafeUtil;
use App\Utils\Util;
use App\Models\User;
use App\Models\System;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SellLine;
use App\Utils\ProductUtil;
use App\Models\AddStockLine;
use Illuminate\Http\Request;
use App\Utils\TransactionUtil;
use App\Utils\CashRegisterUtil;
use App\Utils\NotificationUtil;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionSellLine;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\Factory;
use App\Models\CashRegisterTransaction;
use App\Models\Customer;
use App\Models\PaymentTransactionSellLine;
use App\Models\ReceiptTransactionSellLinesFiles;
use App\Models\Store;
use Illuminate\Contracts\Foundation\Application;

class SellPosController extends Controller
{


    protected $commonUtil;
    protected $transactionUtil;
    protected $productUtil;
    protected $cashRegisterUtil;
    protected $moneysafeUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, TransactionUtil $transactionUtil, CashRegisterUtil $cashRegisterUtil, MoneySafeUtil $moneysafeUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
        $this->moneysafeUtil = $moneysafeUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */

    public function index()
    {
        // $sell_lines = TransactionSellLine::OrderBy('created_at','desc')->paginate(10);
        $sell_lines = TransactionSellLine::with('transaction_sell_lines.product', 'transaction_payments', 'customer')
            // start_date filter
            ->when(request()->start_date != null, function ($query) {
                $query->whereDate('transaction_date', '>=', request()->start_date);
            })
            // end_date filter
            ->when(request()->end_date != null, function ($query) {
                $query->whereDate('transaction_date', '<=', request()->end_date);
            })
            // start_time filter
            ->when(request()->start_time != null, function ($query) {
                $query->whereTime('transaction_date', '>=', request()->start_time);
            })
            // end_time filter
            ->when(request()->end_time != null, function ($query) {
                $query->whereTime('transaction_date', '<=', request()->end_time);
            })
            // customers filter
            ->when(request()->customer_id != null, function ($query) {
                $query->where('customer_id', request()->customer_id);
            })
            // customer_types filter
            ->when(request()->customer_type_id != null, function ($query) {
                $query->whereHas('customer', function ($query) {
                    $query->where('customer_type_id', request()->customer_type_id);
                });
            })
            // customer phone filter
            ->when(request()->phone_number != null, function ($query) {
                $query->whereHas('customer', function ($query) {
                    $query->where('phone', 'like', '%' . request()->phone_number . '%');
                });
            })
            // payment_status filter
            ->when(request()->payment_status != null, function ($query) {
                $query->where('payment_status', request()->payment_status);
            })
            // sale_status filter
            ->when(request()->sale_status != null, function ($query) {
                $query->where('status', request()->sale_status);
            })
            // deliveryman filter
            ->when(request()->deliveryman_id != null, function ($query) {
                // $query->whereHas('delivery', function ($query) {
                $query->where('deliveryman_id', request()->deliveryman_id);
                // });
            })
            // brands filter
            ->when(request()->brand_id, function ($query, $brand_id) {
                $query->whereHas('transaction_sell_lines.product.brand', function ($query) use ($brand_id) {
                    $query->where('brand_id', $brand_id);
                });
            })
            // products filter
            ->when(request()->product_id != null, function ($query) {
                // Conditionally apply a filter only when product_id is not null
                $query->whereHas('transaction_sell_lines.product', function ($query) {
                    // Check for the existence of related records where product_id matches the provided product_id
                    $query->where('product_id', request()->product_id);
                });
            })
            // categories filter
            ->when(request()->category_id, function ($query, $category_id) {
                $query->whereHas('transaction_sell_lines.product.category', function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                });
            })
            // subcategories1 filter
            ->when(request()->subcategory_id1, function ($query, $subcategory_id1) {
                $query->whereHas('transaction_sell_lines.product.subCategory1', function ($query) use ($subcategory_id1) {
                    $query->where('subcategory_id1', $subcategory_id1);
                });
            })
            // subcategories2 filter
            ->when(request()->subcategory_id2, function ($query, $subcategory_id2) {
                $query->whereHas('transaction_sell_lines.product.subCategory2', function ($query) use ($subcategory_id2) {
                    $query->where('subcategory_id2', $subcategory_id2);
                });
            })
            // subcategories3 filter
            ->when(request()->subcategory_id3, function ($query, $subcategory_id3) {
                $query->whereHas('transaction_sell_lines.product.subCategory3', function ($query) use ($subcategory_id3) {
                    $query->where('subcategory_id3', $subcategory_id3);
                });
            })
            // store_pos filter
            ->when(request()->pos_id != null, function ($query) {
                $query->where('store_pos_id',request()->pos_id);
            })
            ->latest()->get();
        // dd($sell_lines);
        $categories1    = Category::orderBy('name', 'asc')->where('parent_id',1)->pluck('name', 'id')->toArray();
        $categories2    = Category::orderBy('name', 'asc')->where('parent_id',2)->pluck('name', 'id')->toArray();
        $categories3    = Category::orderBy('name', 'asc')->where('parent_id',3)->pluck('name', 'id')->toArray();
        $categories4    = Category::orderBy('name', 'asc')->where('parent_id',4)->pluck('name', 'id')->toArray();
        $customers      = Customer::orderBy('name', 'asc')->pluck('name', 'id');
        $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id');
        $payment_status_array =  [
            'partial' => __('lang.partially_paid'),
            'paid' => __('lang.paid'),
            'pending' => __('lang.pay_later'),
        ];
        $sale_status =  [
            'final' => __('lang.final'),
            'draft' => __('lang.draft'),
            'ordered' => __('lang.ordered'),
            'pending' => __('lang.pending'),
            'received' => __('lang.received'),
        ];
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $products = Product::orderBy('name', 'asc')->pluck('name', 'id');
        $delivery_type_ids = JobType::where('title', 'Deliveryman')->pluck('id')->toArray();
        $delivery_men = Employee::whereIn('job_type_id', $delivery_type_ids)->pluck('employee_name', 'id')->toArray();
        $store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        $toggle_dollar = System::getProperty('toggle_dollar');

        return view('invoices.index',
            compact('sell_lines','categories1','categories2',
            'categories3','categories4','store_pos',
            'customers','customer_types',
            'payment_status_array','brands',
            'products','sale_status','delivery_men', 'toggle_dollar'));
    }

    public function showInvoice(){
        //        dd(TransactionSellLine::all()->last());
        $transaction = TransactionSellLine::all()->last();
//        dd($transaction->transaction_sell_lines);
        $payment_types = $this->getPaymentTypeArrayForPos();
        $invoice_lang = request()->session()->get('language');

        return view('invoices.partials.invoice',compact('transaction','payment_types','invoice_lang'));
    }

    public  function print($id){
        try {
            $transaction = TransactionSellLine::find($id);

            $payment_types = $this->commonUtil->getPaymentTypeArrayForPos();

            $invoice_lang = System::getProperty('invoice_lang');
            if (empty($invoice_lang)) {
                $invoice_lang = request()->session()->get('language');
            }

            if (empty($transaction->received_currency_id)) {
            }

            $html_content = $this->transactionUtil->getInvoicePrint($transaction, $payment_types,null);

            $output = [
                'success' => true,
                'html_content' => $html_content,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return $output;
    }
    public function show_payment($id){
        $transaction = TransactionSellLine::find($id);
        $payment_type_array = $this->commonUtil->getPaymentTypeArrayForPos();
        return view('transaction_payment.show')->with(compact(
            'transaction',
            'payment_type_array'
        ));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        //Check if there is a open register, if no then redirect to Create Register screen.
        if ($this->cashRegisterUtil->countOpenedRegister() == 0) {
            return redirect()->to('/cash-register/create?is_pos=1');
        }

        return view('invoices.create');
    }

    /* ++++++++++++++++++++++++ store() ++++++++++++++++++++++++++ */
    public function store(Request $request)
    {
        if (!empty($request->is_quotation))
        {
            $transaction_data['is_quotation'] = 1;
            // status = draft : عشان مفيش دفع حيث بيكون عملية حجز
            $transaction_data['status'] = 'draft';
            $transaction_data['invoice_no'] = $this->productUtil->getNumberByType('quotation');
            $transaction_data['block_qty'] = !empty($request->block_qty) ? 1 : 0;
            $transaction_data['block_for_days'] = !empty($request->block_for_days) ? $request->block_for_days : 0; //reverse the block qty handle by command using cron job
            $transaction_data['validity_days'] = !empty($request->validity_days) ? $request->validity_days : 0;
        }
        $transaction = TransactionSellLine::create($transaction_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $sell_line = TransactionSellLine::find($id);
        $payment_type_array = $this->commonUtil->getPaymentTypeArrayForPos();
        return view('invoices.show')->with(compact(
            'sell_line',
            'payment_type_array',
        ));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            $transaction = TransactionSellLine::find($id);
            DB::beginTransaction();
            $sell_lines = $transaction->transaction_sell_lines;
            foreach ($sell_lines as $sell_line) {
                if ($transaction->status == 'final') {
                    $this->productUtil->updateProductQuantityStore($sell_line->product_id, $sell_line->variation_id, $transaction->store_id, $sell_line->quantity + $sell_line->extra_quantity - $sell_line->quantity_returned);
                    if(isset($sell_line->stock_line_id)){
                        $stock = AddStockLine::where('id',$sell_line->stock_line_id)->first();
                        $stock->update([
                            'quantity_sold' =>  $stock->quantity_sold - $sell_line->quantity
                        ]);
                    }
                }
                $sell_line->delete();
            }
            $return_ids =TransactionSellLine::where('return_parent_id', $id)->pluck('id');

            TransactionSellLine::where('return_parent_id', $id)->delete();
            TransactionSellLine::where('parent_sale_id', $id)->delete();
            CashRegisterTransaction::wherein('transaction_id', $return_ids)->delete();
            $transaction->delete();
            CashRegisterTransaction::where('transaction_id', $id)->delete();


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
        }

        return $output;
    }
    // ++++++++++++++++++++++ multiDeleteRow ++++++++++++++++++++++
    public function multiDeleteRow(Request $request)
    {
        // dd($request);
        try
        {
            DB::beginTransaction();
            $delete_all_id_array = explode(',',$request->delete_all_id);
            // dd($delete_all_id_array);
            TransactionSellLine::whereIn('id',$delete_all_id_array)->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.delete_msg')
            ];
            DB::commit();
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }

    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }

    public function upload_receipt($id){

        return view('invoices.partials.upload_receipt_modal',compact('id'));
    }
    public function store_upload_receipt(Request $request){
        try {
            DB::beginTransaction();
            if($request->hasFile('receipts')){
                foreach ($request->file('receipts') as $file){
                    $receipt = new ReceiptTransactionSellLinesFiles;
                    $receipt->transaction_sell_line_id = $request->transaction_id;
                    $receipt->path =  store_file($file, 'receipt');
                    $receipt->save();
                }
                DB::commit();
                $output = [
                    'success' => true,
                    'msg' => __('lang.success')
                ];
            }
            else{
                $output = [
                    'success' => false,
                    'msg' => __('lang.no_file_chosen')
                ];
            }

        }
        catch (\Exception $e){
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }
    public function show_receipt($line_id){
        $uploaded_files = ReceiptTransactionSellLinesFiles::where('transaction_sell_line_id',$line_id)->get();
        return view('general.uploaded_files',compact('uploaded_files'));
    }
    public function addPayment($transaction_id)
    {
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $transaction = TransactionSellLine::find($transaction_id);
        $users = User::Notview()->pluck('name', 'id');
        // $balance = $this->transactionUtil->getCustomerBalanceExceptTransaction($transaction->customer_id,$transaction_id)['balance'];
        $balance = Customer::find($transaction->customer_id)->balance??0;
        $dollar_balance = Customer::find($transaction->customer_id)->dollar_balance??0;
        $dollar_finalTotal = $transaction->dollar_final_total;
        $finalTotal = $transaction->final_total;
        $transactionPaymentsSum = $transaction->transaction_payments->sum('amount');
        $dollar_transactionPaymentsSum = $transaction->transaction_payments->sum('dollar_amount');
        if ($balance > 0 && $balance < $finalTotal - $transactionPaymentsSum) {
            if (isset($transaction->return_parent)) {
                $amount = $finalTotal - $transactionPaymentsSum - $transaction->return_parent->final_total - $balance;
            } else {
                $amount = $finalTotal - $transactionPaymentsSum - $balance;
            }
        } else {
            if (isset($transaction->return_parent)) {
                $amount = $finalTotal - $transactionPaymentsSum - $transaction->return_parent->final_total;
            } else {
                $amount = $finalTotal - $transactionPaymentsSum;
            }
        }
        if ($dollar_balance > 0 && $dollar_balance < $dollar_finalTotal - $dollar_transactionPaymentsSum) {
            if (isset($transaction->return_parent)) {
                $dollar_amount = $dollar_finalTotal - $dollar_transactionPaymentsSum - $transaction->return_parent->dollar_final_total - $dollar_balance;
            } else {
                $dollar_amount = $dollar_finalTotal - $dollar_transactionPaymentsSum - $dollar_balance;
            }
        } else {
            if (isset($transaction->return_parent)) {
                $dollar_amount = $dollar_finalTotal - $dollar_transactionPaymentsSum - $transaction->return_parent->dollar_final_total;
            } else {
                $dollar_amount = $dollar_finalTotal - $dollar_transactionPaymentsSum;
            }
        }
        return view('invoices.partials.add_payment')->with(compact(
            'payment_type_array',
            'transaction_id',
            'transaction',
            'users',
            'balance','dollar_balance',
            'amount','dollar_amount'
        ));
    }
    public function storePayment(Request $request){
//        dd($request);
        try {
            $data = $request->except('_token');
            $payment_data = [
                'transaction_id' =>  $request->transaction_id,
                'amount' => $this->commonUtil->num_uf($request->amount)??0,
                'dollar_amount' => $this->commonUtil->num_uf($request->dollar_amount)??0,
                'method' => $request->method,
                'paid_on' => $this->commonUtil->uf_date($data['paid_on']) . ' ' . date('H:i:s'),
                'ref_number' => $request->ref_number,
                'bank_deposit_date' => !empty($data['bank_deposit_date']) ? $this->commonUtil->uf_date($data['bank_deposit_date']) : null,
                'bank_name' => $request->bank_name,
                'card_number' => $request->card_number,
                'card_month' => $request->card_month,
                'card_year' => $request->card_year,
            ];
            DB::beginTransaction();
            $transaction = TransactionSellLine::find($request->transaction_id);
            $transaction_payment = $this->transactionUtil->createOrUpdateTransactionPayment($transaction, $payment_data);
            if ($request->upload_document) {
                $transaction_payment->photo =  store_file($request->upload_document,'paymentSellLine');
                $transaction_payment->save();
//                dd($transaction_payment);
            }
            $user_id = null;
            if (!empty($request->source_id)) {
                if ($request->source_type == 'pos') {
                    $user_id = StorePos::where('id', $request->source_id)->first()->user_id;
                }
                if ($request->source_type == 'user') {
                    $user_id = $request->source_id;
                }
                if (!empty($user_id)) {
                    $this->cashRegisterUtil->addPayments($transaction, $payment_data, 'debit', $user_id);
                }

                if ($request->source_type == 'safe') {
                    $money_safe = MoneySafe::find($request->source_id);
                    $payment_data['currency_id'] = $transaction->paying_currency_id;
                    $this->moneysafeUtil->updatePayment($transaction, $payment_data, 'debit', $transaction_payment->id, null, $money_safe);
                }
            }
            $transaction->dollar_remaining -= $this->commonUtil->num_uf($request->dollar_amount);
            $transaction->dinar_remaining -= $this->commonUtil->num_uf($request->amount);
            $transaction->save();
            $this->transactionUtil->updateTransactionPaymentStatus($transaction->id);
            if ($transaction->type == 'sell') {
                $this->cashRegisterUtil->addPayments($transaction, $payment_data, 'credit', null,$transaction_payment->id,'pay_off');

                if ($payment_data['method'] == 'bank_transfer' || $payment_data['method'] == 'card') {
                    $this->moneysafeUtil->addPayments($transaction, $payment_data, 'credit', $transaction_payment->id);
                }
            }
            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            dd($e);
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }



        return redirect()->back()->with('status', $output);
    }
    public function editInvoice($id){
        $stores = Store::latest()->pluck('name','id')->toArray();
        return view('invoices.edit',compact('id','stores'));
    }
}
