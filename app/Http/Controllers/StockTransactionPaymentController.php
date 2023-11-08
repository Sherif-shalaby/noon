<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;
class StockTransactionPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addPayment($transaction_id)
    {
        // $payment_type_array = $this->getPaymentTypeArray();
        // $transaction =StockTransaction::find($transaction_id);
        // $users = User::Notview()->pluck('name', 'id');
        // // $balance = $this->transactionUtil->getCustomerBalanceExceptTransaction($transaction->customer_id,$transaction_id)['balance'];
        // $customer=Customer::find($transaction->customer_id);
        // $balance_dollar=$customer->balance_in_dollar;
        // $balance_dinar=$customer->balance_in_dinar;
        // $finalTotal = $transaction->final_total;
        // $dollar_finalTotal = $transaction->dollar_final_total;
        // $transactionPaymentsSum = $transaction->transaction_payments->sum('amount');
        // if ($balance_dinar > 0 && $balance_dinar < $finalTotal - $transactionPaymentsSum) {
        //     if (isset($transaction->return_parent)) {
        //         $amount = $finalTotal - $transactionPaymentsSum - $transaction->return_parent->final_total - $balance_dinar;
        //     } else {
        //         $amount = $finalTotal - $transactionPaymentsSum - $balance_dinar;
        //     }
        // } else {
        //     if (isset($transaction->return_parent)) {
        //         $amount = $finalTotal - $transactionPaymentsSum - $transaction->return_parent->final_total;
        //     } else {
        //         $amount = $finalTotal - $transactionPaymentsSum;
        //     }
        // }
        
        // if($balance_dollar > 0 && $balance_dollar < $dollar_finalTotal - $transactionPaymentsSum) {

        // }  else {
        //     if (isset($transaction->return_parent)) {
        //         $amount = $dollar_finalTotal - $transactionPaymentsSum - $transaction->return_parent->final_total;
        //     } else {
        //         $amount = $dollar_finalTotal - $transactionPaymentsSum;
        //     }
        // }
       
        // return view('transaction_payment.add_payment')->with(compact(
        //     'payment_type_array',
        //     'transaction_id',
        //     'transaction',
        //     'users',
        //     'balance',
        //     'amount'
        // ));
    }

    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
            'card' => __('lang.credit_card'),
            'bank_transfer' => __('lang.bank_transfer'),
            'cheque' => __('lang.cheque'),
            'money_transfer' => 'Money Transfer',
        ];
    }
}
