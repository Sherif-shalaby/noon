<?php

namespace App\Http\Livewire\AddStock;

use App\Models\Brand;
use App\Models\Currency;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $selectedItem,$transaction,$exchange_rate, $stocks, $supplier_id,
        $product_name, $product_sku, $product_symbol, $created_by, $po_no, $from, $to, $brand_id;

    public function mount(){
        $this->to = Carbon::now()->toDateString();
        $this->dispatchBrowserEvent('initialize-select2');

    }
    protected $listeners = ['listenerReferenceHere'];

    public function listenerReferenceHere($data)
    {
        if (isset($data['var1'])) {
            if ($data['var1'] == 'supplier_id' || $data['var1'] == 'created_by') {
                $this->{$data['var1']} = (int)$data['var2'];
            }
            else {
                $this->{$data['var1']} = $data['var2'];
            }
        }
    }
    public function render()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');

        $users = User::orderBy('created_at', 'desc')->pluck('name','id');

        $brands = Brand::pluck('name','id');

        $this->stocks =  StockTransaction::where('type','add_stock')
            ->when($this->po_no, function ($query) {
                $query->where('po_no','like', '%' . $this->po_no . '%');
            })
            ->when($this->supplier_id != null, function ($query) {
                $query->where('supplier_id',$this->supplier_id);
            })
            ->when($this->created_by != null, function ($query) {
                $query->where('created_by',$this->created_by);
            })
            ->when($this->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('id', $this->brand_id);
                });
            })
            ->when($this->product_name != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('name', 'like', '%' . $this->product_name . '%');
                });
            })
            ->when($this->product_sku != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('sku', 'like', '%' . $this->product_sku . '%');
                });
            })
            ->when($this->product_symbol != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('product_symbol', 'like', '%' . $this->product_symbol . '%');
                });
            })
            ->when($this->from != null, function ($query){
                $query->where('created_at', '>=', $this->from);
            })
            ->when($this->to, function ($query){
                return $query->where('created_at', '<=', $this->to);
            })
            ->orderBy('created_at', 'desc')->get();
        $this->dispatchBrowserEvent('initialize-select2');

        return view('livewire.add-stock.index')->with(compact('suppliers','users','brands'));
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
    public function clear_filters(){
        $this->product_symbol = null;
        $this->product_name = null;
        $this->created_by = null;
        $this->supplier_id = null;
        $this->product_sku = null;
        $this->po_no = null;
        $this->from = null;
        $this->brand_id = null;
        $this->to = Carbon::now()->toDateString();
        $this->stocks =  StockTransaction::where('type','add_stock')->orderBy('created_at', 'desc')->get();
    }
}
