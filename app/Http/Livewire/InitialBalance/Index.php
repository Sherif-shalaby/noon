<?php

namespace App\Http\Livewire\InitialBalance;

use App\Models\Brand;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public  $stocks, $product_name, $product_sku, $product_symbol, $supplier_id, $created_by, $from, $to, $brand_id;

    protected $listeners = ['listenerReferenceHere'];

    public function listenerReferenceHere($data)
    {
        if (isset($data['var1'])) {
            if ($data['var1'] == 'supplier_id' || $data['var1'] == 'created_by') {
                $this->{$data['var1']} = (int)$data['var2'];
            } else {
                $this->{$data['var1']} = $data['var2'];
            }
        }
    }

    public function render()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name', 'id');
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name', 'id');
        $users = User::orderBy('created_at', 'desc')->pluck('name', 'id');
        $this->stocks =  StockTransaction::where('parent_transction', 0)->whereIn('type', ['initial_balance_payment', 'initial_balance'])
            ->when(\request()->dont_show_zero_stocks == "on", function ($query) {
                $query->whereHas('product_stores', function ($query) {
                    $query->where('quantity_available', '>', 0);
                });
            })
            ->when($this->supplier_id != null, function ($query) {
                $query->where('supplier_id', $this->supplier_id);
            })
            ->when($this->created_by != null, function ($query) {
                $query->where('created_by', $this->created_by);
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
            ->when($this->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('brand_id', $this->brand_id);
                });
            })
            ->when($this->from != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') >= ?", [$this->from]);
            })
            ->when($this->to != null, function ($query) {
                $query->whereRaw("STR_TO_DATE(transaction_date, '%Y-%m-%d') <= ?", [$this->to]);
            })
            ->orderBy('created_at', 'desc')->get();
        $this->dispatchBrowserEvent('componentRefreshed');

        return view(
            'livewire.initial-balance.index',
            compact('suppliers', 'users', 'brands')
        );
    }
    public function calculatePendingAmount($transaction_id): string
    {
        $transaction = StockTransaction::find($transaction_id);
        $final_total = 0;
        $pending = 0;
        $amount = 0;
        $payments = $transaction->transaction_payments;
        if ($transaction->transaction_currency == 2) {
            $final_total = $transaction->dollar_final_total;
            foreach ($payments as $payment) {
                if ($payment->paying_currency == 2) {
                    $amount += $payment->amount;
                    $pending = $final_total - $amount;
                } else {
                    $amount += $payment->amount / $payment->exchange_rate;
                    $pending = $final_total - $amount;
                }
            }
        } else {
            $final_total = $transaction->final_total;
            foreach ($payments as $payment) {
                if ($payment->paying_currency == 2) {
                    $amount += $payment->amount * $payment->exchange_rate;
                    $pending = $final_total - $amount;
                } else {
                    $amount += $payment->amount;
                    $pending = $final_total - $amount;;
                }
            }
        }

        return number_format($pending, num_of_digital_numbers());
    }

    public function calculatePaidAmount($transaction_id): string
    {
        $transaction = StockTransaction::find($transaction_id);
        $final_total = 0;
        $paid = 0;
        $payments = $transaction->transaction_payments;
        if ($transaction->transaction_currency == 2) {
            $final_total = $transaction->dollar_final_total;
            foreach ($payments as $payment) {
                if ($payment->paying_currency == 2) {
                    $paid += $payment->amount;
                } else {
                    $paid += $payment->amount / $payment->exchange_rate;
                }
            }
        } else {
            $final_total = $transaction->final_total;
            foreach ($payments as $payment) {
                if ($payment->paying_currency == 2) {
                    $paid += $payment->amount * $payment->exchange_rate;
                } else {
                    $paid += $payment->amount;
                }
            }
        }

        return number_format($paid, num_of_digital_numbers());
    }

    public function changePayingCurrency()
    {
        $this->dispatchBrowserEvent('openAddPaymentModal');
    }

    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }
    public function clear_filters()
    {
        $this->product_symbol = null;
        $this->product_name = null;
        $this->created_by = null;
        $this->supplier_id = null;
        $this->product_sku = null;
        $this->stocks =  StockTransaction::whereIn('type', ['initial_balance_payment', 'initial_balance'])->orderBy('created_at', 'desc')->get();
    }
}
