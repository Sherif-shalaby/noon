<?php

namespace App\Http\Livewire\InitialBalance;

use App\Models\AddStockLine;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Currency;
use App\Models\CustomerType;
use App\Models\Product;
use App\Models\ProductDimension;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use App\Models\ProductTax;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\System;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

use function PHPSTORM_META\map;

class Edit extends Component
{
    use WithPagination;
    public $item = [
        [
            'id',
            'name' => '',
            'store_id' => '',
            'supplier_id' => '',
            'category_id' => '',
            'subcategory_id1' => '',
            'subcategory_id2' => '',
            'subcategory_id3' => '',
            'weight' => 0,
            'width' => 0,
            'height' => 0,
            'length' => 0,
            'size' => 0,
            'basic_unit_variation_id'=>'',
            'isExist' => 0, 'status' => '',
            'product_tax_id' => '',
            'change_current_stock' => 0,
            'method' => '',
            'exchange_rate' => 0,
            'stockId' => '',
            'product_symbol'=>'',
            'balance_return_request'=>null
        ]
    ];
    public $stockId;
    public $subcategories1 = [], $subcategories2 = [], $subcategories3 = [];
    public $quantity = [], $purchase_price = [], $selling_price = [],
        $base_unit = [], $divide_costs, $total_size = [], $total_weight = [],
        $sub_total = [], $change_price_stock = [], $store_id, $status,
        $supplier, $exchange_rate, $exchangeRate, $transaction_date, $transaction_currency,
        $dollar_purchase_price = [], $dollar_selling_price = [], $dollar_sub_total = [], $dollar_cost = [], $dollar_total_cost = [],
        $current_stock, $totalQuantity = 0, $edit_product = [], $current_sub_category, $product_tax, $subcategories = [],
        $deleted_items = [], $deleted_prices = [], $discount_from_original_price,$basic_unit_variations=[],$unit_variations=[],$branches=[];

    public $rows = [];
    public function messages()
    {
        return [
            'rows.0.prices.0.discount_quantity.required_if' => __('lang.required')
        ];
    }
    public function updatedInputs()
    {
        $this->validate([
        'transaction_currency' => 'required',
        'item.*.name' => 'required',
        'item.*.store_id' => 'required',
        'item.*.supplier_id' => 'required',
        'item.*.category_id' => 'required',
        'item.*.subcategory_id' => 'nullable',
        'item.*.subcategory_id2' => 'nullable',
        'item.*.subcategory_id3' => 'nullable',
        'item.*.weight' => 'numeric',
        'item.*.width' => 'numeric',
        'item.*.height' => 'numeric',
        'item.*.length' => 'numeric',
        'item.*.size' => 'numeric',
        'item.*.product_tax_id' => 'nullable',
        'item.*.product_symbol'=>   'nullable|string|max:255|unique:products,product_symbol,'.$this->item[0]['id'].',id,deleted_at,NULL',
        'rows.*.sku' => 'required',
        // 'rows.*.sku' => 'required|unique:variations,sku,rows.*.id,id,deleted_at,NULL',
        'rows.*.purchase_price' => 'required',
        'rows.*.dollar_purchase_price' => 'required',
        'rows.*.dollar_selling_price' => 'required',
        'rows.*.selling_price' => 'required',
        'rows.*.prices.*.discount_quantity' => 'required_if:rows.*.prices.*.bonus_quantity,' . $this->rows[0]['prices'][0]['bonus_quantity'],
        // 'rows.*.prices.*.bonus_quantity' => 'required',
        ]);
        $this->messages();
    }
    public function changeSize()
    {
        $this->item[0]['size'] = $this->item[0]['height'] * $this->item[0]['length'] * $this->item[0]['width'];
    }
    protected $listeners = ['listenerReferenceHere', 'create', 'cancelCreateProduct'];

