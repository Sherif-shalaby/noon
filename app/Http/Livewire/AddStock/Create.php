<?php

namespace App\Http\Livewire\AddStock;

use App\Models\AddStockLine;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Currency;
use App\Models\MoneySafe;
use App\Models\Product;
use App\Models\Size;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\System;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $selectedProducts = []; public $selectedProductData = []; public $quantity = []; public $purchase_price =[];
    public $selling_price = []; public $base_unit = []; public $divide_costs ;  public $other_expenses = 0;
    public $other_payments = 0; public $total_size = []; public $total_weight =[]; public $cost = [];
    public $total_cost = []; public $sub_total = []; public $change_price_stock =[]; public $store_id;
    public $status; public $order_date; public $purchase_type; public $invoice_no; public $discount_amount;
    public $source_type; public $payment_status;



    public function render()
    {
        $status_array = $this->getPurchaseOrderStatusArray();
        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $variation_id = request()->get('variation_id');
        $product_id = request()->get('product_id');

        $is_raw_material = request()->segment(1) == 'raw-material' ? true : false;

        $sub_categories = Category::whereNotNull('parent_id')->orderBy('name', 'asc')->pluck('name', 'id');
        $colors = Color::orderBy('name', 'asc')->pluck('name', 'id');
        $sizes = Size::orderBy('name', 'asc')->pluck('name', 'id');
        $currenciesId=System::getProperty('currency') ? json_decode(System::getProperty('currency'), true) : [];
//        $selected_currencies=Currency::whereIn('id',$currenciesId)->pluck('currency','id');
        $products=Product::
        when(\request()->category_id != null, function ($query) {
            $query->where('category_id',\request()->category_id);
        })
            ->when(\request()->unit_id != null, function ($query) {
                $query->where('unit_id',\request()->unit_id);
            })
            ->when(\request()->store_id != null, function ($query) {
                $query->where('store_id',\request()->store_id);
            })
            ->when(\request()->brand_id != null, function ($query) {
                $query->where('brand_id',\request()->brand_id);
            })
            ->when(\request()->created_by != null, function ($query) {
                $query->where('created_by',\request()->created_by);
            })
            ->latest()->get();
        $units=Unit::orderBy('created_at', 'desc')->pluck('name','id');
        $categories=Category::orderBy('created_at', 'desc')->pluck('name','id');
        $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $stores  = Store::getDropdown();
        $users = User::Notview()->pluck('name', 'id');

        return view('livewire.add-stock.create',
            compact('is_raw_material',
            'status_array',
            'payment_status_array',
            'payment_type_array',
            'stores',
            'variation_id',
            'product_id',
            'payment_types',
            'payment_status_array',
            'categories',
            'sub_categories',
            'brands',
            'units',
            'colors',
            'sizes',
//            'selected_currencies',
            'products',
            'users'));
    }


    public function fetchSelectedProducts()
    {
        $this->emit('closeModal');
        $this->selectedProductData = Product::whereIn('id', $this->selectedProducts)->get();
//        dump($this->selectedProductData);
    }

    public function mount()
    {
        foreach ($this->selectedProductData as $index => $product) {
            $this->quantity[$index] = 0;
            $this->purchase_price[$index] = 0;

        }
    }

    public function get_product($index){
        return Product::where('id' ,$this->selectedProductData[$index]->id)->first();
    }

    public function sub_total($index)
    {
        if(isset($this->quantity[$index]) && isset($this->purchase_price[$index])){
            $this->base_unit[$index] = $this->get_product($index)->unit->base_unit_multiplier;
            $this->sub_total[$index] = $this->quantity[$index] * $this->purchase_price[$index] * $this->base_unit[$index];
            return number_format($this->sub_total[$index], 2);
        }
        else{
            $this->quantity[$index] = 0;
            $this->purchase_price[$index] = 0;
        }
    }

    public function total_quantity($index){
        return  $this->get_product($index)->unit->base_unit_multiplier * $this->quantity[$index];
    }

    public function total_size($index){
        $this->total_size[$index] =  $this->total_quantity($index) * $this->selectedProductData[$index]->size;
        return $this->total_size[$index];
    }

    public function total_weight($index){
       $this->total_weight[$index] = $this->total_quantity($index) * $this->selectedProductData[$index]->weight ;
       return $this->total_weight[$index];
    }

    public function sum_size(){
        return array_sum($this->total_size);
    }

    public function sum_weight(){
        return array_sum($this->total_weight);
    }

    public function cost($index){

        $product = $this->get_product($index);
        $cost = $this->other_expenses + $this->other_payments;

        if ($this->divide_costs == 'size'){
            $this->cost[$index] = ( ( $cost / $this->sum_size() ) * $product->size ) + $this->purchase_price[$index];
        }
        elseif ($this->divide_costs == 'weight'){
            $this->cost[$index] = ( ( $cost / $this->sum_weight() ) * $product->weight ) + $this->purchase_price[$index];
        }
        elseif ($this->divide_costs == 'price'){
            $this->cost[$index] = ( ( $cost / array_sum($this->sub_total) ) * $this->purchase_price[$index] ) + $this->purchase_price[$index];
        }
        else{
           $this->cost[$index] = $this->purchase_price[$index];
        }
        return number_format($this->cost[$index],2);
    }

    public function total_cost($index){
        $this->total_cost[$index] = $this->cost[$index] * $this->total_quantity($index);
        return number_format($this->total_cost[$index],2);
    }

    public function delete_product($index){
        unset($this->selectedProducts[$index]);
        unset($this->selectedProductData[$index]);
    }

    public function store()
    {
        $transaction =new StockTransaction();
        $transaction->store_id = $this->store_id;
        $transaction->status = $this->status;
        $transaction->order_date = !empty($this->order_date) ? $this->order_date : Carbon::now();
        $transaction->purchase_type = $this->purchase_type;
        $transaction->invoice_no = !empty($this->invoice_no) ? $this->invoice_no : null;
        $transaction->discount_amount = !empty($this->discount_amount) ? $this->discount_amount : null;




//            $user_id = null;
//            if (!empty($request->source_id)) {
//                if ($request->source_type == 'pos') {
////                    $user_id = StorePos::where('id', $request->source_id)->first()->user_id;
//                }
//                if ($request->source_type == 'user') {
//                    $user_id = $request->source_id;
//                }
//                if ($request->source_type == 'safe') {
//                    $money_safe = MoneySafe::find($request->source_id);
//                    $payment_data['currency_id'] = $transaction->paying_currency_id;
//
//                    $this->moneysafeUtil->addPayment($transaction, $payment_data, 'debit', $transaction_payment->id, $money_safe);
//                }
//            }
//            if (!empty($user_id)) {
//                $this->cashRegisterUtil->addPayments($transaction, $payment_data, 'debit', $user_id);
//            }

        dump($this->selectedProductData,$this->quantity,$this->selling_price);
        foreach ($this->selectedProductData as $index => $product){
            $add_stock_data = [
            'product_id' => $product->id,
            'quantity' => $this->quantity[$index],
            'purchase_price' => $this->purchase_price[$index],
            'final_cost' => $this->purchase_price[$index],
            'sub_total' => $this->sub_total($index),
            'sell_price' => $this->selling_price[$index],
            ];
            $add_stock = AddStockLine::create($add_stock_data);
        }
        if ($add_stock){
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'lang.success',]);
        }
        else{
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);
        }

        return redirect('/add-stock/index');
    }


    public function getPurchaseOrderStatusArray()
    {
        return [
            'draft' => __('lang.draft'),
            'sent_admin' => __('lang.sent_to_admin'),
            'sent_supplier' => __('lang.sent_to_supplier'),
            'received' => __('lang.received'),
            'pending' => __('lang.pending'),
            'partially_received' => __('lang.partially_received'),
        ];
    }
    public function getPaymentStatusArray()
    {
        return [
            'partial' => __('lang.partially_paid'),
            'paid' => __('lang.paid'),
            'pending' => __('lang.pay_later'),
        ];
    }
    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }
}
