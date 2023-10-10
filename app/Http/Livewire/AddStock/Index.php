<?php

namespace App\Http\Livewire\AddStock;

use App\Models\Currency;
use App\Models\StockTransaction;
use App\Models\System;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $selectedItem,$transaction,$users = [],$exchange_rate;

    public function render()
    {
        $stocks =  StockTransaction::where('type','add_stock')->orderBy('created_at', 'desc')->get();
//        dd($stocks);
        return view('livewire.add-stock.index')->with(compact('stocks'));
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
                    $amount += $payment->amount / $payment->exchange_rate;
                    $pending = $final_total - $amount;
                }
            }
        }
        else {
            $final_total = $transaction->final_total;
            foreach ($payments as $payment){
                if($payment->paying_currency == 2){
                    $amount += $payment->amount * $payment->exchange_rate;
                    $pending = $final_total - $amount;
                }
                else{
                    $amount += $payment->amount;
                    $pending = $final_total - $amount;;
                }
            }
        }

        return number_format($pending,2);
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
                    $paid += $payment->amount;
                }
                else{
                    $paid += $payment->amount / $payment->exchange_rate;
                }
            }
        }
        else {
            $final_total = $transaction->final_total;
            foreach ($payments as $payment){
                if($payment->paying_currency == 2){
                    $paid += $payment->amount * $payment->exchange_rate;
                }
                else{
                    $paid += $payment->amount;
                }
            }
        }

        return number_format($paid,2);
    }

    public function changePayingCurrency(){
        $this->dispatchBrowserEvent('openAddPaymentModal');
    }

    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }
}
