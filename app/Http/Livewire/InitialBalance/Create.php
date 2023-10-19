<?php

namespace App\Http\Livewire\InitialBalance;

use App\Models\AddStockLine;
use App\Models\Category;
use App\Models\CustomerType;
use App\Models\Product;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
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
            'isExist' => 0, 'status' => '',
            'product_tax_id' => '',
            'change_current_stock' => 0,
            'method' => '',
            'exchange_rate' => 0,
            'product_symbol'=>'',
            'balance_return_request'=>''
        ]
    ];
    public $subcategories1 = [], $subcategories2 = [], $subcategories3 = [];
    public $quantity = [], $purchase_price = [], $selling_price = [],
        $base_unit = [], $divide_costs, $total_size = [], $total_weight = [],
        $sub_total = [], $change_price_stock = [], $store_id, $status,
        $supplier, $exchange_rate, $exchangeRate, $transaction_date,
        $dollar_purchase_price = [], $dollar_selling_price = [], $dollar_sub_total = [], $dollar_cost = [], $dollar_total_cost = [],
        $current_stock, $totalQuantity = 0, $edit_product = [], $current_sub_category,
        $clear_all_input_stock_form, $product_tax, $subcategories = [] , $discount_from_original_price;

    public $rows = [[
        'id' => '', 'sku' => '', 'quantity' => '',
        'fill_quantity' => '',
        'fill_type' => 'fixed',
        'purchase_price' => '',
        'selling_price' => '',
        'dollar_purchase_price' => '',
        'dollar_selling_price' => '',
        'unit_id' => '',
        'basic_unit_id' => '',
        'change_price_stock' => '',
        'equal' => '',
        'method'=>'',
        'prices' => [
            [
                'price_type' => null,
                'price_category' => null,
                'price' => null,
                'dinar_price' => null,
                'discount_quantity' => null,
                'bonus_quantity' => null,
                'price_customer_types' => null,
                'price_after_desc' => null,
                'dinar_price_after_desc' => null,
                'total_price' => null,
                'dinar_total_price' => null,
                'piece_price' => null,
                'dinar_piece_price' => null,
            ],
        ]
    ]];
    public function messages()
    {
        return [
            'rows.0.prices.0.discount_quantity.required_if' => __('lang.required')
        ];
    }
    public function updatedInputs()
    {
        $this->validate([
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
        'item.*.product_symbol'=>'required|unique:products,product_symbol,NULL,id,deleted_at,NULL',
        'rows.*.sku' => 'required',
        // 'rows.*.sku' => 'required|unique:variations,sku,NULL,id,deleted_at,NULL',
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
            'livewire.initial-balance.create',
            compact(
                'stores',
                'suppliers',
                'products',
                'product_taxes',
                'units',
                'basic_units',
                'categories',
                'customer_types'
            )
        );
    }
    public function mount()
    {
        $this->clear_all_input_stock_form = System::getProperty('clear_all_input_stock_form');
        if ($this->clear_all_input_stock_form == 0) {
            $recent_stock = [];
        } else {
            $recent_stock = StockTransaction::where('type', 'initial_balance')->orderBy('created_at', 'desc')->first();
            if (!empty($recent_stock)) {
                $this->item[0]['store_id'] = $recent_stock->store_id;
                $this->item[0]['supplier_id'] = $recent_stock->supplier_id;
                $this->item[0]['name'] = $recent_stock->add_stock_lines->first()->product->name ?? null;
                $this->item[0]['exchange_rate'] = $recent_stock->exchange_rate;
                $this->item[0]['category_id'] = $recent_stock->add_stock_lines->first()->product->category_id ?? null;
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
                $this->item[0]['height'] = $recent_stock->add_stock_lines->first()->product->height ?? null;
                $this->item[0]['length'] = $recent_stock->add_stock_lines->first()->product->length ?? null;
                $this->item[0]['width'] = $recent_stock->add_stock_lines->first()->product->width ?? null;
                $this->item[0]['weight'] = $recent_stock->add_stock_lines->first()->product->weight ?? null;
                $this->item[0]['size'] = $recent_stock->add_stock_lines->first()->product->size ?? null;
                $this->item[0]['balance_return_request'] = $recent_stock->add_stock_lines->first()->product->balance_return_request ?? null;


            }
        }
        $this->exchange_rate = $this->changeExchangeRate();
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
            'id' => '', 'sku' => '', 'quantity' => '',
            'fill_quantity' => '',
            'fill_type' => 'fixed',
            'purchase_price' => '',
            'selling_price' => '',
            'dollar_purchase_price' => '',
            'dollar_selling_price' => '',
            'unit_id' => '',
            'basic_unit_id' => '',
            'change_price_stock' => '',
            'equal' => '',
            'method'=>'',
            'prices' => [
                [
                    'price_type' => null,
                    'price_category' => null,
                    'price' => null,
                    'dinar_price' => null,
                    'discount_quantity' => null,
                    'bonus_quantity' => null,
                    'price_customer_types' => null,
                    'dinar_price_after_desc' => null,
                    'price_after_desc' => null,
                    'dinar_total_price' => null,
                    'total_price' => null,
                    'dinar_piece_price' => null,
                    'piece_price' => null,
                ],
            ],
        ];
        array_unshift($this->rows, $newRow);
        // $this->dispatchBrowserEvent('initialize-select2');
    }
    public function changeUnit($index)
    {
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
                $this->rows[$index]['dollar_purchase_price'] = ((float)$this->rows[$unit_index]['dollar_purchase_price'] / (float)$this->rows[$unit_index]['equal']);
                if ($this->rows[$index]['fill_type'] == "fixed") {
                    $this->rows[$index]['fill_quantity'] = (float)$this->rows[$unit_index]['fill_quantity'] / (float)$this->rows[$unit_index]['equal'];
                } else {
                    $this->rows[$index]['fill_quantity'] = $this->rows[$unit_index]['fill_quantity'];
                }
                $this->changePurchasePrice($index);
            }
        }
    }
    public function generateSymbol(){
        $name=$this->item[0]['name'];
        $name_array = explode(" ", $name);
        $symbol = '';
        $i=0;
        foreach ($name_array as $w) {
            if (!empty($w)) {
                if (!preg_match('/[^A-Za-z0-9]/',
                $w)) {
                    $symbol .= $w[0];
                    $i++;
                }
            }
            if($i==3){
                break;
            }
        }
        $symbol = $symbol;
        $sku_exist = Product::where('product_symbol', $symbol)->exists();

        if ($sku_exist) {
            return $this->generateSymbol();
        } else {
            return $symbol;
        }
    }
    public function store()
    {
        // dd($this->rows);
        //for variation valid sku
        if ($this->item[0]['isExist'] == 1) {
            $product = Product::find($this->item[0]['id']);
            $product->variations()->forceDelete();
        }
        //////////
        // $this->validate();
        $this->updatedInputs();
        //  try {
        if (empty($this->rows)) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.add_sku_with_sku_for_product'),]);
        } else {
            // dd(77);
            DB::beginTransaction();
            // Add stock transaction
            $transaction = new StockTransaction();
            $transaction->store_id = $this->item[0]['store_id'];
            $transaction->status = 'received';
            $transaction->order_date = Carbon::now();
            $transaction->transaction_date =  Carbon::now();
            $transaction->purchase_type = 'local';
            $transaction->type = 'initial_balance';
            $transaction->supplier_id = !empty($this->item[0]['supplier_id']) ? $this->item[0]['supplier_id'] : null;
            $transaction->created_by = Auth::user()->id;
            $transaction->save();
            //Add Product
            $product = [];
            if ($this->item[0]['isExist'] == 1) {
                $product = Product::find($this->item[0]['id']);
                $product->name = $this->item[0]['name'];
                $product->sku = "Default";
                $product->category_id = $this->item[0]['category_id'];
                $product->subcategory_id1 = $this->item[0]['subcategory_id1'];
                $product->subcategory_id2 = $this->item[0]['subcategory_id2'];
                $product->subcategory_id3 = $this->item[0]['subcategory_id3'];
                $product->height = $this->item[0]['height'];
                $product->length = $this->item[0]['length'];
                $product->width = $this->item[0]['width'];
                $product->weight = $this->item[0]['weight'];
                $product->size = $this->item[0]['size'];
                $product->method = $this->item[0]['method'];
                $product->product_symbol = !empty($this->item[0]['product_symbol'])?$this->item[0]['product_symbol']:$this->generateSymbol();
                $product->balance_return_request=$this->item[0]['balance_return_request']??0;
                $product->save();
                // $product->variations()->delete();
            } else {
                $product = new Product();
                $product->name = $this->item[0]['name'];
                $product->sku = "Default";
                $product->category_id = $this->item[0]['category_id'];
                $product->subcategory_id1 = !empty($this->item[0]['subcategory_id1']) ? $this->item[0]['subcategory_id1'] : null;
                $product->subcategory_id2 = !empty($this->item[0]['subcategory_id2']) ? $this->item[0]['subcategory_id2'] : null;
                $product->subcategory_id3 = !empty($this->item[0]['subcategory_id3']) ? $this->item[0]['subcategory_id3'] : null;
                $product->height = $this->item[0]['height'] ?? null;
                $product->length = $this->item[0]['length'] ?? null;
                $product->width = $this->item[0]['width'] ?? null;
                $product->weight = $this->item[0]['weight'] ?? null;
                $product->size = $this->item[0]['size'] ?? null;
                $product->method = $this->item[0]['method'];
                $product->product_symbol = $this->item[0]['product_symbol'];
                $product->balance_return_request=$this->item[0]['balance_return_request'];
                $product->save();
                if(!empty($this->item[0]['product_tax_id'])){
                    ProductTax::create([
                        'product_tax_id' => $this->item[0]['product_tax_id'] ,
                        'product_id' => $product->id,
                    ]);
                }
            }
            // add  products to stock lines
            foreach ($this->rows as $index => $row) {

                // if($this->rows[$index]['skuExist']!==1){
                $Variation = new Variation();

                $Variation->sku = !empty($this->rows[$index]['sku']) ? $this->rows[$index]['sku'] : $this->generateSku($product->name);
                $Variation->equal = !empty($this->rows[$index]['equal']) ? (float)$this->rows[$index]['equal'] : null;
                $Variation->product_id = $product->id;
                $Variation->unit_id = $this->rows[$index]['unit_id'] !== "" ? $this->rows[$index]['unit_id'] : null;
                $Variation->basic_unit_id = $this->rows[$index]['basic_unit_id'] !== "" ? $this->rows[$index]['basic_unit_id'] : null;
                $Variation->product_symbol = $this->item[0]['product_symbol'] .($index+1) ;
                $Variation->created_by = Auth::user()->id;
                $Variation->save();
                // }else{
                //     $product=Variation::where('sku',$this->rows[$index]['sku'])->first();
                // }
                ////////////////

                $add_stock_data = [
                    'product_id' => $product->id,
                    'variation_id' => $Variation->id,
                    'stock_transaction_id' => $transaction->id,
                    'quantity' => $this->rows[$index]['quantity'] !== '' ? $this->rows[$index]['quantity'] : 0,
                    'fill_type' => isset($this->rows[$index]['fill_type']) ? $this->rows[$index]['fill_type'] : '',
                    'fill_quantity' => isset($this->rows[$index]['fill_quantity']) ? $this->rows[$index]['fill_quantity'] : 0,
                    'purchase_price' => !empty($this->rows[$index]['purchase_price']) ? $this->rows[$index]['purchase_price'] : null,
                    // 'final_cost' => !empty($this->total_cost[$index]) ? $this->total_cost[$index] : null,
                    'sub_total' => !empty($this->sub_total[$index]) ? (float)$this->sub_total[$index] : null,
                    'sell_price' => !empty($this->rows[$index]['selling_price']) ? $this->rows[$index]['selling_price'] : null,
                    'dollar_purchase_price' => !empty($this->rows[$index]['dollar_purchase_price']) ? $this->rows[$index]['dollar_purchase_price'] : null,
                    // 'dollar_final_cost' => !empty($this->dollar_total_cost[$index]) ? $this->dollar_total_cost[$index] : null,
                    'dollar_sub_total' => !empty($this->dollar_sub_total($index)) ? (float)$this->dollar_sub_total($index) : null,
                    'dollar_sell_price' => !empty($this->rows[$index]['dollar_selling_price']) ? $this->rows[$index]['dollar_selling_price'] : null,
                    // 'cost' => !empty($this->rows[$index]['cost']) ?  $this->rows[$index]['cost'] : null,
                    // 'dollar_cost' => !empty($this->rows[$index]['dollar_cost']) ? $this->rows[$index]['dollar_cost'] : null,
                    'exchange_rate' => !empty($this->exchange_rate) ? $this->exchange_rate : null,
                ];
                $stockLine = AddStockLine::create($add_stock_data);

//                $this->updateProductQuantityStore($product->id, $transaction->store_id,  $this->rows[$index]['quantity']);
                $this->updateProductQuantityStore($product->id,$Variation->id, $transaction->store_id, $this->rows[$index]['quantity']);

                if (!empty($row['prices'])) {
                    foreach ($row['prices'] as $price) {
                        $price_data = [
                            'variation_id' => $Variation->id,
                            'stock_line_id' => $stockLine->id,
                            'price_type' => isset($price['price_type']) ? $price['price_type'] : null,
                            'price' => !empty($price['price']) ? $price['price'] : null,
                            'dinar_price' => !empty($price['dinar_price']) ? $price['dinar_price'] : null,
                            'price_customers'=>!empty($price['price_after_desc']) ? $price['price_after_desc'] : null,
                            'dinar_price_customers'=>!empty($price['dinar_price_after_desc']) ? $price['dinar_price_after_desc'] : null,
                            'price_category' => isset($price['price_category']) ? $price['price_category'] : null,
                            'quantity' => isset($price['discount_quantity']) ? $price['discount_quantity'] : null,
                            'bonus_quantity' => isset($price['bonus_quantity']) ? $price['bonus_quantity'] : null,
                            'price_customer_types' => !empty($price['price_customer_types']) ? $price['price_customer_types'] : [],
                            'created_by' => Auth::user()->id,
                            'dinar_total_price' => isset($price['dinar_total_price']) ? $price['total_price'] : null,
                            'total_price' => isset($price['total_price']) ? $price['total_price'] : null,
                            'dinar_piece_price' => isset($price['dinar_piece_price']) ? $price['dinar_piece_price'] : null,
                            'piece_price' => isset($price['piece_price']) ? $price['piece_price'] : null,
                        ];
                        ProductPrice::create($price_data);
                    }
                }
            }
            DB::commit();
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => __('lang.success'),]);
            return redirect('/initial-balance/create');
        }
        //          }
        //          catch (\Exception $e){
        //              $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => __('lang.something_went_wrongs'),]);
        // //             dd($e);
        //          }
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
                        'discount_quantity' => null,
                        'bonus_quantity' => null,
                        'price_customer_types' => null,
                        'price_after_desc' => null,
                        'dinar_price_after_desc' => null,
                        'dinar_total_price' => null,
                        'total_price' => null,
                        'dinar_piece_price' => null,
                        'piece_price' => null,
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
        $this->rows[$index]['dollar_purchase_price'] = (float)$this->rows[$index]['purchase_price'] / (float)$this->exchange_rate;
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
            if ($this->rows[$index]['purchase_price'] != "") {
                if ($this->rows[$index]['fill_type'] == 'fixed') {
                    $this->rows[$index]['dollar_selling_price'] = ($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']);
                    $this->rows[$index]['selling_price'] = ($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']) * $this->exchange_rate;
                } else {
                    $percent = ((float)$this->rows[$index]['dollar_purchase_price'] * (float)$this->rows[$index]['fill_quantity']) / 100;
                    $this->rows[$index]['dollar_selling_price'] = ((float)$this->rows[$index]['dollar_purchase_price'] + $percent);
                    $this->rows[$index]['selling_price'] = ((float)$this->rows[$index]['dollar_purchase_price'] + $percent) * $this->exchange_rate;
                }
            }
        }
    }
    public function changeDollarFilling($index)
    {
        if (!empty($this->rows[$index]['fill_quantity'])) {
            if ($this->rows[$index]['dollar_purchase_price'] != "") {
                if ($this->rows[$index]['fill_type'] == 'fixed') {
                    $this->rows[$index]['dollar_selling_price'] = ($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']);
                    $this->rows[$index]['selling_price'] = ($this->rows[$index]['purchase_price'] + (float)$this->rows[$index]['fill_quantity']) ;
                } else {
                    $percent = ((float)$this->rows[$index]['dollar_purchase_price'] * (float)$this->rows[$index]['fill_quantity']) / 100;
                    $this->rows[$index]['dollar_selling_price'] = ((float)$this->rows[$index]['dollar_purchase_price'] + $percent);
                    $this->rows[$index]['selling_price'] = ((float)$this->rows[$index]['purchase_price'] + $percent);
                }
            }
        }
    }
    public function changeSellingPrice($index)
    {
        $this->rows[$index]['selling_price'] = (float)$this->rows[$index]['dollar_selling_price'] * (float)$this->exchange_rate;
    }
    public function updateProductQuantityStore($product_id,$variation_id, $store_id, $new_quantity)
    {
        $product_store = ProductStore::where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->first();
        $product_variations = Variation::where('product_id',$product_id)->get();
        $unit = Variation::where('id',$variation_id)->first();
        $qty_difference = 0;
        $qtyByUnit = 1 ;
        if(!empty($product_store) && !empty($product_store->variation_id)){
            $store_variation = Variation::find($product_store->variation_id);
            if($store_variation->unit_id == $unit->unit_id){
                $qty_difference = $new_quantity;
            }
            elseif($store_variation->basic_unit_id == $unit->unit_id){
                $qtyByUnit = 1 / $store_variation->equal;
                $qty_difference = $qtyByUnit * $new_quantity;
            }
            else{
                foreach ($product_variations as $key => $product_variation){
                    if (!empty($product_variations[$key+1])) {
                        if ($store_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                            if ($product_variations[$key + 1]->basic_unit_id == $unit->unit_id) {
                                $qtyByUnit = $store_variation->equal * $product_variations[$key + 1]->equal;
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            } else {
                                $qtyByUnit = $product_variation->equal;
                            }
                        }
                        else{
                            if ($product_variation->basic_unit_id == $product_variations[$key+1]->unit_id){
                                $qtyByUnit *= $product_variation->equal;
                            }
                            if ($product_variation->basic_unit_id == $variation_id || $product_variation->unit_id == $variation_id){
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            }
                        }
                    }
                    else{
                        if ($product_variation->basic_unit_id == $variation_id){
                            $qtyByUnit *= $product_variation->equal;
                            $qty_difference = $new_quantity / $qtyByUnit;
                            break;
                        }
                    }
                }
            }
        }
        else{
            $qty_difference = $new_quantity;
        }
        if ($qty_difference != 0) {
            if (empty($product_store)) {
                $product_store = new ProductStore();
                $product_store->product_id = $product_id;
                $product_store->store_id = $store_id;
                $product_store->quantity_available = 0;
            }
            if(empty($product_store->variation_id) && !empty($variation_id)){
                $product_store->variation_id = $variation_id;
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
        unset($this->rows[$index]['prices'][$key]);
    }
    public function changePrice($index, $key)
    {
        if (!empty($this->rows[$index]['selling_price']) || !empty($this->rows[$index]['dollar_selling_price'])) {
            $sell_price = !empty($this->rows[$index]['selling_price']) ? $this->rows[$index]['selling_price'] :0;
            $dollar_sell_price = !empty($this->rows[$index]['dollar_selling_price']) ? $this->rows[$index]['dollar_selling_price'] :0;
            $total_quantity = (float)$this->rows[$index]['prices'][$key]['discount_quantity'] +(float)$this->rows[$index]['prices'][$key]['bonus_quantity'];
            if(empty($this->discount_from_original_price) && !empty($this->rows[$index]['prices'][$key]['discount_quantity'])){
                $total_sell_price = $sell_price * $this->rows[$index]['prices'][$key]['discount_quantity'];
                $total_dollar_sell_price = $dollar_sell_price * $this->rows[$index]['prices'][$key]['discount_quantity'];
                $sell_price = $total_sell_price / $total_quantity ;
                $dollar_sell_price = $total_dollar_sell_price / $total_quantity ;
            }
            if ($this->rows[$index]['prices'][$key]['price_type'] === 'fixed') {
                $this->rows[$index]['prices'][$key]['dinar_price_after_desc'] = $sell_price - (float)$this->rows[$index]['prices'][$key]['price'];
                $this->rows[$index]['prices'][$key]['price_after_desc'] = $dollar_sell_price - (float)$this->rows[$index]['prices'][$key]['price'];
            } elseif ($this->rows[$index]['prices'][$key]['price_type'] === 'percentage') {
                $percent = $this->rows[$index]['prices'][$key]['price'] / 100;
                $this->rows[$index]['prices'][$key]['dinar_price_after_desc'] = (float)($sell_price - ($percent * $sell_price));
                $this->rows[$index]['prices'][$key]['price_after_desc'] = (float)($dollar_sell_price - ($percent * $dollar_sell_price));
            }
            $price = !empty($this->rows[$index]['prices'][$key]['dinar_price_after_desc']) ? (float)$this->rows[$index]['prices'][$key]['dinar_price_after_desc'] : $sell_price;
            $dollar_price = !empty($this->rows[$index]['prices'][$key]['price_after_desc']) ? (float)$this->rows[$index]['prices'][$key]['price_after_desc'] : $dollar_sell_price;
            if(empty($this->discount_from_original_price)){
                $this->rows[$index]['prices'][$key]['total_price']=(float)$dollar_price * (!empty($total_quantity) ? $total_quantity : 1);
                $this->rows[$index]['prices'][$key]['dinar_total_price']=(float)$this->rows[$index]['prices'][$key]['dinar_price_after_desc'] * ((float)$this->rows[$index]['prices'][$key]['discount_quantity'] +(float)$this->rows[$index]['prices'][$key]['bonus_quantity'] );
                $this->rows[$index]['prices'][$key]['piece_price'] = $this->rows[$index]['prices'][$key]['price_after_desc'];
                $this->rows[$index]['prices'][$key]['dinar_piece_price']=(float)$this->rows[$index]['prices'][$key]['dinar_total_price'] ;

            }
            else{
                $this->rows[$index]['prices'][$key]['total_price']=(float)$dollar_price * (!empty($this->rows[$index]['prices'][$key]['discount_quantity']) ? (float)$this->rows[$index]['prices'][$key]['discount_quantity'] : 1);
                $this->rows[$index]['prices'][$key]['dinar_total_price']=(float)$price * (!empty($this->rows[$index]['prices'][$key]['discount_quantity']) ? (float)$this->rows[$index]['prices'][$key]['discount_quantity'] : 1);
                $this->rows[$index]['prices'][$key]['piece_price']=(float)$this->rows[$index]['prices'][$key]['total_price'] / (!empty($total_quantity) ? $total_quantity : 1);
                $this->rows[$index]['prices'][$key]['dinar_piece_price']=(float)$this->rows[$index]['prices'][$key]['dinar_total_price'] / (!empty($total_quantity) ? $total_quantity : 1);

            }
//            $this->rows[$index]['prices'][$key]['total_price']=(float)$this->rows[$index]['prices'][$key]['price_after_desc'] * ((float)$this->rows[$index]['prices'][$key]['discount_quantity'] +(float)$this->rows[$index]['prices'][$key]['bonus_quantity'] );
//            $this->rows[$index]['prices'][$key]['dinar_total_price']=(float)$this->rows[$index]['prices'][$key]['dinar_price_after_desc'] * ((float)$this->rows[$index]['prices'][$key]['discount_quantity'] +(float)$this->rows[$index]['prices'][$key]['bonus_quantity'] );
//            $this->rows[$index]['prices'][$key]['piece_price']=(float)$this->rows[$index]['prices'][$key]['total_price'] / ((float)$this->rows[$index]['prices'][$key]['discount_quantity'] +(float)$this->rows[$index]['prices'][$key]['bonus_quantity'] );
//            $this->rows[$index]['prices'][$key]['dinar_piece_price']=(float)$this->rows[$index]['prices'][$key]['dinar_total_price'] / ((float)$this->rows[$index]['prices'][$key]['discount_quantity'] +(float)$this->rows[$index]['prices'][$key]['bonus_quantity'] );
            $this->rows[$index]['prices'][$key]['dinar_price']=$this->rows[$index]['prices'][$key]['price']* $this->exchange_rate;
        }
    }
}
