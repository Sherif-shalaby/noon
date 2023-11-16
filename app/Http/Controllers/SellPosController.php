<?php

namespace App\Http\Controllers;

use App\Models\AddStockLine;
use App\Models\CashRegisterTransaction;
use App\Models\PaymentTransactionSellLine;
use App\Models\Product;
use App\Models\ReceiptTransactionSellLinesFiles;
use App\Models\SellLine;
use App\Models\System;
use App\Models\TransactionSellLine;

use App\Utils\CashRegisterUtil;
use App\Utils\NotificationUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SellPosController extends Controller
{


    protected $commonUtil;
    protected $transactionUtil;
    protected $productUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, TransactionUtil $transactionUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */

    public function index()
    {
        return view('invoices.index');
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
     * @return Response
     */
    public function create()
    {

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
}
