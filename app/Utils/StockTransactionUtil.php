<?php

namespace App\Utils;

use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;


class StockTransactionUtil extends Util
{
    public function updateTransactionPaymentStatus($transaction_id)
    {
        $transaction_payments = StockTransactionPayment::where('stock_transaction_id', $transaction_id)->get();

        $total_paid = $transaction_payments->sum('amount');

        $transaction = StockTransaction::find($transaction_id);
//        $returned_transaction = StockTransaction::where('return_parent_id',$transaction_id)->sum('final_total');
//        if($returned_transaction){
//            $final_amount = $transaction->final_total - $transaction->used_deposit_balance -  $returned_transaction;
//        }else{
            $final_amount = $transaction->final_total - $transaction->used_deposit_balance;
//        }

        $payment_status = 'pending';
        if ($final_amount <= $total_paid) {
            $payment_status = 'paid';
        } elseif ($total_paid > 0 && $final_amount > $total_paid) {
            $payment_status = 'partial';
        }
        $transaction->payment_status = $payment_status;
        $transaction->save();

        return $transaction;
    }
}
