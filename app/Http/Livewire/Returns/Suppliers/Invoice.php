<?php

namespace App\Http\Livewire\Returns\Suppliers;

use App\Models\AddStockLine;
use App\Models\Brand;
use App\Models\ProductStore;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Invoice extends Component
{
    public $stocks, $brand_id, $supplier_id, $po_no, $product_name, $product_sku, $product_symbol, $created_by, $from, $to, $due_date,
           $notify_before_days, $payment_status;

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
    public function mount(){
        $this->to = Carbon::now()->toDateString();
        $this->dispatchBrowserEvent('initialize-select2');

    }

    public function render()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::pluck('name','id');
        $payment_status_array = $this->getPaymentStatusArray();

        $this->stocks =  StockTransaction::
            when($this->po_no, function ($query) {
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

        return view('livewire.returns.suppliers.invoice',compact('suppliers','users', 'brands','payment_status_array'));
    }

    public function clear_filters(){
        $this->brand_id = null;
        $this->supplier_id = null;
        $this->po_no = null;
        $this->product_sku = null;
        $this->product_name = null;
        $this->product_symbol = null;
        $this->created_by = null;
        $this->from = null;
        $this->to = Carbon::now()->toDateString();
        $this->stocks =  StockTransaction::orderBy('created_at', 'desc')->get();
    }

    public function submit( $via = 'invoice', $id){
        if($via == 'all_invoice'){
            DB::beginTransaction();
            $stock_transcation = StockTransaction::find($id);
            if(!empty($stock_transcation)){
                $transaction_data = [
                    'store_id' => $stock_transcation->store_id,
                    'supplier_id' => $stock_transcation->supplier_id,
                    'type' => 'return_stock',
                    'final_total' => $this->num_uf($stock_transcation->final_total),
                    'grand_total' => $this->num_uf($stock_transcation->grand_total),
                    'dollar_final_total' => $this->num_uf($stock_transcation->dollar_final_total),
                    'dollar_grand_total' => $this->num_uf($stock_transcation->dollar_grand_total),
                    'transaction_date' => Carbon::now(),
                    'invoice_no' => $this->getNumberByType(),
                    'payment_status' => 'pending',
                    'status' => 'received',
                    'is_return' => 1,
                    'due_date' => $this->due_date,
                    'notify_me' => !empty($this->notify_before_days) ? 1 : 0,
                    'notify_before_days' => !empty($this->notify_before_days) ? $this->notify_before_days : 0,
                    'return_parent_id' => $stock_transcation->id,
                    'created_by' => Auth::user()->id,
                ];
                $transaction = StockTransaction::create($transaction_data);
                $stocks = $stock_transcation->add_stock_lines;
                foreach ($stocks as $stock){
                    $stock->quantity_returned = $stock->quantity;
                    $stock->save();
                    $this->decreaseProductQuantity($stock->product_id , $stock->variation_id, $transaction->store_id, $stock->quantity_returned);
                }
            }

        }
    }

    public function decreaseProductQuantity($product_id, $variation_id = null, $store_id, $new_quantity)
    {
        $product_store = ProductStore::where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->first();
        $product_variations = Variation::where('product_id', $product_id)->get();
        $unit = Variation::where('id', $variation_id)->first();
        $qty_difference = 0;
        $qtyByUnit = 1;
        if (!empty($product_store) && !empty($product_store->variation_id)) {
            $store_variation = Variation::find($product_store->variation_id);
            if ($store_variation->unit_id == $unit->unit_id) {
                $qty_difference = $new_quantity;
            } elseif ($store_variation->basic_unit_id == $unit->unit_id) {
                $qtyByUnit = 1 / $store_variation->equal;
                $qty_difference = $qtyByUnit * $new_quantity;
            } else {
                foreach ($product_variations as $key => $product_variation) {
                    if (!empty($product_variations[$key + 1])) {
                        if ($store_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                            if ($product_variations[$key + 1]->basic_unit_id == $unit->unit_id) {
                                $qtyByUnit = $store_variation->equal * $product_variations[$key + 1]->equal;
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            } else {
                                $qtyByUnit = $product_variation->equal;
                            }
                        } else {
                            if ($product_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                                $qtyByUnit *= $product_variation->equal;
                            }
                            if ($product_variation->basic_unit_id == $variation_id || $product_variation->unit_id == $variation_id) {
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            }
                        }
                    } else {
                        if ($product_variation->basic_unit_id == $variation_id) {
                            $qtyByUnit *= $product_variation->equal;
                            $qty_difference = $new_quantity / $qtyByUnit;
                            break;
                        }
                    }
                }
            }
        } else {
            $qty_difference = $new_quantity;
        }
        if ($qty_difference != 0) {
            if (empty($product_store)) {
                $product_store = new ProductStore();
                $product_store->product_id = $product_id;
                $product_store->store_id = $store_id;
                $product_store->quantity_available = 0;
            }
            if (empty($product_store->variation_id) && !empty($variation_id)) {
                $product_store->variation_id = $variation_id;
            }
            $product_store->decrement('quantity_available', $qty_difference);
        }

        return true;
    }
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }
    public function getNumberByType( $i = 1)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $count = StockTransaction::where('type', 'return_stock')->whereMonth('transaction_date', $month)->count() + $i;

        $number = 'RetS' . $year . $month . $count;

        return $number;
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

    public function getPaymentStatusArray()
    {
        return [
            'partial' => __('lang.partially_paid'),
            'paid' => __('lang.paid'),
            'pending' => __('lang.pay_later'),
        ];
    }

}
