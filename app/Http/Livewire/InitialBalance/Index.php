<?php

namespace App\Http\Livewire\InitialBalance;

use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public  $stocks, $product_name, $product_sku, $product_symbol, $supplier_id, $created_by ;

//    public function updated($propertyName)
//    {
//        dd($propertyName);
//    }

    public function render()
    {
//        $qyery = StockTransaction::whereIn('type', ['initial_balance_payment', 'initial_balance'])
//            ->orderBy('created_at', 'desc');
//        if (!empty($this->created_by)) {
//            $qyery->where('created_by',$this->created_by);
//            dd($qyery->get());
//        }



        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $users=User::orderBy('created_at', 'desc')->pluck('name','id');
        $this->stocks =  StockTransaction::whereIn('type',['initial_balance_payment','initial_balance'])->orderBy('created_at', 'desc')->get();
//        dd($stocks);
        return view('livewire.initial-balance.index',
            compact('suppliers','users'));
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
