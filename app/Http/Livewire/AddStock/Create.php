<?php

namespace App\Http\Livewire\AddStock;

use App\Models\AddStockLine;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Store;
use App\Models\Unit;
use App\Models\User;
use App\Utils\ProductUtil;
use App\Utils\Util;
use Livewire\Component;

class Create extends Component
{
    public $selectedProducts = []; public $selectedProductData = []; public $quantity = []; public $purchase_price =[];
    public $selling_price =[];
//    public $sub =[];



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
//        $exchange_rate_currencies = $this->commonUtil->getCurrenciesExchangeRateArray(true);
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
            'products',
            'users'));
    }


    public function fetchSelectedProducts()
    {
//        dd('1');
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

    public function sub_total($index)
    {
        if(isset($this->quantity[$index]) && isset($this->purchase_price[$index])){
            $sub_total = $this->quantity[$index] * $this->purchase_price[$index];
            return number_format($sub_total, 2);
        }
        else{
            $this->quantity[$index] = 0;
            $this->purchase_price[$index] = 0;
        }
    }

    public function store()
    {
//        dump($this->selectedProductData,$this->quantity,$this->selling_price);
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