    public function listenerReferenceHere($data)
    {
        // dd(44);
        if (isset($data['var1'])) {
            // dd($data['var1']);
            if (($data['var1'] == "unit_id" || $data['var1'] == "basic_unit_id") && $data['var3'] !== '') {
                $this->rows[$data['var3']][$data['var1']] = $data['var2'];
                if ($data['var1'] == "unit_id") {
                    $this->changeUnit($data['var3']);
                }
            } else if ($data['var1'] == "price_customer_types" && $data['var3'] !== '') {
                $row = $this->rows[$data['var3']]['prices'][$data['var4']]['price_customer_types'] = $data['var2'];
                // dd($data['var2']);
                // $row[$data['var4']]['price_customer_types']=$data['var2'];

            } else {
                $this->item[0][$data['var1']] = $data['var2'];
                if ($data['var1'] == 'category_id') {
                    $this->subcategories1 = Category::where('parent_id', $this->item[0]['category_id'])->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if ($data['var1'] == 'subcategory_id1') {
                    $this->subcategories1 = Category::where('parent_id', $this->item[0]['category_id'])->orderBy('name', 'asc')->pluck('name', 'id');
                    $this->subcategories2 = Category::where('parent_id', $this->item[0]['subcategory_id1'])->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if ($data['var1'] == 'subcategory_id2') {
                    $this->subcategories2 = Category::where('parent_id', $this->item[0]['subcategory_id1'])->orderBy('name', 'asc')->pluck('name', 'id');
                    $this->subcategories3 = Category::where('parent_id', $this->item[0]['subcategory_id2'])->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if ($data['var1'] == 'subcategory_id3') {
                    $this->subcategories3 = Category::where('parent_id', $this->item[0]['subcategory_id2'])->orderBy('name', 'asc')->pluck('name', 'id');
                }
            }
            $this->subcategories = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            $this->exchange_rate = $this->changeExchangeRate();
            $this->changeExchangeRateBasedPrices();
        }
    }
    public function render()
    {
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $this->branches = Branch::where('type', 'branch')->orderBy('created_by','desc')->pluck('name','id');
        $this->discount_from_original_price = System::getProperty('discount_from_original_price');
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $categories = Category::orderBy('name', 'asc')->where('parent_id', null)->pluck('name', 'id')->toArray();
        $this->subcategories = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $products = Product::all();
        $stores = Store::getDropdown();
        $units = Unit::orderBy('created_at', 'desc')->get();
        $basic_units = Unit::orderBy('created_at', 'desc')->pluck('name', 'id');
        $product_taxes = Tax::select('name', 'id', 'status')->get();
        $customer_types = CustomerType::latest()->get();
        $this->dispatchBrowserEvent('initialize-select2');

        return view(
            'livewire.initial-balance.edit',
            compact(
                'stores',
                'suppliers',
                'products',
                'product_taxes',
                'units',
                'basic_units',
                'categories',
                'customer_types',
                'selected_currencies'
            )
        );
    }


    public function mount($stockId)
    {
        $this->stockId = $stockId;
        $recent_stock = StockTransaction::where('id', $stockId)->where('type', 'initial_balance')->orderBy('created_at', 'desc')->first();
        if (!empty($recent_stock)) {
            $this->transaction_currency = $recent_stock->transaction_currency;
            $this->item[0]['stockId'] = $stockId;
            $this->item[0]['id'] = $recent_stock->add_stock_lines->first()->product->id;
            $this->item[0]['store_id'] = $recent_stock->store_id;
            $this->item[0]['supplier_id'] = $recent_stock->supplier_id;
            $this->item[0]['name'] = $recent_stock->add_stock_lines->first()->product->name ?? null;
            $this->item[0]['exchange_rate'] = $recent_stock->exchange_rate;
            $this->item[0]['balance_return_request'] = $recent_stock->add_stock_lines->first()->product->balance_return_request;
            $this->item[0]['category_id'] = $recent_stock->add_stock_lines->first()->product->category_id ?? null;
            $this->item[0]['product_symbol'] = $recent_stock->add_stock_lines->first()->product->product_symbol ?? null;
            if (!empty($this->item[0]['category_id'])) {
                $this->subcategories1 = Category::where('parent_id', $this->item[0]['category_id'])->orderBy('name', 'asc')->pluck('name', 'id');
            }
            $this->item[0]['subcategory_id1'] = $recent_stock->add_stock_lines->first()->product->subcategory_id1 ?? null;
            if (!empty($this->item[0]['subcategory_id1'])) {
                $this->subcategories2 = Category::where('parent_id', $this->item[0]['subcategory_id1'])->orderBy('name', 'asc')->pluck('name', 'id');
            }
            $this->item[0]['subcategory_id2'] = $recent_stock->add_stock_lines->first()->product->subcategory_id2 ?? null;
            if (!empty($this->item[0]['subcategory_id2'])) {
                $this->subcategories3 = Category::where('parent_id', $this->item[0]['subcategory_id2'])->orderBy('name', 'asc')->pluck('name', 'id');
            }
            $this->item[0]['subcategory_id3'] = $recent_stock->add_stock_lines->first()->product->subcategory_id3 ?? null;
            $this->item[0]['height'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->height ?? null;
            $this->item[0]['length'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->length ?? null;
            $this->item[0]['width'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->width ?? null;
            $this->item[0]['weight'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->weight ?? null;
            $this->item[0]['size'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->size ?? null;
            $this->item[0]['method'] = $recent_stock->add_stock_lines->first()->product->method ?? null;
            $this->item[0]['product_tax_id'] = ProductTax::where('product_id', $this->item[0]['id'])->first()->product_tax_id ?? null;
            $this->exchange_rate = $this->num_uf($this->changeExchangeRate());
            foreach ($recent_stock->add_stock_lines as $stock) {
                $newRow = [
                    'stock_line_id' => $stock->id,
                    'id' => $stock->variation->id, 'sku' => $stock->variation->sku, 'quantity' => $stock->quantity,
                    'fill_quantity' => $stock->fill_quantity,
                    'fill_type' => $stock->fill_type,
                    'purchase_price' =>  ($this->transaction_currency == 2) ? $stock->dollar_purchase_price * $this->num_uf($this->exchangeRate) : $stock->purchase_price ,
                    'selling_price' =>  ($this->transaction_currency == 2) ? $stock->dollar_sell_price * $this->num_uf($this->exchangeRate) : $stock->sell_price,
                    'dollar_purchase_price' => ($this->transaction_currency == 2) ? $stock->dollar_purchase_price : $stock->purchase_price / $this->num_uf($this->exchangeRate),
                    'dollar_selling_price' => ($this->transaction_currency == 2) ? $stock->dollar_sell_price  : $stock->sell_price / $this->num_uf($this->exchangeRate),
                    'unit_id' => $stock->variation->unit_id,
                    'basic_unit_id' => $stock->variation->basic_unit_id,
                    'change_price_stock' => '',
                    'equal' => $stock->variation->equal,
                    'fill_currency'=>'dinar',
                    'prices' => [],
                ];

                $this->unit_variations[]=$stock->variation->unit_id;

                // $new_price=[];
                if (!empty($stock->prices)) {
                    foreach ($stock->prices as $price) {
                        $new_price = [
                            'id' => $price->id,
                            'price_type' => $price->price_type,
                            'price_category' => $price->price_category,
                            'price' => $price->price,
                            'price_currency'=>'dollar',
                            'discount_quantity' => $price->quantity,
                            'bonus_quantity' => $price->bonus_quantity,
                            'price_customer_types' => $price->price_customer_types,
                            'price_after_desc' => $price->price_customers,
                            'dinar_price_after_desc' => $price->dinar_price_customers,
                            'product_price_id' => $price->id,
                            'total_price'=>$price->total_price,
                            'piece_price'=>$price->piece_price,
                            'dinar_price' => $price->dinar_price,
                            'dinar_total_price'=>$price->dinar_total_price,
                            'dinar_piece_price'=>$price->dinar_piece_price,
                        ];
                        array_unshift($newRow['prices'], $new_price);
                    }
                } else {
                    $new_price = [
                        'price_type' => null,
                        'price_category' => null,
                        'price' => null,
                        'price_currency'=>'dollar',
                        'discount_quantity' => null,
                        'bonus_quantity' => null,
                        'price_customer_types' => null,
                        'price_after_desc' => null,
                        'dinar_price_after_desc' => null,
                        'total_price'=>null,
                        'piece_price'=>null,
                        'dinar_price' => null,
                        'dinar_total_price'=>null,
                        'dinar_piece_price'=>null,
                    ];
                    array_unshift($newRow['prices'], $new_price);
                }
                array_unshift($this->rows, $newRow);
            }
            $this->basic_unit_variations = Unit::whereIn('id',$this->unit_variations)->orderBy('name', 'asc')->pluck('name', 'id');
            $this->item[0]['basic_unit_variation_id'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->variation_id ?? null;


        }
        $this->calculateTotalQuantity();
        $this->dispatchBrowserEvent('initialize-select2');
    }
    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function setSubCategoryValue($value)
    {

        $this->dispatchBrowserEvent('show-modal');
    }
    public function addSubCategory()
    {
    }
    public function calculateTotalQuantity()
    {
        $this->totalQuantity = 0;
        foreach ($this->rows as $index => $row) {
            $this->totalQuantity += (int)$this->rows[$index]['quantity'];
        }
    }
    public function addRaw()
    {
        $newRow = [
            'stock_line_id' => '',
            'id' => '', 'sku' => '', 'quantity' => '',
            'fill_quantity' => '',
            'fill_type' => 'fixed',
            'fill_currency'=>'dinar',
            'purchase_price' => '',
            'selling_price' => '',
            'dollar_purchase_price' => '',
            'dollar_selling_price' => '',
            'unit_id' => '',
            'basic_unit_id' => '',
            'change_price_stock' => '',
            'equal' => '',
            'prices' => [
                [
                    'id' => null,
                    'price_type' => null,
                    'price_category' => null,
                    'price' => null,
                    'price_currency'=>'dollar',
                    'dinar_price' => null,
                    'discount_quantity' => null,
                    'bonus_quantity' => null,
                    'price_customer_types' => null,
                    'price_after_desc' => null,
                    'dinar_price_after_desc' => null,
                    'total_price'=>null,
                    'piece_price'=>null,
                    'dinar_price' => null,
                    'dinar_total_price'=>null,
                    'dinar_piece_price'=>null,
                ],
            ],
        ];
        array_unshift($this->rows, $newRow);
        // $this->dispatchBrowserEvent('initialize-select2');
    }
    public function changeUnit($index)
    {
        ///////////////////////////product dimension variation ///////////////////
        foreach($this->rows as $i=>$row){
            if(!empty($this->rows[$i]['unit_id']) && $this->rows[$i]['unit_id']!==''){
                $this->unit_variations[]=$this->rows[$i]['unit_id'];
            }
        }
        $this->basic_unit_variations = Unit::whereIn('id',$this->unit_variations)->orderBy('name', 'asc')->pluck('name', 'id');
        ////////////////////////////////////////////////////////////////////////////
        //////////////////////////////// calculate row based on other rows//////////////
        $unit = $this->rows[$index]['unit_id'];
        $unit_index = '';
        foreach ($this->rows as $i => $item) {
            if ($item['basic_unit_id'] === $unit) {
                $unit_index = $i;
                break;
            }
        }
        if ($unit_index !== '') {
            $this->rows[$index]['equal'] = 1;
            $this->rows[$index]['quantity'] = 0;
            $this->rows[$index]['fill_type'] = $this->rows[$unit_index]['fill_type'];
            if ((float)$this->rows[$unit_index]['equal'] != 0) {
                $this->rows[$index]['dollar_purchase_price'] = ($this->num_uf($this->rows[$unit_index]['dollar_purchase_price']) / (float)$this->rows[$unit_index]['equal']);
                $this->rows[$index]['dollar_selling_price'] = ($this->num_uf($this->rows[$unit_index]['dollar_selling_price']) / (float)$this->rows[$unit_index]['equal']);
                $this->rows[$index]['purchase_price'] = ($this->num_uf($this->rows[$unit_index]['purchase_price']) / (float)$this->rows[$unit_index]['equal']);
                $this->rows[$index]['selling_price'] = ($this->num_uf($this->rows[$unit_index]['selling_price']) / (float)$this->rows[$unit_index]['equal']);
                if ($this->rows[$index]['fill_type'] == "fixed") {
                    $this->rows[$index]['fill_quantity'] = (float)$this->rows[$unit_index]['fill_quantity'] / (float)$this->rows[$unit_index]['equal'];
                    $this->rows[$index]['fill_currency'] = $this->rows[$unit_index]['fill_currency'];
                } else {
                    $this->rows[$index]['fill_quantity'] = $this->rows[$unit_index]['fill_quantity'];
                }
                // $this->changePurchasePrice($index);
            }
        }
    }
    public function changeBaseUnit($index)
    {
         //////////////////////////////// calculate row based on other rows//////////////
        $base_unit = $this->rows[$index]['basic_unit_id'];
        $unit_index = '';
        $basic_unit_index = '';
        foreach ($this->rows as $i => $item) {
            if($i !=$index){
                if ($item['unit_id'] === $base_unit) {
                    $unit_index = $i;
                    break;
                }
            }
        }
        if ($unit_index == '') {
            foreach ($this->rows as $i => $item) {
                if($i !=$index){
                    if ($item['basic_unit_id'] === $base_unit) {
                        $basic_unit_index = $i;
                        break;
                    }
                }
            }
        }
        if ($unit_index !== '') {
            // $this->rows[$index]['equal'] = 1;
            $this->rows[$index]['quantity'] = 0;
            $this->rows[$index]['fill_type'] = $this->rows[$unit_index]['fill_type'];
            if ((float)$this->rows[$unit_index]['equal'] != 0) {
                $this->rows[$index]['dollar_purchase_price'] = ($this->num_uf($this->rows[$unit_index]['dollar_purchase_price'])) * (float)$this->rows[$index]['equal'];
                $this->rows[$index]['dollar_selling_price'] = ($this->num_uf($this->rows[$unit_index]['dollar_selling_price'])) * (float)$this->rows[$index]['equal'];
                $this->rows[$index]['purchase_price'] = ($this->num_uf($this->rows[$unit_index]['purchase_price'])) * (float)$this->rows[$index]['equal'];
                $this->rows[$index]['selling_price'] = ($this->num_uf($this->rows[$unit_index]['selling_price'])) * (float)$this->rows[$index]['equal'];
                // dd($this->rows[$unit_index]);
                if ($this->rows[$index]['fill_type'] == "fixed") {
                    $this->rows[$index]['fill_quantity'] = ($this->num_uf($this->rows[$unit_index]['fill_quantity']) )*(float)$this->rows[$index]['equal'];
                    $this->rows[$index]['fill_currency'] = $this->rows[$unit_index]['fill_currency'];
                } else {
                    $this->rows[$index]['fill_quantity'] = $this->rows[$unit_index]['fill_quantity'];
                }
                // $this->changePurchasePrice($index);
            }
        }else{
            if ($basic_unit_index !== '') {
                $this->rows[$index]['quantity'] = 0;
                $this->rows[$index]['fill_type'] = $this->rows[$basic_unit_index]['fill_type'];
                if ((float)$this->rows[$basic_unit_index]['equal'] != 0) {
                    $this->rows[$index]['dollar_purchase_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['dollar_purchase_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'],3);
                    $this->rows[$index]['purchase_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['purchase_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'],3);
                    $this->rows[$index]['dollar_selling_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['dollar_selling_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'],3);
                    $this->rows[$index]['selling_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['selling_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'],3);
                    // dd($this->rows[$basic_unit_index]);
                    if ($this->rows[$index]['fill_type'] == "fixed") {
                        $this->rows[$index]['fill_quantity'] =  number_format(((float)$this->rows[$basic_unit_index]['fill_quantity'] / (float)$this->rows[$basic_unit_index]['equal'] )*(float)$this->rows[$index]['equal'],3);
                        $this->rows[$index]['fill_currency'] = $this->rows[$basic_unit_index]['fill_currency'];
                    } else {
                        $this->rows[$index]['fill_quantity'] = $this->rows[$basic_unit_index]['fill_quantity'];
                    }
                    // $this->changePurchasePrice($index);
                }
            }
        }
    }
    public function edit()
    {
        //////////
        $this->updatedInputs();

        try {
            if (empty($this->rows)) {
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.add_sku_with_sku_for_product'),]);
            } else {
                DB::beginTransaction();
                // Add stock transaction
                $transaction = StockTransaction::find($this->item[0]['stockId']);
                $transaction->store_id = $this->item[0]['store_id'];
                $transaction->status = 'received';
                $transaction->order_date = Carbon::now();
                $transaction->transaction_date =  Carbon::now();
                $transaction->purchase_type = 'local';
                $transaction->type = 'initial_balance';
                $transaction->supplier_id = !empty($this->item[0]['supplier_id']) ? $this->item[0]['supplier_id'] : null;
                $transaction->transaction_currency = $this->transaction_currency;
                $transaction->updated_by = Auth::user()->id;
                $transaction->save();
                //Edit Product
                $product = Product::find($this->item[0]['id']);
                $product->name = $this->item[0]['name'];
                $product->sku = "Default";
                $product->category_id = $this->item[0]['category_id'];
                $product->subcategory_id1 = $this->item[0]['subcategory_id1'];
                $product->subcategory_id2 = $this->item[0]['subcategory_id2'];
                $product->subcategory_id3 = $this->item[0]['subcategory_id3'];
                $product->method = $this->item[0]['method'];
                $product->product_symbol = $this->item[0]['product_symbol'];
                $product->balance_return_request=$this->item[0]['balance_return_request']??0;
                $product->save();
                // add  products to stock lines
                if (!empty($this->item[0]['product_tax_id'])) {
                    $product_tax = ProductTax::where('product_tax_id',$this->item[0]['product_tax_id'])->first();
                    if (!empty($product_tax)) {
                        $product_tax->update([
                            'product_tax_id' => $this->item[0]['product_tax_id'],
                        ]);
                    } else {
                        ProductTax::create([
                            'product_tax_id' => $this->item[0]['product_tax_id'],
                            'product_id' => $this->item[0]['id'],
                        ]);
                    }
                }
                foreach ($this->rows as $index => $row) {
                    $Variation = [];
                    if (isset($this->rows[$index]['id'])) {
                        $Variation = Variation::find($this->rows[$index]['id']);
                    } else {
                        $Variation = new Variation();
                    }
                    $Variation->sku = !empty($this->rows[$index]['sku']) ? $this->rows[$index]['sku'] : $this->generateSku($product->name);
                    $Variation->equal = !empty($this->rows[$index]['equal']) ? (float)$this->rows[$index]['equal'] : null;
                    $Variation->product_id = $product->id;
                    $Variation->unit_id = $this->rows[$index]['unit_id'] !== "" ? $this->rows[$index]['unit_id'] : null;
                    $Variation->basic_unit_id = $this->rows[$index]['basic_unit_id'] !== "" ? $this->rows[$index]['basic_unit_id'] : null;
                    $Variation->created_by = Auth::user()->id;
                    $Variation->product_symbol = $this->item[0]['product_symbol'] .($index+1) ;
                    $Variation->save();
                    ////////////////

                    $add_stock_data = [
                        'product_id' => $product->id,
                        'variation_id' => $Variation->id,
                        'stock_transaction_id' => $transaction->id,
                        'quantity' => $this->rows[$index]['quantity'] !== '' ? $this->rows[$index]['quantity'] : 0,
                        'fill_type' => isset($this->rows[$index]['fill_type']) ? $this->rows[$index]['fill_type'] : '',
                        'fill_quantity' => isset($this->rows[$index]['fill_quantity']) ? $this->rows[$index]['fill_quantity'] : 0,
                        'purchase_price' =>  ($this->transaction_currency != 2) ? $this->rows[$index]['purchase_price'] : null,
                        'sell_price' =>  ($this->transaction_currency != 2) ? $this->rows[$index]['selling_price'] : null,
                        'dollar_purchase_price' =>  ($this->transaction_currency == 2) ? $this->rows[$index]['dollar_purchase_price'] : null,
                        'dollar_sell_price' =>  ($this->transaction_currency == 2) ? $this->rows[$index]['dollar_selling_price'] : null,
                        'dollar_sub_total' => !empty($this->dollar_sub_total($index)) ? (float)$this->dollar_sub_total($index) : null,
                        'exchange_rate' => !empty($this->exchange_rate) ? $this->exchange_rate : null,
                        // 'cost' => !empty($this->rows[$index]['cost']) ?  $this->rows[$index]['cost'] : null,
                        // 'dollar_cost' => !empty($this->rows[$index]['dollar_cost']) ? $this->rows[$index]['dollar_cost'] : null,
                        // 'dollar_final_cost' => !empty($this->dollar_total_cost[$index]) ? $this->dollar_total_cost[$index] : null,
                        // 'final_cost' => !empty($this->total_cost[$index]) ? $this->total_cost[$index] : null,
                        'sub_total' => !empty($this->sub_total[$index]) ? (float)$this->sub_total[$index] : null,
                    ];
                    if (!empty($this->rows[$index]['stock_line_id'])) {
                        $stock_line = AddStockLine::find($this->rows[$index]['stock_line_id']);
                        $stock_line->update($add_stock_data);
                    } else {
                        $stock_line = AddStockLine::create($add_stock_data);
                    }
                    $this->updateProductQuantityStore($product->id, $transaction->store_id,  $this->rows[$index]['quantity'], 0);
                    if (!empty($this->deleted_items)) {
                        foreach ($this->deleted_items as $delete_line) {
                            $line = AddStockLine::find($delete_line);
                            $line->forceDelete();
                            $price = ProductPrice::where('stock_line_id', $delete_line)->delete();
                        }
                    }
                    if (!empty($row['prices'])) {
                        foreach ($row['prices'] as $price) {
                            $price_data = [
                                'variation_id' => $Variation->id,
                                'stock_line_id' => $stock_line->id,
                                'price_type' => isset($price['price_type']) ? $price['price_type'] : null,
                                'price' => !empty($price['price']) ? $price['price'] : null,
                                'dinar_price' => !empty($price['dinar_price']) ? $price['dinar_price'] : null,
                                'price_category' => isset($price['price_category']) ? $price['price_category'] : null,
                                'price_customers'=>!empty($price['price_after_desc']) ? $price['price_after_desc'] : null,
                                'dinar_price_customers'=>!empty($price['dinar_price_after_desc']) ? $price['dinar_price_after_desc'] : null,
                                'quantity' => isset($price['discount_quantity']) ? $price['discount_quantity'] : null,
                                'bonus_quantity' => isset($price['bonus_quantity']) ? $price['bonus_quantity'] : null,
                                'price_customer_types' => !empty($price['price_customer_types']) ? $price['price_customer_types'] : [],
                                'created_by' => Auth::user()->id,
                                'total_price'=>isset($price['total_price']) ? $price['total_price'] : null,
                                'dinar_total_price'=>isset($price['dinar_total_price']) ? $price['dinar_total_price'] : null,
                                'piece_price'=>isset($price['piece_price']) ? $price['piece_price'] : null,
                                'dinar_piece_price'=>isset($price['dinar_piece_price']) ? $price['dinar_piece_price'] : null,
                            ];

                            if (!empty($price['id'])) {
                                $product_price = ProductPrice::find($price['id']);
                                $product_price->update($price_data);
                            } else {
                                $product_price = ProductPrice::create($price_data);
                            }
                            if (!empty($this->deleted_prices)) {
                                foreach ($this->deleted_prices as $delete_price) {
                                    $price = ProductPrice::find($delete_price);
                                    if (!empty($price)) {
                                        $price->delete();
                                    }
                                }
                            }
                        }
                    }
                }
                if ($this->item[0]['height'] ==(''||0) && $this->item[0]['length'] ==(''||0) && $this->item[0]['width'] ==(''||0)
                    || $this->item[0]['size'] ==(''||0) && $this->item[0]['weight'] ==(''||0)) {
                        ProductDimension::where('product_id',$product->id)->delete();
                    }else{
                    ProductDimension::where('product_id',$product->id)->update([
                        'product_id'=>$product->id,
                        'variation_id'=>!empty($this->item[0]['basic_unit_variation_id'])?(Variation::where('product_id',$product->id)->where('unit_id',$this->item[0]['basic_unit_variation_id'])->first()->id??''):null,
                        'height' => !empty($this->item[0]['height'])?$this->item[0]['height']:0,
                        'length' => !empty($this->item[0]['length'])?$this->item[0]['length']:0,
                        'width '=> !empty($this->item[0]['width'])?$this->item[0]['width']:0,
                        'weight' => !empty($this->item[0]['weight'])?$this->item[0]['weight']:0,
                        'size'=> !empty($this->item[0]['size'])?$this->item[0]['size']:0,
                    ]);
                }
                DB::commit();
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => __('lang.success'),]);
                return redirect('/initial-balance/' . $this->stockId . '/edit');
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.something_went_wrongs'),]);
            dd($e);
        }
    }
    public function generateSku($name, $number = 1)
    {
        $name_array = explode(" ", $name);
        $sku = '';
        foreach ($name_array as $w) {
            if (!empty($w)) {
                if (!preg_match('/[^A-Za-z0-9]/', $w)) {
                    $sku .= $w[0];
                }
            }
        }
        $sku = $sku . $number;
        $sku_exist = Product::where('sku', $sku)->exists();

        if ($sku_exist) {
            return $this->generateSku($name, $number + 1);
        } else {
            return $sku;
        }
    }
    public function confirmCreateProduct()
    {
        $product_exist = Product::where('name', $this->item[0]['name'])->exists();
        $this->edit_product = Product::where('name', $this->item[0]['name'])->first();
        if ($product_exist) {
            $this->dispatchBrowserEvent('showCreateProductConfirmation');
        }
    }
    public function create()
    {
        $this->subcategories1 = Category::where('parent_id', $this->edit_product['category_id'])->orderBy('name', 'asc')->pluck('name', 'id');
        $this->subcategories2 = Category::where('parent_id', $this->edit_product['subcategory_id1'])->orderBy('name', 'asc')->pluck('name', 'id');
        $this->subcategories3 = Category::where('parent_id', $this->edit_product['subcategory_id2'])->orderBy('name', 'asc')->pluck('name', 'id');
        $this->item[0] =
            [
                'isExist' => 1,
                'id' => $this->edit_product['id'],
                'name' => $this->edit_product['name'],
                'category_id' => $this->edit_product['category_id'],
                'subcategory_id1' => $this->edit_product['subcategory_id1'],
                'subcategory_id2' => $this->edit_product['subcategory_id2'],
                'subcategory_id3' => $this->edit_product['subcategory_id3'],
                'weight' => $this->edit_product['weight'],
                'width' => $this->edit_product['width'],
                'height' => $this->edit_product['height'],
                'length' => $this->edit_product['length'],
                'size' => $this->edit_product['size'],
                'method' => '',
                'status' => '',
                'change_current_stock' => 0,
                'exchange_rate' => $this->exchange_rate,
                'store_id' => '',
                'supplier_id' => '', 'product_tax_id' => ''
            ];



        $variations = Variation::where('product_id', $this->edit_product['id'])->get();
        foreach ($variations as $variation) {
            $newRow = [
                'id' => $variation->id,
                'sku' => $variation->sku,
                'quantity' => '',
                'fill_quantity' => '',
                'fill_currency'=>'dinar',
                'fill_type' => 'fixed',
                'purchase_price' => '',
                'selling_price' => '',
                'dollar_purchase_price' => '',
                'dollar_selling_price' => '',
                'unit_id' => $variation->unit_id,
                'basic_unit_id' => $variation->basic_unit_id,
                'change_price_stock' => '',
                'equal' => $variation->equal,
                'prices' => [
                    [
                        'price_type' => null,
                        'price_category' => null,
                        'price' => null,
                        'dinar_price' => null,
                        'price_currency'=>'dollar',
                        'discount_quantity' => null,
                        'bonus_quantity' => null,
                        'price_customer_types' => null,
                        'price_after_desc' => null,
                        'dinar_price_after_desc' => null,
                        'total_price'=>null,
                        'piece_price'=>null,
                        'dinar_total_price'=>null,
                        'dinar_piece_price'=>null,
                    ],
                ],
            ];
            $this->rows[] = $newRow;
        }
    }
    public function cancelCreateProduct()
    {
        $this->item[0]['name'] = '';
    }

    public function get_product($index)
    {
        return Unit::where('id', $this->rows[$index]['unit_id'])->first();
    }

    public function sub_total($index)
    {
        if (isset($this->rows[$index]['quantity']) && (isset($this->rows[$index]['purchase_price']) || isset($this->dollar_purchase_price[$index]))) {
            // convert purchase price from Dollar To Dinar
            $purchase_price = $this->convertDollarPrice($index);

            if (isset($this->get_product($index)->base_unit_multiplier)) {
                $this->base_unit[$index] = $this->get_product($index)->base_unit_multiplier;
            } else {
                $this->base_unit[$index] = 1;
            }
            $this->sub_total[$index] = (int)$this->rows[$index]['quantity'] * (float)$purchase_price * (float)$this->rows[$index]['equal'];

            return number_format($this->sub_total[$index], 2);
        }
    }

    public function dollar_sub_total($index)
    {
        if (isset($this->rows[$index]['quantity']) && (isset($this->rows[$index]['dollar_purchase_price']) || isset($this->rows[$index]['purchase_price']))) {
            // convert purchase price from Dinar To Dollar
            $purchase_price = $this->convertDinarPrice($index);
            // if(isset($this->get_product($index)->base_unit_multiplier)){
            //     $this->base_unit[$index]  = $this->get_product($index)->base_unit_multiplier;
            // }
            // else{
            //     $this->base_unit[$index] = 1;
            // }
            $this->dollar_sub_total[$index] = (int)$this->rows[$index]['quantity'] * (float)$purchase_price * (float)$this->rows[$index]['equal'];

            return number_format($this->dollar_sub_total[$index], 2);
        } else {
            $this->quantity[$index] = 0;
            $this->dollar_purchase_price[$index] = 0;
        }
    }

    public function total_quantity($index)
    {
        //        if (isset($this->rows[$index]['equal'])){
        //            return  (float)$this->rows[$index]['equal'] * (int)$this->rows[$index]['quantity'];
        //        }
        //        else{
        return  (int)$this->rows[$index]['quantity'];
        //        }

    }

    public function sum_sub_total()
    {
        return number_format(array_sum($this->sub_total), 2);
    }

    public function sum_dollar_tsub_total()
    {
        return number_format(array_sum($this->dollar_sub_total), 2);
    }

    public function delete_product($index)
    {
        if (!empty($this->rows[$index]['stock_line_id'])) {
            $this->deleted_items[] = $this->rows[$index]['stock_line_id'];
        }
        unset($this->rows[$index]);
    }

    public function convertDollarPrice($index)
    {
        if (empty($this->rows[$index]['purchase_price']) && !empty($this->rows[$index]['dollar_purchase_price'])) {
            (float)$purchase_price = (float)$this->rows[$index]['dollar_purchase_price'] * $this->exchange_rate;
        } else {
            $purchase_price = $this->rows[$index]['purchase_price'];
        }
        return $purchase_price;
    }
    public function convertDinarPrice($index)
    {
        //        dd($this->purchase_price[$index]);
        if (!empty($this->rows[$index]['purchase_price']) && empty($this->rows[$index]['dollar_purchase_price'])) {
            $purchase_price = $this->rows[$index]['purchase_price'] / $this->exchange_rate;
        } else {
            $purchase_price = $this->rows[$index]['dollar_purchase_price'];
        }
        return $purchase_price;
    }
    public function changeExchangeRate()
    {
        if (isset($this->item[0]['supplier_id'])) {
            $supplier = Supplier::where('id', $this->item[0]['supplier_id'])
                ->where(function ($query) {
                    $query->where('end_date', '>=', Carbon::now())
                        ->orWhereNull('end_date');
                })->first();
            // ->where('end_date','>=',Carbon::now())->orWhere('end_date','=',null)->first();
            if (isset($supplier->exchange_rate)) {
                return $this->exchangeRate =  str_replace(',', '', $supplier->exchange_rate);
            } else
                return $this->exchangeRate = System::getProperty('dollar_exchange');
        } else {
            return $this->exchangeRate = System::getProperty('dollar_exchange');
        }
    }
    public function changePurchasePrice($index)
    {
        $this->rows[$index]['purchase_price'] = (float)$this->rows[$index]['dollar_purchase_price'] * (float)$this->exchange_rate;
        $this->changeFilling($index);
    }
    public function changeDollarPurchasePrice($index)
    {
        $this->rows[$index]['dollar_purchase_price'] = number_format((float)$this->num_uf($this->rows[$index]['purchase_price']) / (float)$this->exchange_rate,3) ;
        $this->changeDollarFilling($index);
    }
    public function changeExchangeRateBasedPrices()
    {
        // $this->exchange_rate=$this->changeExchangeRate();
        foreach ($this->rows as $index => $row) {
            if ($this->rows[$index]['purchase_price'] != "") {
                $this->changePurchasePrice($index);
                $this->sub_total($index);
                $this->dollar_sub_total($index);
            }
        }
    }
    public function changeFilling($index)
    {
        if (!empty($this->rows[$index]['fill_quantity'])) {
            if ($this->rows[$index]['purchase_price'] != "" && ($this->rows[$index]['fill_currency'] == "dollar")) {
                if ($this->rows[$index]['fill_type'] == 'fixed') {
                        $this->rows[$index]['dollar_selling_price'] = number_format(($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']), 3);
                        $this->rows[$index]['selling_price'] = number_format(($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']) * $this->exchange_rate, 3);
                } else {
                $percent = ($this->num_uf($this->rows[$index]['dollar_purchase_price']) * (float)$this->rows[$index]['fill_quantity']) / 100;
                $this->rows[$index]['dollar_selling_price'] = number_format(((float)$this->rows[$index]['dollar_purchase_price'] + $percent),3) ;
                $this->rows[$index]['selling_price'] =  number_format(((float)$this->rows[$index]['dollar_purchase_price'] + $percent) * $this->exchange_rate,3);
                }
            }
            else{
                $this->changeDollarFilling($index);
            }
        }
    }
    public function changeDollarFilling($index)
    {
        if (!empty($this->rows[$index]['fill_quantity'])) {
            if ($this->rows[$index]['dollar_purchase_price'] != "" && ($this->rows[$index]['fill_currency'] == "dinar")) {
                if ($this->rows[$index]['fill_type'] == 'fixed') {
                        $this->rows[$index]['selling_price'] = number_format(((float)$this->num_uf($this->rows[$index]['purchase_price']) + (float)$this->rows[$index]['fill_quantity']), 3);
                        $this->rows[$index]['dollar_selling_price'] = number_format((float)$this->num_uf($this->rows[$index]['selling_price']) / (float)$this->exchange_rate, 3);
                    } else {
                    $percent = ($this->num_uf($this->rows[$index]['purchase_price']) * (float)$this->rows[$index]['fill_quantity']) / 100;
                    $this->rows[$index]['selling_price'] =  number_format(($this->num_uf($this->rows[$index]['purchase_price']) + $percent),3) ;
                    $this->rows[$index]['dollar_selling_price'] =  number_format(((float)$this->num_uf($this->rows[$index]['purchase_price']) + $percent) / $this->exchange_rate  ,3) ;
                }
            }
        }
    }
    public function changeSellingPrice($index)
    {
        $this->rows[$index]['selling_price'] = (float)$this->rows[$index]['dollar_selling_price'] * (float)$this->exchange_rate;
    }

    public function updateProductQuantityStore($product_id, $store_id, $new_quantity, $old_quantity = 0)
    {
        $qty_difference = (float)$new_quantity - (float)$old_quantity;

        if ($qty_difference != 0) {
            $product_store = ProductStore::where('product_id', $product_id)
                ->where('store_id', $store_id)
                ->first();

            if (empty($product_store)) {
                $product_store = new ProductStore();
                $product_store->product_id = $product_id;
                $product_store->store_id = $store_id;
                $product_store->quantity_available = 0;
            }

            $product_store->quantity_available += $qty_difference;
            $product_store->save();
        }

        return true;
    }
    public function addPriceRow($index)
    {
        $new_price = [];
        array_unshift($this->rows[$index]['prices'], $new_price);
    }
    public function delete_price_raw($index, $key)
    {
        if (!empty($this->rows[$index]['prices'][$key]['id'])) {
            $this->deleted_prices[] = $this->rows[$index]['prices'][$key]['id'];
        }
        unset($this->rows[$index]['prices'][$key]);
    }
    public function changePrice($index, $key, $via = 'price')
    {
        $this->discount_from_original_price = System::getProperty('discount_from_original_price');
        if (!empty($this->rows[$index]['selling_price']) || !empty($this->rows[$index]['dollar_selling_price'])) {
            $sell_price = $this->num_uf(!empty($this->rows[$index]['selling_price']) ? $this->num_uf($this->rows[$index]['selling_price']) :0);
            $dollar_sell_price = $this->num_uf(!empty($this->rows[$index]['dollar_selling_price']) ? $this->num_uf($this->rows[$index]['dollar_selling_price']) :0);
            $total_quantity = $this->num_uf($this->rows[$index]['prices'][$key]['discount_quantity']) + $this->num_uf($this->rows[$index]['prices'][$key]['bonus_quantity']);
            if(!empty($this->rows[$index]['prices'][$key]['dinar_price'])) {
                if(empty($this->discount_from_original_price) && !empty($this->rows[$index]['prices'][$key]['discount_quantity'])){
                    $total_sell_price = $this->num_uf($sell_price) * $this->num_uf($this->rows[$index]['prices'][$key]['discount_quantity']);
                    $total_dollar_sell_price = $this->num_uf($dollar_sell_price) * $this->num_uf($this->rows[$index]['prices'][$key]['discount_quantity']);
                    $sell_price = $this->num_uf($total_sell_price) / $total_quantity ;
                    $dollar_sell_price = $this->num_uf($total_dollar_sell_price) / $total_quantity;
                }
                if ($this->rows[$index]['prices'][$key]['price_type'] === 'fixed'){
                    if($this->rows[$index]['prices'][$key]['price_currency']=='dollar'){
                        if(!empty($this->rows[$index]['prices'][$key]['dinar_price'])) {
                            if($via == 'quantity' && !empty($this->rows[$index]['prices'][$key]['dinar_price']) && !empty($this->rows[$index]['prices'][$key]['price'])){
                                $actual_price = $this->rows[$index]['prices'][$key]['price'];
                            }
                            else{
                                $actual_price = $this->num_uf($this->rows[$index]['prices'][$key]['dinar_price']);
                                $this->rows[$index]['prices'][$key]['dinar_price'] = number_format((float)$this->rows[$index]['prices'][$key]['dinar_price'] * (float)$this->exchange_rate,3);
                            }
                        }
                        $dollar_price = number_format($this->num_uf($actual_price),3) ;
                    }
                    else{
                        $dollar_price = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_price']) / $this->num_uf($this->exchange_rate),3);
                    }
                    $this->rows[$index]['prices'][$key]['price'] = $this->num_uf($dollar_price) ;
                    $this->rows[$index]['prices'][$key]['dinar_price_after_desc'] = number_format($this->num_uf($sell_price) - $this->num_uf($this->rows[$index]['prices'][$key]['dinar_price']), 3);
                    $this->rows[$index]['prices'][$key]['price_after_desc'] = number_format($this->num_uf($dollar_sell_price) -$this->num_uf( (float)$this->rows[$index]['prices'][$key]['price']), 3);
                }
                elseif ($this->rows[$index]['prices'][$key]['price_type'] === 'percentage') {
                    $percent =(float) $this->rows[$index]['prices'][$key]['dinar_price'] / 100;
                    $this->rows[$index]['prices'][$key]['dinar_price_after_desc'] = number_format(($this->num_uf($sell_price) - ($percent * $this->num_uf($sell_price))), 3);
                    $this->rows[$index]['prices'][$key]['price_after_desc'] = number_format((float)($this->num_uf($dollar_sell_price) - ($percent * $this->num_uf($dollar_sell_price))), 3);
                    $this->rows[$index]['prices'][$key]['price'] = (float) $this->rows[$index]['prices'][$key]['dinar_price'] ;
                }
            }
            $price = !empty($this->rows[$index]['prices'][$key]['dinar_price_after_desc']) ? $this->num_uf($this->rows[$index]['prices'][$key]['dinar_price_after_desc']) : $this->num_uf($sell_price);
            $dollar_price = !empty($this->rows[$index]['prices'][$key]['price_after_desc']) ? $this->num_uf((float)$this->rows[$index]['prices'][$key]['price_after_desc']) : $this->num_uf($dollar_sell_price);
            if($this->discount_from_original_price == '0'){
                $this->rows[$index]['prices'][$key]['total_price'] = number_format($this->num_uf($dollar_price) * (!empty($this->rows[$index]['prices'][$key]['discount_quantity']) ? $this->num_uf( $total_quantity ) : 1),3) ;
                $this->rows[$index]['prices'][$key]['dinar_total_price'] = number_format($this->num_uf($price )* (!empty($this->rows[$index]['prices'][$key]['discount_quantity']) ? $this->num_uf( $total_quantity ) : 1),3) ;
            }
            else{
                $this->rows[$index]['prices'][$key]['total_price'] = number_format($this->num_uf($dollar_price) * (!empty($this->rows[$index]['prices'][$key]['discount_quantity']) ? $this->num_uf((float)$this->rows[$index]['prices'][$key]['discount_quantity']) : 1),3) ;
                $this->rows[$index]['prices'][$key]['dinar_total_price'] = number_format($this->num_uf($price )* (!empty($this->rows[$index]['prices'][$key]['discount_quantity']) ? $this->num_uf((float)$this->rows[$index]['prices'][$key]['discount_quantity']) : 1),3) ;
            }
            $this->rows[$index]['prices'][$key]['piece_price'] = number_format( (float)$this->num_uf($this->rows[$index]['prices'][$key]['total_price']) / (!empty($total_quantity) ? $this->num_uf($total_quantity) : 1),3);
            $this->rows[$index]['prices'][$key]['dinar_piece_price'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_total_price']) / (!empty($total_quantity) ? $this->num_uf($total_quantity) : 1),3) ;
        }
    }

    public function num_uf($input_number, $currency_details = null){
        $thousand_separator  = ',';
        $decimal_separator  = '.';
        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);
        return (float)$num;
    }
    // public function changePrice($index, $key)
    // {
    //     $this->discount_from_original_price = System::getProperty('discount_from_original_price');
    //     if (!empty($this->rows[$index]['selling_price']) || !empty($this->rows[$index]['dollar_selling_price'])) {
    //         $sell_price = !empty($this->rows[$index]['selling_price']) ? $this->rows[$index]['selling_price'] :0;
    //         $dollar_sell_price = !empty($this->rows[$index]['dollar_selling_price']) ? $this->rows[$index]['dollar_selling_price'] :0;
    //         $total_quantity = (float)$this->rows[$index]['prices'][$key]['discount_quantity'] +(float)$this->rows[$index]['prices'][$key]['bonus_quantity'];
    //         if(empty($this->discount_from_original_price) && !empty($this->rows[$index]['prices'][$key]['discount_quantity'])){
    //             $total_sell_price = $sell_price * $this->rows[$index]['prices'][$key]['discount_quantity'];
    //             $total_dollar_sell_price = $dollar_sell_price * $this->rows[$index]['prices'][$key]['discount_quantity'];
    //             $sell_price = $total_sell_price / $total_quantity ;
    //             $dollar_sell_price = $total_dollar_sell_price / $total_quantity ;
    //         }
    //         if ($this->rows[$index]['prices'][$key]['price_type'] === 'fixed') {
    //             $this->rows[$index]['prices'][$key]['dinar_price_after_desc'] = $sell_price - (float)$this->rows[$index]['prices'][$key]['price'];
    //             $this->rows[$index]['prices'][$key]['price_after_desc'] = $dollar_sell_price - (float)$this->rows[$index]['prices'][$key]['price'];
    //         } elseif ($this->rows[$index]['prices'][$key]['price_type'] === 'percentage') {
    //             $percent = $this->rows[$index]['prices'][$key]['price'] / 100;
    //             $this->rows[$index]['prices'][$key]['dinar_price_after_desc'] = (float)($sell_price - ($percent * $sell_price));
    //             $this->rows[$index]['prices'][$key]['price_after_desc'] = (float)($dollar_sell_price - ($percent * $dollar_sell_price));
    //         }
    //         $price = !empty($this->rows[$index]['prices'][$key]['dinar_price_after_desc']) ? (float)$this->rows[$index]['prices'][$key]['dinar_price_after_desc'] : $sell_price;
    //         $dollar_price = !empty($this->rows[$index]['prices'][$key]['price_after_desc']) ? (float)$this->rows[$index]['prices'][$key]['price_after_desc'] : $dollar_sell_price;
    //         if(empty($this->discount_from_original_price)){
    //             $this->rows[$index]['prices'][$key]['total_price']=(float)$dollar_price * (!empty($total_quantity) ? $total_quantity : 1);
    //             $this->rows[$index]['prices'][$key]['dinar_total_price']=(float)$this->rows[$index]['prices'][$key]['dinar_price_after_desc'] * ((float)$this->rows[$index]['prices'][$key]['discount_quantity'] +(float)$this->rows[$index]['prices'][$key]['bonus_quantity'] );
    //             $this->rows[$index]['prices'][$key]['piece_price'] = $this->rows[$index]['prices'][$key]['price_after_desc'];
    //             $this->rows[$index]['prices'][$key]['dinar_piece_price']=(float)$this->rows[$index]['prices'][$key]['dinar_total_price'] ;

    //         }
    //         else{
    //             $this->rows[$index]['prices'][$key]['total_price']=(float)$dollar_price * (!empty($this->rows[$index]['prices'][$key]['discount_quantity']) ? (float)$this->rows[$index]['prices'][$key]['discount_quantity'] : 1);
    //             $this->rows[$index]['prices'][$key]['dinar_total_price']=(float)$price * (!empty($this->rows[$index]['prices'][$key]['discount_quantity']) ? (float)$this->rows[$index]['prices'][$key]['discount_quantity'] : 1);
    //             $this->rows[$index]['prices'][$key]['piece_price']=(float)$this->rows[$index]['prices'][$key]['total_price'] / (!empty($total_quantity) ? $total_quantity : 1);
    //             $this->rows[$index]['prices'][$key]['dinar_piece_price']=(float)$this->rows[$index]['prices'][$key]['dinar_total_price'] / (!empty($total_quantity) ? $total_quantity : 1);

    //         }
    //      $this->rows[$index]['prices'][$key]['dinar_price']=$this->rows[$index]['prices'][$key]['price']* $this->exchange_rate;
    //     }
    // }
}
