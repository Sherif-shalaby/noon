<?php

namespace App\Http\Controllers;


use App\Models\CashRegisterTransaction;
use App\Models\Currency;
use App\Models\MoneySafe;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\System;
use App\Models\User;
use App\Utils\MoneySafeUtil;
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
    protected $stockTransactionUtil;


    public function __construct(Util $commonUtil,MoneySafeUtil $moneySafeUtil, StockTransactionUtil $stockTransactionUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->moneysafeUtil = $moneySafeUtil;
        $this->stockTransactionUtil = $stockTransactionUtil;

    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $add_stock = StockTransaction::find($id);
        $payment_type_array = $this->getPaymentTypeArray();
//        $taxes = Tax::pluck('name', 'id');
        $users = User::Notview()->pluck('name', 'id');

        return view('add-stock.show')->with(compact(
            'add_stock',
            'payment_type_array',
            'users',
//            'taxes'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        //
    }


    public function addPayment($transaction_id){

        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $transaction = StockTransaction::find($transaction_id);
        $users = User::Notview()->pluck('name', 'id');
        $exchange_rate = $transaction->transaction_payments()->latest()->first()->exchange_rate;
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');

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
            'selected_currencies'
        ));
    }

    public function storePayment(Request $request,$transaction_id){

//        dd($request);
        try {
            $data = $request->except('_token');

            $transaction = StockTransaction::find($request->transaction_id);
            $payment_data = [
                'stock_transaction_id' =>  $request->transaction_id,
                'amount' => $this->commonUtil->num_uf($request->amount),
                'method' => $data['method'],
                'paid_on' => $this->commonUtil->uf_date($data['paid_on']) . ' ' . date('H:i:s'),
                'ref_number' => $request->ref_number,
                'bank_deposit_date' => !empty($data['bank_deposit_date']) ? $this->commonUtil->uf_date($data['bank_deposit_date']) : null,
                'bank_name' => $request->bank_name,
                'card_number' => $request->card_number,
                'card_month' => $request->card_month,
                'card_year' => $request->card_year,
                'exchange_rate' => $request->exchange_rate,
                'created_by' => Auth::user()->id,
                'payment_for' => !empty($data['payment_for']) ? $data['payment_for'] : $transaction->customer_id,
            ];
            DB::beginTransaction();

            $transaction_payment = StockTransactionPayment::create($payment_data);

//            if ($request->upload_documents) {
//                foreach ($request->file('upload_documents', []) as $key => $doc) {
//                    $transaction_payment->addMedia($doc)->toMediaCollection('transaction_payment');
//                }
//            }
            // check user and add money to user
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


}
