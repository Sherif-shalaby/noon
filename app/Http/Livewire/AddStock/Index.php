<?php

namespace App\Http\Livewire\AddStock;

use App\Models\AddStockLine;
use App\Models\Currency;
use App\Models\StockTransaction;
use App\Models\System;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $stocks =  StockTransaction::all();
        return view('livewire.add-stock.index')->with(compact('stocks'));
    }

    public function addPayment($transaction_id){
        $payment_type_array = $this->getPaymentTypeArray();
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

    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }
}
