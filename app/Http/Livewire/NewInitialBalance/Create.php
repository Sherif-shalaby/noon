<?php

namespace App\Http\Livewire\NewInitialBalance;

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Store;
use App\Models\Branch;
use App\Models\System;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Variation;
use App\Models\ProductTax;
use App\Models\AddStockLine;
use App\Models\CustomerType;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use Livewire\WithPagination;
use App\Models\VariationPrice;
use App\Models\ProductDimension;
use App\Models\StockTransaction;
use App\Models\VariationStockline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithPagination;
    public $item = [
        [
            'id',
            'name' => '',
            'store_id' => '',
            'supplier_id' => '',
            'customer_id' => '',
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
            'basic_unit_variation_id' => '',
            'method' => '',
            'exchange_rate' => 0,
            'product_symbol' => '',
            'balance_return_request' => '',

        ]
    ];
    public $prices = [
        [
            'fill_id' => '',
            'price_type' => null,
            'price_currency' => 'dinar',
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
            'apply_on_all_customers' => 0,
            'parent_price' => 0,
            'discount_from_original_price' => true,
        ]
    ];
    public $fill_stores = [
        [
            'extra_store_id' => '',
            'data' => [
                [
                    'store_fill_id' => '',
                    'quantity' => '',
                ]
            ]
        ]
    ];
    public $subcategories1 = [], $subcategories2 = [], $subcategories3 = [];
    public $quantity = [], $purchase_price = [], $selling_price = [], $toggle_dollar = 0,
        $base_unit = [], $divide_costs, $total_size = [], $total_weight = [],
        $sub_total = [], $change_price_stock = [], $store_id, $status,
        $supplier, $exchange_rate, $exchangeRate, $transaction_date, $transaction_currency,
        $dollar_purchase_price = [], $dollar_selling_price = [], $dollar_sub_total = [], $dollar_cost = [], $dollar_total_cost = [],
        $current_stock, $totalQuantity = 0, $edit_product = [], $current_sub_category, $variationSums = [], $customer_types = [],
        $clear_all_input_stock_form, $product_tax, $subcategories = [], $discount_from_original_price, $basic_unit_variations = [], $unit_variations = [], $branches = [], $units = [],
        $show_dimensions = 0, $show_category1 = 0, $show_category2 = 0, $show_category3 = 0, $show_discount = 0, $show_store = 0, $variations = [];
    public $rows = [], $toggle_customers_dropdown, $customer_id, $variationStoreSums, $variationFillStoreSums, $toggle_suppliers;
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
            'item.*.weight' => 'nullable|numeric',
            'item.*.width' => 'nullable|numeric',
            'item.*.height' => 'nullable|numeric',
            'item.*.length' => 'nullable|numeric',
            'item.*.size' => 'nullable|numeric',
            'item.*.product_tax_id' => 'nullable',
            'item.*.product_symbol' => 'nullable|unique:products,product_symbol,NULL,id,deleted_at,NULL',
            // 'rows.*.sku' => 'required',
            'rows.*.sku' => 'nullable|unique:variations,sku,NULL,id,deleted_at,NULL',
            'rows.*.purchase_price' => 'required',
            // 'rows.*.dollar_purchase_price' => 'required',
            // 'rows.*.dollar_selling_price' => 'required',
            // 'rows.*.selling_price' => 'required',
            // 'rows.*.prices.*.discount_quantity' => 'required_if:rows.*.prices.*.bonus_quantity,' . $this->rows[0]['prices'][0]['bonus_quantity'],
            // 'rows.*.prices.*.bonus_quantity' => 'required',
        ]);
        $this->messages();
    }
    public function changeSize()
    {
        $height = $this->item[0]['height'] ?? 0;
        $length = $this->item[0]['length'] ?? 0;
        $width = $this->item[0]['width'] ?? 0;
        $this->item[0]['size'] = (float)$height * (float)$length * (float)$width;
    }
    protected $listeners = ['listenerReferenceHere', 'create', 'cancelCreateProduct'];

    public function listenerReferenceHere($data)
    {
        if (isset($data['var1'])) {
            // dd($data['var1']);
            if (($data['var1'] == "unit_id" || $data['var1'] == "basic_unit_id") && $data['var3'] !== '') {
                $this->rows[$data['var3']][$data['var1']] = $data['var2'];
                if ($data['var1'] == "unit_id") {
                    $this->units = Unit::orderBy('created_at', 'desc')->get();
                    $this->rows[$data['var3']]['unit_id'] = $data['var2'];
                    $this->changeUnit($data['var3']);
                    // $this->count_total_by_variations();
                }
                // if ($data['var1'] == "basic_unit_id") {
                //     // dd($data['var1']);

                //     $this->changeBaseUnit($data['var3']);
                // }
            } else if ($data['var1'] == "price_customer_types" && $data['var3'] !== '') {
                $this->prices[$data['var3']]['price_customer_types'] = $data['var2'];
                $this->changePrice($data['var3']);
            } else if ($data['var1'] == "fill_id" && $data['var3'] !== '') {
                $this->prices[$data['var3']]['fill_id'] = $data['var2'];
            } else if ($data['var1'] == "store_fill_id" && $data['var3'] !== '') {
                $this->fill_stores[$data['var3']]['data'][$data['var4']]['store_fill_id'] = $data['var2'];
            } else if ($data['var1'] == "extra_store_id" && $data['var3'] !== '') {
                // dd($data);
                $this->fill_stores[$data['var3']]['extra_store_id'] = $data['var2'];
            } else {
                $this->item[0][$data['var1']] = $data['var2'];
                if ($data['var1'] == 'category_id') {
                    $this->subcategories1 = Category::where('parent_id', 2)->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if ($data['var1'] == 'subcategory_id1') {
                    $this->subcategories1 = Category::where('parent_id', 2)->orderBy('name', 'asc')->pluck('name', 'id');
                    $this->subcategories2 = Category::where('parent_id', 3)->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if ($data['var1'] == 'subcategory_id2') {
                    $this->subcategories2 = Category::where('parent_id', 3)->orderBy('name', 'asc')->pluck('name', 'id');
                    $this->subcategories3 = Category::where('parent_id', 4)->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if ($data['var1'] == 'subcategory_id3') {
                    $this->subcategories3 = Category::where('parent_id', 4)->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if ($data['var1'] == 'transaction_currency') {
                    //                    dd($data['var2']);
                    $this->transaction_currency = (int)$data['var2'];
                }
            }
            $this->subcategories = Category::where('parent_id', 1)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            $this->exchange_rate = $this->changeExchangeRate();
            // $this->changeExchangeRateBasedPrices();
        }
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
                    $this->subcategories1 = Category::where('parent_id', 2)->orderBy('name', 'asc')->pluck('name', 'id');
                    $this->item[0]['subcategory_id1'] = $recent_stock->add_stock_lines->first()->product->subcategory_id1 ?? null;
                }
                if (!empty($this->item[0]['subcategory_id1'] && count($this->subcategories1) > 0)) {
                    $this->subcategories2 = Category::where('parent_id', 3)->orderBy('name', 'asc')->pluck('name', 'id');
                    $this->item[0]['subcategory_id2'] = $recent_stock->add_stock_lines->first()->product->subcategory_id2 ?? null;
                }
                if (!empty($this->item[0]['subcategory_id2']) && count($this->subcategories2) > 0) {
                    $this->subcategories3 = Category::where('parent_id', 4)->orderBy('name', 'asc')->pluck('name', 'id');
                    $this->item[0]['subcategory_id3'] = $recent_stock->add_stock_lines->first()->product->subcategory_id3 ?? null;
                }
                $this->item[0]['height'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->height ?? null;
                $this->item[0]['length'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->length ?? null;
                $this->item[0]['width'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->width ?? null;
                $this->item[0]['weight'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->weight ?? null;
                $this->item[0]['size'] = $recent_stock->add_stock_lines->first()->product->product_dimensions->size ?? null;
                $this->item[0]['balance_return_request'] = $recent_stock->add_stock_lines->first()->product->balance_return_request ?? null;
                $this->transaction_currency = $recent_stock->transaction_currency  ?? null;
            }
        }
        $this->exchange_rate = $this->changeExchangeRate();
        $this->units = Unit::orderBy('created_at', 'desc')->get();
        $this->customer_types = CustomerType::orderBy('name', 'asc')->get();
        $this->addPrices();
        $this->dispatchBrowserEvent('initialize-select2');
    }
    public function render()
    {
        $this->branches = Branch::where('type', 'branch')->orderBy('created_by', 'desc')->pluck('name', 'id');
        $customers = Customer::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $toggle_dollar = System::getProperty('toggle_dollar');
        $currenciesId = [];
        if ($toggle_dollar == '1') {
            $currenciesId = [System::getProperty('currency')];
        } else {
            $currenciesId = [System::getProperty('currency'), 2];
        }
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        // $this->discount_from_original_price = 1;
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $categories = Category::orderBy('name', 'asc')->where('parent_id', 1)->pluck('name', 'id')->toArray();
        $this->subcategories = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $products = Product::all();
        $stores = Store::whereHas('branch', function ($query) {
            $query->where('type', 'branch');
        })->with('branch')->get()->map(function ($store) {
            return [
                'id' => $store->id,
                'full_name' => $store->name . ' - ' . $store->branch->name,
            ];
        })->pluck('full_name', 'id')->toArray();

        //        dd($stores);// Convert the collection to an array


        $branches = Branch::where('type', 'branch')->orderBy('created_by', 'desc')->pluck('name', 'id');

        $basic_units = Unit::orderBy('created_at', 'desc')->pluck('name', 'id');
        $product_taxes = Tax::select('name', 'id', 'status')->get();
        $customer_types = CustomerType::latest()->get();
        $this->dispatchBrowserEvent('initialize-select2');
        return view(
            'livewire.new-initial-balance.create',
            compact(
                'stores',
                'suppliers',
                'customers',
                'products',
                'product_taxes',
                'basic_units',
                'categories',
                'customer_types',
                'branches',
                'selected_currencies'
            )
        );
    }


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
        //      $newRow = [
        //     'id' => '', 'sku' => '', 'quantity' => '','unit_id' => '','purchase_price'=>'','prices' => [],
        //   ];
        //     array_unshift($this->rows, $newRow);
        $this->addPrices();
    }
    public function changeUnit($index)
    {
        ///////////////////////////product dimension variation ///////////////////
        foreach ($this->rows as $i => $row) {
            if (!empty($this->rows[$i]['unit_id']) && $this->rows[$i]['unit_id'] !== '') {
                $this->unit_variations[] = $this->rows[$i]['unit_id'];
            }
        }
        $this->basic_unit_variations = Unit::whereIn('id', $this->unit_variations)->orderBy('name', 'asc')->pluck('name', 'id');
    }

    // public function changeBaseUnit($index)
    // {
    //     //////////////////////////////// calculate row based on other rows//////////////
    //     $base_unit = $this->rows[$index]['basic_unit_id'];
    //     $unit_index = '';
    //     $basic_unit_index = '';
    //     foreach ($this->rows as $i => $item) {
    //         if ($i != $index) {
    //             if ($item['unit_id'] === $base_unit) {
    //                 $unit_index = $i;
    //                 break;
    //             }
    //         }
    //     }
    //     if ($unit_index == '') {
    //         foreach ($this->rows as $i => $item) {
    //             if ($i != $index) {
    //                 if ($item['basic_unit_id'] === $base_unit) {
    //                     $basic_unit_index = $i;
    //                     break;
    //                 }
    //             }
    //         }
    //     }
    //     if ($unit_index !== '') {
    //         // $this->rows[$index]['equal'] = 1;
    //         $this->rows[$index]['quantity'] = 0;
    //         $this->rows[$index]['fill_type'] = $this->rows[$unit_index]['fill_type'];
    //         if ((float)$this->rows[$unit_index]['equal'] != 0) {
    //             $this->rows[$index]['dollar_purchase_price'] = ($this->num_uf($this->rows[$unit_index]['dollar_purchase_price'])) * (float)$this->rows[$index]['equal'];
    //             $this->rows[$index]['dollar_selling_price'] = ($this->num_uf($this->rows[$unit_index]['dollar_selling_price'])) * (float)$this->rows[$index]['equal'];
    //             $this->rows[$index]['purchase_price'] = ($this->num_uf($this->rows[$unit_index]['purchase_price'])) * (float)$this->rows[$index]['equal'];
    //             $this->rows[$index]['selling_price'] = ($this->num_uf($this->rows[$unit_index]['selling_price'])) * (float)$this->rows[$index]['equal'];
    //             // dd($this->rows[$unit_index]);
    //             if ($this->rows[$index]['fill_type'] == "fixed") {
    //                 $this->rows[$index]['fill_quantity'] = ($this->num_uf($this->rows[$unit_index]['fill_quantity'])) * (float)$this->rows[$index]['equal'];
    //                 $this->rows[$index]['fill_currency'] = $this->rows[$unit_index]['fill_currency'];
    //             } else {
    //                 $this->rows[$index]['fill_quantity'] = $this->rows[$unit_index]['fill_quantity'];
    //             }
    //             // $this->changePurchasePrice($index);
    //         }
    //     } else {
    //         if ($basic_unit_index !== '') {
    //             $this->rows[$index]['quantity'] = 0;
    //             $this->rows[$index]['fill_type'] = $this->rows[$basic_unit_index]['fill_type'];
    //             if ((float)$this->rows[$basic_unit_index]['equal'] != 0) {
    //                 $this->rows[$index]['dollar_purchase_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['dollar_purchase_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], 3);
    //                 $this->rows[$index]['purchase_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['purchase_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], 3);
    //                 $this->rows[$index]['dollar_selling_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['dollar_selling_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], 3);
    //                 $this->rows[$index]['selling_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['selling_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], 3);
    //                 // dd($this->rows[$basic_unit_index]);
    //                 if ($this->rows[$index]['fill_type'] == "fixed") {
    //                     $this->rows[$index]['fill_quantity'] =  number_format(((float)$this->rows[$basic_unit_index]['fill_quantity'] / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], 3);
    //                     $this->rows[$index]['fill_currency'] = $this->rows[$basic_unit_index]['fill_currency'];
    //                 } else {
    //                     $this->rows[$index]['fill_quantity'] = $this->rows[$basic_unit_index]['fill_quantity'];
    //                 }
    //                 // $this->changePurchasePrice($index);
    //             }
    //         }
    //     }
    // }
    public function generateSymbol()
    {
        $name = $this->item[0]['name'];
        $name_array = explode(" ", $name);
        $symbol = '';
        $i = 0;
        foreach ($name_array as $w) {
            if (!empty($w)) {
                if (!preg_match(
                    '/[^A-Za-z0-9]/',
                    $w
                )) {
                    $symbol .= $w[0];
                    $i++;
                }
            }
            if ($i == 3) {
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
        // dd($this->stores);
        //for variation valid sku
        // if ($this->item[0]['isExist'] == 1) {
        //     $product = Product::find($this->item[0]['id']);
        //     $product->variations()->forceDelete();
        // }
        //////////
        // $this->validate();
        $this->updatedInputs();
        try {
            if (empty($this->rows)) {
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.add_sku_with_sku_for_product'),]);
            } else {
                // dd(77);
                DB::beginTransaction();
                // Add stock transaction
                //Add Product
                $product = [];
                $this->toggle_dollar = System::getProperty('toggle_dollar');
                if ($this->item[0]['isExist'] == 1) {
                    $product = Product::find($this->item[0]['id']);
                    $product->name = $this->item[0]['name'];
                    $product->sku = "Default";
                    $product->category_id = $this->item[0]['category_id'];
                    $product->subcategory_id1 = $this->item[0]['subcategory_id1'];
                    $product->subcategory_id2 = $this->item[0]['subcategory_id2'];
                    $product->subcategory_id3 = $this->item[0]['subcategory_id3'];
                    $product->method = $this->item[0]['method'];
                    $product->product_symbol = !empty($this->item[0]['product_symbol']) ? $this->item[0]['product_symbol'] : $this->generateSymbol();
                    $product->balance_return_request = $this->item[0]['balance_return_request'] ?? 0;
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
                    $product->method = !empty($this->item[0]['method']) ? $this->item[0]['method'] : null;
                    $product->product_symbol = $this->item[0]['product_symbol'];
                    $product->balance_return_request = !empty($this->item[0]['balance_return_request']) ? $this->num_uf($this->item[0]['balance_return_request']) : 0;
                    $product->save();
                    if (!empty($this->item[0]['product_tax_id'])) {
                        ProductTax::create([
                            'product_tax_id' => $this->item[0]['product_tax_id'],
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
                    $Variation->equal = $this->num_uf($this->rows[$index]['fill']);
                    $Variation->unit_id = $this->rows[$index]['unit_id'] !== "" ? $this->rows[$index]['unit_id'] : null;
                    $Variation->basic_unit_id = isset($this->rows[$index - 1]) && !empty($this->rows[$index - 1]['unit_id']) ? $this->rows[$index - 1]['unit_id'] : null;
                    $Variation->product_symbol = $this->item[0]['product_symbol'] . ($index + 1);
                    $Variation->created_by = Auth::user()->id;
                    $Variation->save();
                    $this->variations[$index] = $Variation->id;
                    foreach ($this->rows[$index]['prices'] as $key => $price) {
                        if (!empty($this->rows[$index]['prices'][$key]['dollar_sell_price']) || !empty($this->rows[$index]['prices'][$key]['dinar_sell_price'])) {
                            $Variation_price = new VariationPrice();
                            $Variation_price->variation_id = $Variation->id;
                            $Variation_price->customer_type_id = $this->rows[$index]['prices'][$key]['customer_type_id'] ?? null;
                            $Variation_price->dinar_sell_price = $this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) ?? null;
                            $Variation_price->dollar_sell_price = $this->toggle_dollar == "0" ? ($this->num_uf($this->rows[$index]['prices'][$key]['dollar_sell_price']) ?? null) : 0;
                            $Variation_price->percent = $this->rows[$index]['prices'][$key]['percent'] ?? null;
                            $Variation_price->save();
                        }
                    }

                    ////////////////
                }

                if (
                    $this->item[0]['height'] == ('' || 0) && $this->item[0]['length'] == ('' || 0) && $this->item[0]['width'] == ('' || 0)
                    || $this->item[0]['size'] == ('' || 0) && $this->item[0]['weight'] == ('' || 0)
                ) {
                } else {
                    ProductDimension::create([
                        'product_id' => $product->id,
                        'variation_id' => !empty($this->item[0]['basic_unit_variation_id']) ? (Variation::where('product_id', $product->id)->where('unit_id', $this->item[0]['basic_unit_variation_id'])->first()->id ?? '') : null,
                        'height' => !empty($this->item[0]['height']) ? $this->item[0]['height'] : 0,
                        'length' => !empty($this->item[0]['length']) ? $this->item[0]['length'] : 0,
                        'width' => !empty($this->item[0]['width']) ? $this->item[0]['width'] : 0,
                        'weight' => !empty($this->item[0]['weight']) ? $this->item[0]['weight'] : 0,
                        'size' => !empty($this->item[0]['size']) ? $this->item[0]['size'] : 0,
                    ]);
                }
                $this->saveTransaction($product->id,);
                DB::commit();
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => __('lang.success'),]);
                return redirect('/new-initial-balance/create');
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.something_went_wrongs'),]);
            //             dd($e);
        }
    }
    public function saveTransaction($product_id, $variations = [])
    {
        $parent_transction = [];
        for ($i = -1; $i < count($this->fill_stores); $i++) {
            // dd($this->fill_stores);
            //Add stock transaction

            $store_id = $i < 0 ? $this->item[0]['store_id'] : $this->fill_stores[$i]['extra_store_id'];
            if (!empty($store_id)) {
                $transaction = new StockTransaction();
                $transaction->store_id = $store_id;
                $transaction->status = 'received';
                $transaction->order_date = Carbon::now();
                $transaction->transaction_date =  Carbon::now();
                $transaction->purchase_type = 'local';
                $transaction->type = 'initial_balance';
                $transaction->supplier_id = !empty($this->item[0]['supplier_id']) && !$this->toggle_customers_dropdown ? $this->item[0]['supplier_id'] : null;
                $transaction->customer_id = !empty($this->item[0]['customer_id']) && $this->toggle_customers_dropdown ? $this->item[0]['customer_id'] : null;
                $transaction->transaction_currency = $this->transaction_currency;
                $transaction->created_by = Auth::user()->id;
                $transaction->parent_transction = !empty($parent_transction[0]) ? $parent_transction[0] : 0;
                $transaction->save();
                $parent_transction[] = $transaction->id;
                foreach ($this->rows as $index => $row) {
                    $quantity = 0;
                    if ($i > -1) {
                        foreach ($this->fill_stores[$i]['data'] as $s => $store) {
                            if ($store['store_fill_id'] == Variation::where('product_id', $product_id)->where('id', $this->variations[$index])->first()->unit_id) {
                                $quantity = $store['quantity'];
                            }
                        }
                    }
                    $add_stock_data = [
                        'product_id' => $product_id,
                        'variation_id' => $this->variations[$index],
                        'stock_transaction_id' => $transaction->id,
                        'quantity' => ($i == -1) && $this->rows[$index]['quantity'] !== '' ? $this->num_uf($this->rows[$index]['quantity'])  : $quantity,
                        // 'fill_type' => isset($this->rows[$index]['fill_type']) ? $this->rows[$index]['fill_type'] : '',
                        // 'fill_quantity' => isset($this->rows[$index]['fill_quantity']) ? $this->num_uf($this->rows[$index]['fill_quantity']) : 0,
                        'purchase_price' => ($this->transaction_currency != 2) ? $this->num_uf($this->rows[$index]['purchase_price'])  : null,
                        'sell_price' => null,
                        // 'sub_total' => !empty($this->sub_total[$index]) ? $this->num_uf((float)$this->sub_total[$index]) : null,
                        'dollar_purchase_price' => $this->toggle_dollar == "0" ? (($this->transaction_currency == 2) ? $this->num_uf($this->rows[$index]['purchase_price'])  : null) : 0,
                        'dollar_sell_price' =>  null,
                        'dollar_sub_total' =>  null,
                        'exchange_rate' => !empty($this->exchange_rate) ? $this->num_uf($this->exchange_rate)  : null,

                    ];
                    $stockLine = AddStockLine::create($add_stock_data);
                    if (!empty($this->prices)) {
                        foreach ($this->prices as $price) {

                            if (!empty($price['dinar_price']) || !empty($price['discount_quantity'])) {
                                if ($price['fill_id'] == Variation::find($this->variations[$index])->unit_id) {
                                    // dd(6);
                                    $price_data = [
                                        'variation_id' => $this->variations[$index],
                                        'stock_line_id' => $stockLine->id,
                                        'unit_id' => !empty($price['fill_id']) ? $price['fill_id'] : null,
                                        'price_type' => !empty($price['price_type']) ? $price['price_type'] : null,
                                        'price' => $this->toggle_dollar == "0" ? (($this->transaction_currency == 2) ? (!empty($price['price']) ? $this->num_uf($price['price'])  : null) : null) : 0,
                                        'dinar_price' => ($this->transaction_currency != 2) ? (!empty($price['dinar_price']) ? $this->num_uf($price['dinar_price'])  : null) : null,
                                        'price_customers' => $this->toggle_dollar == "0" ? (($this->transaction_currency == 2) ? (!empty($price['price_after_desc']) ? $this->num_uf($price['price_after_desc'])  : null) : null) : 0,
                                        'dinar_price_customers' => ($this->transaction_currency != 2) ? (!empty($price['dinar_price_after_desc']) ? $this->num_uf($price['dinar_price_after_desc']) : null) : null,
                                        'price_category' => isset($price['price_category']) ? $price['price_category'] : null,
                                        'quantity' => !empty($price['discount_quantity']) ? $this->num_uf($price['discount_quantity']) : null,
                                        'bonus_quantity' => !empty($price['bonus_quantity']) ? $this->num_uf($price['bonus_quantity']) : null,
                                        'price_customer_types' => !empty($price['price_customer_types']) ? $price['price_customer_types'] : null,
                                        'created_by' => Auth::user()->id,
                                        'dinar_total_price' => ($this->transaction_currency != 2) ? (!empty($price['dinar_total_price']) ? $this->num_uf($price['total_price']) : null) : null,
                                        'total_price' => $this->toggle_dollar == "0" ? (($this->transaction_currency == 2) ? (!empty($price['total_price']) ? $this->num_uf($price['total_price'])  : null) : null) : 0,
                                        'dinar_piece_price' => ($this->transaction_currency != 2) ? (!empty($price['dinar_piece_price']) ? $this->num_uf($price['dinar_piece_price']) : null) : null,
                                        'piece_price' => $this->toggle_dollar == "0" ? (($this->transaction_currency == 2) ? (!empty($price['piece_price']) ? $this->num_uf($price['piece_price'])  : null) : null) : 0,
                                        'discount_from_original_price' => 0,
                                    ];
                                    ProductPrice::create($price_data);
                                } else {
                                }
                            }
                        }
                    }
                    foreach ($this->rows[$index]['prices'] as $key => $price) {
                        if (!empty($this->rows[$index]['prices'][$key]['customer_type_id'])) {
                            if (!empty($this->rows[$index]['prices'][$key]['dollar_sell_price']) || !empty($this->rows[$index]['prices'][$key]['dinar_sell_price'])) {
                                $variation_price = VariationPrice::where('variation_id', $this->variations[$index])->where('customer_type_id', $this->rows[$index]['prices'][$key]['customer_type_id'])->first();
                                $add_variation_stock_data = [
                                    'variation_price_id' => $variation_price->id,
                                    'stock_line_id' => $stockLine->id,
                                    // 'quantity' => ($i == -1) && $this->rows[$index]['quantity'] !== '' ? $this->num_uf($this->rows[$index]['quantity'])  : $quantity,
                                    'purchase_price' => ($this->transaction_currency != 2) ? $this->num_uf($this->rows[$index]['purchase_price']) : null,
                                    'sell_price' => ($this->transaction_currency != 2) ? $this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price'])  : 0,
                                    'sub_total' => !empty($this->sub_total[$index]) ? $this->num_uf((float)$this->sub_total[$index]) : null,
                                    'dollar_purchase_price' => $this->toggle_dollar == "0" ? (($this->transaction_currency == 2) ? $this->num_uf($this->rows[$index]['purchase_price'])  : null) : 0,
                                    'dollar_sell_price' => $this->toggle_dollar == "0" ? (($this->transaction_currency == 2) ? ($this->num_uf($this->rows[$index]['prices'][$key]['dollar_sell_price']))  : 0) : 0,
                                    'dollar_sub_total' => $this->toggle_dollar == "0" ? (!empty($this->dollar_sub_total($index, $key)) ? $this->num_uf((float)$this->dollar_sub_total($index, $key))  : null) : 0,
                                    // 'exchange_rate' => !empty($this->exchange_rate) ? $this->num_uf($this->exchange_rate)  : null,
                                ];
                                $variationstockLine =  VariationStockline::create($add_variation_stock_data);
                            }
                        }
                    }
                    $this->updateProductQuantityStore($product_id, $this->variations[$index], $store_id, $this->num_uf($this->rows[$index]['quantity']));
                }
            }
        }
    }
    public function generateSku($name, $number = 1)
    {
        // $name_array = explode(" ", $name);
        // $sku = '';
        // foreach ($name_array as $w) {
        //     if (!empty($w)) {
        //         if (!preg_match('/[^A-Za-z0-9]/', $w)) {
        //             $sku .= $w[0];
        //         }
        //     }
        // }
        // $sku = $sku . $number;
        // $sku_exist = Variation::where('sku', $sku)->exists();

        // if ($sku_exist) {
        //     return $this->generateSku($name, $number + 1);
        // } else {
        //     return $sku;
        // }
        $start = System::getProperty('product_sku_start') ?? '';
        $number = Product::count();
        $sku = $start . $number;
        return $sku;
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
        $this->subcategories1 = Category::orderBy('name', 'asc')->where('parent_id', 2)->pluck('name', 'id');
        $this->subcategories2 = Category::orderBy('name', 'asc')->where('parent_id', 3)->pluck('name', 'id');
        $this->subcategories3 = Category::orderBy('name', 'asc')->where('parent_id', 4)->pluck('name', 'id');
        $this->item[0] =
            [
                'isExist' => 1,
                'id' => $this->edit_product['id'],
                'name' => $this->edit_product['name'],
                'category_id' => $this->edit_product['category_id'],
                'subcategory_id1' => $this->edit_product['subcategory_id1'],
                'subcategory_id2' => $this->edit_product['subcategory_id2'],
                'subcategory_id3' => $this->edit_product['subcategory_id3'],
                'weight' => $this->edit_product['product_dimensions']['weight'] ?? null,
                'width' => $this->edit_product['product_dimensions']['width'] ?? null,
                'height' => $this->edit_product['product_dimensions']['height'] ?? null,
                'length' => $this->edit_product['product_dimensions']['length'] ?? null,
                'size' => $this->edit_product['product_dimensions']['size'] ?? null,
                'basic_unit_variation_id' => $this->edit_product['product_dimensions']['variation_id'] ?? null,
                'method' => '',
                'status' => '',
                'change_current_stock' => 0,
                'exchange_rate' => $this->exchange_rate,
                'store_id' => '',
                'supplier_id' => '', 'product_tax_id' => '',
                'balance_return_request' => $this->edit_product['balance_return_request'] ?? null,
                'product_symbol' => $this->edit_product['product_symbol'] ?? null,
            ];
        //        dd($this->item[0]);



        $variations = Variation::where('product_id', $this->edit_product['id'])->get();
        if (count($variations) >= 1) {
            $this->rows = [];
            foreach ($variations as $variation) {
                $newRow = [
                    'id' => $variation->id,
                    'sku' => $variation->sku,
                    'quantity' => '',
                    'purchase_price' => '',
                    'unit_id' => $variation->unit_id,
                    'fill' => $variation->equal,
                    'prices' => [],
                ];
                $this->rows[] = $newRow;
                $index = count($this->rows) - 1;

                foreach ($this->customer_types as $customer_type) {
                    $new_price = [
                        'customer_type_id' => $customer_type->id,
                        'customer_name' => $customer_type->name,
                        'percent' => null,
                        'dollar_increase' => 0,
                        'dinar_increase' => null,
                        'dollar_sell_price' => 0,
                        'dinar_sell_price' => null,
                        'quantity' => null,
                    ];
                    array_unshift($this->rows[$index]['prices'], $new_price);
                }
            }
        } else {
            $this->rows = [];
            $this->addPrices();
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

    public function count_total_by_variations()
    {
        $this->variationSums = [];
        foreach ($this->rows as $row) {
            if (!empty($row['unit_id'])) {
                $unit = Unit::find($row['unit_id']);
                $variation_name = $unit->name;
                if (isset($this->variationSums[$variation_name])) {
                    $this->variationSums[$variation_name] += $this->num_uf($row['quantity']);
                } else {
                    $this->variationSums[$variation_name] = $this->num_uf($row['quantity']);
                }
            }
        }
    }
    public function count_total_by_variation_stores()
    {
        $this->variationStoreSums = [];
        foreach ($this->rows as $row) {
            if (!empty($row['unit_id'])) {
                $unit = Unit::find($row['unit_id']);
                $variation_name = $unit->name;
                if (isset($this->variationStoreSums[$variation_name])) {
                    $this->variationStoreSums[$variation_name] += $this->num_uf($row['quantity']);
                } else {
                    $this->variationStoreSums[$variation_name] = $this->num_uf($row['quantity']);
                }
            }
        }
        foreach ($this->fill_stores as $key => $fill) {
            foreach ($this->fill_stores[$key]['data'] as $index => $fill) {
                if (!empty($fill['store_fill_id'])) {
                    $unit = Unit::find($fill['store_fill_id']);
                    $variation_name = $unit->name;
                    if (isset($this->variationStoreSums[$variation_name])) {
                        $this->variationStoreSums[$variation_name] += $this->num_uf($fill['quantity']);
                    } else {
                        $this->variationStoreSums[$variation_name] = $this->num_uf($fill['quantity']);
                    }
                }
            }
        }
    }
    public function count_fill_stores_unit($key)
    {
        $this->variationFillStoreSums = [];
        // foreach($this->fill_stores as $key=>$fill){
        foreach ($this->fill_stores[$key]['data'] as $index => $fill) {
            if (!empty($fill['store_fill_id'])) {
                $unit = Unit::find($fill['store_fill_id']);
                $variation_name = $unit->name;
                if (isset($this->variationFillStoreSums[$variation_name])) {
                    $this->variationFillStoreSums[$variation_name] += $this->num_uf($fill['quantity']);
                } else {
                    $this->variationFillStoreSums[$variation_name] = $this->num_uf($fill['quantity']);
                }
            }
        }
        return $this->variationFillStoreSums;
        // }
    }
    public function sub_total($index)
    {
        if (!empty($this->rows[$index]['quantity']) && !empty($this->rows[$index]['purchase_price'])) {

            $this->sub_total[$index] = (int)$this->rows[$index]['quantity'] * $this->num_uf($this->rows[$index]['purchase_price']);

            return number_format($this->sub_total[$index], num_of_digital_numbers());
        }
    }

    public function dollar_sub_total($index, $key)
    {
        if (!empty($this->rows[$index]['prices'][$key]['quantity']) && !empty($this->rows[$index]['prices'][$key]['quantity'])) {
            $this->dollar_sub_total[$index] = (int)$this->rows[$index]['prices'][$key]['quantity'] * $this->num_uf($this->rows[$index]['prices'][$key]['dinar_purchase_price']);
            return number_format($this->dollar_sub_total[$index], num_of_digital_numbers());
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
        return number_format(array_sum($this->sub_total), num_of_digital_numbers());
    }

    public function sum_dollar_sub_total()
    {
        return number_format(array_sum($this->dollar_sub_total), num_of_digital_numbers());
    }

    public function delete_product($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
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
        $this->rows[$index]['purchase_price'] = number_format((float)$this->num_uf($this->rows[$index]['dollar_purchase_price']) * (float)$this->exchange_rate, num_of_digital_numbers());
        $this->changeFilling($index);
    }
    public function changeDollarPurchasePrice($index)
    {
        $this->rows[$index]['dollar_purchase_price'] = number_format((float)$this->num_uf($this->rows[$index]['purchase_price']) / (float)$this->exchange_rate, num_of_digital_numbers());
        $this->changeDollarFilling($index);
    }
    public function changeExchangeRateBasedPrices()
    {
    }
    public function changeFilling($index)
    {
        if (!empty($this->rows[$index]['fill_quantity'])) {
            if ($this->rows[$index]['purchase_price'] != "" && ($this->rows[$index]['fill_currency'] == "dollar")) {
                if ($this->rows[$index]['fill_type'] == 'fixed') {
                    $this->rows[$index]['dollar_selling_price'] = number_format(($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']), num_of_digital_numbers());
                    $this->rows[$index]['selling_price'] = number_format(($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']) * $this->exchange_rate, num_of_digital_numbers());
                } else {
                    $percent = ($this->num_uf($this->rows[$index]['dollar_purchase_price']) * (float)$this->rows[$index]['fill_quantity']) / 100;
                    $this->rows[$index]['dollar_selling_price'] = number_format(((float)$this->rows[$index]['dollar_purchase_price'] + $percent), num_of_digital_numbers());
                    $this->rows[$index]['selling_price'] =  number_format(((float)$this->rows[$index]['dollar_purchase_price'] + $percent) * $this->exchange_rate, num_of_digital_numbers());
                }
            } else {
                $this->changeDollarFilling($index);
            }
        }
    }
    public function changeDollarFilling($index)
    {
        if (!empty($this->rows[$index]['fill_quantity'])) {
            if ($this->rows[$index]['dollar_purchase_price'] != "" && ($this->rows[$index]['fill_currency'] == "dinar")) {
                if ($this->rows[$index]['fill_type'] == 'fixed') {
                    $this->rows[$index]['selling_price'] = number_format(((float)$this->num_uf($this->rows[$index]['purchase_price']) + (float)$this->rows[$index]['fill_quantity']), num_of_digital_numbers());
                    $this->rows[$index]['dollar_selling_price'] = number_format((float)$this->num_uf($this->rows[$index]['selling_price']) / (float)$this->exchange_rate, num_of_digital_numbers());
                } else {
                    $percent = ($this->num_uf($this->rows[$index]['purchase_price']) * (float)$this->rows[$index]['fill_quantity']) / 100;
                    $this->rows[$index]['selling_price'] =  number_format(($this->num_uf($this->rows[$index]['purchase_price']) + $percent), num_of_digital_numbers());
                    $this->rows[$index]['dollar_selling_price'] =  number_format(((float)$this->num_uf($this->rows[$index]['purchase_price']) + $percent) / $this->exchange_rate, num_of_digital_numbers());
                }
            }
        }
    }
    public function changeSellingPrice($index)
    {
        $this->rows[$index]['selling_price'] = number_format((float)$this->rows[$index]['dollar_selling_price'] * (float)$this->exchange_rate, num_of_digital_numbers());
    }
    public function changeDollarSellingPrice($index)
    {
        $this->rows[$index]['dollar_selling_price'] = number_format((float)$this->rows[$index]['selling_price'] / (float)$this->exchange_rate, num_of_digital_numbers());
    }
    public function updateProductQuantityStore($product_id, $variation_id, $store_id, $new_quantity)
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
            $product_store->quantity_available += $qty_difference;
            $product_store->save();
        }

        return true;
    }
    public function addPriceRow()
    {
        $new_price = [
            'fill_id' => '',
            'price_type' => null,
            'price_category' => null,
            'price_currency' => null,
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
            'apply_on_all_customers' => 0,
            'parent_price' => 0,
            'discount_from_original_price' => true,
        ];
        $this->prices[] = $new_price;
    }
    public function addStoreRow()
    {
        $new_store = [
            'extra_store_id' => '',
            'data' => [
                [
                    'store_fill_id' => '',
                    'quantity' => '',
                ]
            ]
        ];
        array_unshift($this->fill_stores, $new_store);
    }
    public function addStoreDataRow($index)
    {
        $new_store_data = [
            'store_fill_id' => '',
            'quantity' => '',
        ];
        array_unshift($this->fill_stores[$index]['data'], $new_store_data);
    }
    public function addPrices()
    {
        $newRow = [
            'id' => '', 'sku' => '', 'quantity' => '', 'unit_id' => '', 'purchase_price' => '', 'prices' => [], 'fill' =>
            '', 'show_prices' => false,
        ];
        $this->rows[] = $newRow;
        $index = count($this->rows) - 1;
        // array_unshift($this->rows, $newRow);
        foreach ($this->customer_types as $customer_type) {
            $new_price = [
                'customer_type_id' => $customer_type->id,
                'customer_name' => $customer_type->name,
                'percent' => null,
                'dollar_increase' => 0,
                'dinar_increase' => null,
                'dollar_sell_price' => 0,
                'dinar_sell_price' => null,
                'quantity' => null,
                'discount_from_original_price' => 1,
            ];
            array_unshift($this->rows[$index]['prices'], $new_price);
        }
        // Set 'show_prices' to false for all existing rows
        if ($this->rows[0]['show_prices'] == true) {
            foreach ($this->rows as &$row) {
                $row['show_prices'] = true;
            }
        }
    }
    public function stayShow()
    {
        foreach ($this->rows as &$row) {
            $row['show_prices'] =
                !$row['show_prices'];
        }
    }
    public function changeUnitPrices($key)
    {
        foreach ($this->rows as $index => $row) {
            if ($index > $key) {
                $this->changeFill($index);
            }
        }
    }
    public function getStore()
    {
        if (!empty($this->item[0]['store_id'])) {
            return __('lang.store') . ' : ' . Store::find($this->item[0]['store_id'])?->name;
        }
    }
    public function getExtraFillStore($key)
    {
        if (!empty($this->fill_stores[$key]['extra_store_id'])) {
            return __('lang.store') . ' : ' . Store::find($this->fill_stores[$key]['extra_store_id'])?->name;
        }
    }
    public function changePercent($index, $key)
    {
        $purchase_price = $this->num_uf($this->rows[$index]['purchase_price']);
        $percent = $this->num_uf($this->rows[$index]['prices'][$key]['percent']);
        if ($this->transaction_currency != 2) {

            $this->rows[$index]['prices'][$key]['dinar_increase'] = ($purchase_price * $percent) / 100;
            $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase'])  / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format(($purchase_price / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
        } else {
            $this->rows[$index]['prices'][$key]['dollar_increase'] = ($purchase_price * $percent) / 100;
            $this->rows[$index]['prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase'])  * $this->num_uf($this->exchange_rate), num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format(($purchase_price * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
        }
        $this->changeUnitPrices($index);
    }
    public function changeIncrease($index, $key)
    {
        $purchase_price = $this->num_uf($this->rows[$index]['purchase_price']);
        $percent = $this->num_uf($this->rows[$index]['prices'][$key]['percent']);
        if ($this->transaction_currency != 2) {
            if ($percent == 0 || $percent == null) {
                $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
                $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format(($purchase_price / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
            }
        } else {
            if ($percent == 0 || $percent == null) {
                $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']));
                $this->rows[$index]['prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) * $this->num_uf($this->exchange_rate));
                $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format(($purchase_price * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
                $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
            }
        }
        $this->changeUnitPrices($index);
    }
    public function  changeFill($index)
    {
        $fill = $this->num_uf($this->rows[$index]['fill']);
        $purchase_price = $this->num_uf($this->rows[$index - 1]['purchase_price']);
        $this->changeUnitPurchasePrice($index - 1);
        if ($fill < 1) {
            $fill = 1;
        }
        $this->rows[$index]['purchase_price'] = number_format($purchase_price / $fill, num_of_digital_numbers());

        foreach ($this->rows[$index]['prices'] as $key => $price) {
            $this->rows[$index]['prices'][$key]['percent'] = $this->rows[$index - 1]['prices'][$key]['percent'];
            if ($this->rows[$index]['prices'][$key]['percent'] != null) {
                $this->changePercent($index, $key);
            } else if (!empty($this->rows[$index]['prices'][$key]['dinar_increase']) || !empty($this->rows[$index]['prices'][$key]['dollar_increase'])) {
                $this->rows[$index]['prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->rows[$index - 1]['prices'][$key]['dinar_increase']) / $this->num_uf($fill), num_of_digital_numbers());
                $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index - 1]['prices'][$key]['dollar_increase']) / $this->num_uf($fill), num_of_digital_numbers());
                // $this->changeIncrease($index, $key);
            } else {
                $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($this->num_uf($this->rows[$index - 1]['prices'][$key]['dinar_sell_price']) / $this->num_uf($fill), num_of_digital_numbers());
                $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($this->num_uf($this->rows[$index - 1]['prices'][$key]['dollar_sell_price']) / $this->num_uf($fill), num_of_digital_numbers());
            }
        }
    }
    public function changeUnitPurchasePrice($index)
    {
        foreach ($this->rows[$index]['prices'] as $key => $price) {
            $purchase_price = $this->num_uf($this->rows[$index]['purchase_price']);
            $percent = $this->num_uf($this->rows[$index]['prices'][$key]['percent']);
            $amount = $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']);
            if ($this->transaction_currency != 2) {
                if ((($percent != 0 || $percent != null) || ($amount != 0 || $amount != null))) {
                    // $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
                    $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format(($purchase_price / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
                }
            } else {
                if ((($percent != 0 || $percent != null) || ($amount != 0 || $amount != null))) {
                    $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format(($purchase_price * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
                    $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
                    // $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']));
                    // $this->rows[$index]['prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) * $this->num_uf($this->exchange_rate));
                }
            }
        }
    }
    public function showDiscount()
    {
        $this->show_discount = !($this->show_discount);
    }
    public function showStore()
    {
        $this->show_store = !($this->show_store);
    }
    public function showDimensions()
    {
        $this->show_dimensions = !($this->show_dimensions);
    }
    public function showCategory1()
    {
        if ($this->show_category1 == 0) {
            $this->show_category1 = 1;
        } else {
            $this->show_category1 = 0;
            $this->show_category2 = 0;
            $this->show_category3 = 0;
        }
    }
    public function showCategory2()
    {
        if ($this->show_category2 == 0) {
            $this->show_category2 = 1;
        } else {
            $this->show_category2 = 0;
            $this->show_category3 = 0;
        }
    }
    public function showCategory3()
    {
        $this->show_category3 = !($this->show_category3);
    }
    public function delete_price_raw($key)
    {
        if ($this->prices[$key]['apply_on_all_customers']) {
            foreach ($this->prices as $i => $price) {
                if ($i != $key) {
                    if ($this->prices[$key]['fill_id'] == $price['fill_id']) {
                        unset($this->prices[$i]);
                    }
                }
            }
        }
        unset($this->prices[$key]);
    }
    public function delete_store_raw($key)
    {
        unset($this->fill_stores[$key]);
    }
    public function delete_store_data_raw($index, $key)
    {
        unset($this->fill_stores[$index]['data'][$key]);
    }
    public function changePrice($index, $via = 'price')
    {
        $fill_id = $this->prices[$index]['fill_id'];
        $row_index = $this->getKey($fill_id) ?? null;
        $actual_price = 0;
        if ($row_index >= 0) {
            $customer_type = $this->prices[$index]['price_customer_types'];
            $price_key = $this->getCustomerType($row_index, $customer_type);
            // $this->discount_from_original_price = System::getProperty('discount_from_original_price');
            $sell_price = ($row_index >= 0) && isset($price_key) ?  $this->num_uf($this->rows[$row_index]['prices'][$price_key]['dinar_sell_price']) : null;
            $dollar_sell_price = ($row_index >= 0) && isset($price_key) ?  $this->num_uf($this->rows[$row_index]['prices'][$price_key]['dollar_sell_price']) : null;
            $total_quantity = $this->num_uf($this->prices[$index]['discount_quantity']) + $this->num_uf($this->prices[$index]['bonus_quantity']);
            if (!$this->prices[$index]['discount_from_original_price']  && !empty($this->prices[$index]['discount_quantity'])) {
                if ($this->prices[$index]['price_type'] == "fixed") {
                    if ($this->transaction_currency == 2) {
                        if (!empty($this->prices[$index]['dinar_price'])) {
                            if ($via == 'quantity' && !empty($this->prices[$index]['dinar_price']) && !empty($this->prices[$index]['price'])) {
                                $actual_price = $this->prices[$index]['price'];
                            } else {
                                $actual_price = $this->num_uf($this->prices[$index]['dinar_price']);
                                $this->prices[$index]['dinar_price'] = number_format($this->num_uf($this->prices[$index]['dinar_price']) * (float)$this->exchange_rate, num_of_digital_numbers());
                            }
                        }
                        $dollar_price = number_format($this->num_uf($actual_price), num_of_digital_numbers());
                    } else {
                        $dollar_price = number_format($this->num_uf($this->prices[$index]['dinar_price']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    }
                    $sell_price = ($sell_price * $this->prices[$index]['discount_quantity']) / ($total_quantity == 0 ? 1 : $total_quantity);
                    $dollar_sell_price = ($dollar_sell_price * $this->prices[$index]['discount_quantity']) / ($total_quantity == 0 ? 1 : $total_quantity);
                    $this->prices[$index]['price'] = $this->num_uf($dollar_price);
                    $this->prices[$index]['dinar_price_after_desc'] = number_format($this->num_uf($sell_price) - $this->num_uf($this->prices[$index]['dinar_price']), num_of_digital_numbers());
                    $this->prices[$index]['price_after_desc'] = number_format($this->num_uf($dollar_sell_price) - $this->num_uf($this->prices[$index]['price']), num_of_digital_numbers());
                } elseif ($this->prices[$index]['price_type'] === 'percentage') {
                    $percent = $this->num_uf($this->prices[$index]['dinar_price'])  / 100;
                    $this->prices[$index]['dinar_price_after_desc'] = number_format(($this->num_uf($sell_price) - ($percent * $this->num_uf($sell_price))), num_of_digital_numbers());
                    $this->prices[$index]['price_after_desc'] = number_format(($this->num_uf($dollar_sell_price) - ($percent * $this->num_uf($dollar_sell_price))), num_of_digital_numbers());
                    $this->prices[$index]['price'] = $this->num_uf($this->prices[$index]['dinar_price']);
                }
            } else {
                if ($this->prices[$index]['price_type'] == "fixed") {
                    if ($this->transaction_currency == 2) {
                        if (!empty($this->prices[$index]['dinar_price'])) {
                            if ($via == 'quantity' && !empty($this->prices[$index]['dinar_price']) && !empty($this->prices[$index]['price'])) {
                                $actual_price = $this->prices[$index]['price'];
                            } else {
                                $actual_price = $this->num_uf($this->prices[$index]['dinar_price']);
                                $this->prices[$index]['dinar_price'] = number_format($this->num_uf($this->prices[$index]['dinar_price']) * (float)$this->exchange_rate, num_of_digital_numbers());
                            }
                        }
                        $dollar_price = number_format($this->num_uf($actual_price), num_of_digital_numbers());
                    } else {
                        $dollar_price = number_format($this->num_uf($this->prices[$index]['dinar_price']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    }
                    $this->prices[$index]['price'] = $this->num_uf($dollar_price);
                    // dd($sell_price);
                    $this->prices[$index]['dinar_price_after_desc'] = number_format($this->num_uf($sell_price) - $this->num_uf($this->prices[$index]['dinar_price']), num_of_digital_numbers());
                    $this->prices[$index]['price_after_desc'] = number_format($this->num_uf($dollar_sell_price) - $this->num_uf($this->prices[$index]['price']), num_of_digital_numbers());
                } else {
                    $percent = $this->num_uf($this->prices[$index]['dinar_price'])  / 100;
                    $this->prices[$index]['dinar_price_after_desc'] = number_format(($this->num_uf($sell_price) - ($percent * $this->num_uf($sell_price))), num_of_digital_numbers());
                    $this->prices[$index]['price_after_desc'] = number_format(($this->num_uf($dollar_sell_price) - ($percent * $this->num_uf($dollar_sell_price))), num_of_digital_numbers());
                    $this->prices[$index]['price'] = $this->num_uf($this->prices[$index]['dinar_price']);
                }
            }
            $price = !empty($this->prices[$index]['dinar_price_after_desc']) ? $this->num_uf($this->prices[$index]['dinar_price_after_desc']) : $this->num_uf($sell_price);
            $dollar_price = !empty($this->prices[$index]['price_after_desc']) ? $this->num_uf($this->prices[$index]['price_after_desc']) : $this->num_uf($dollar_sell_price);

            if (!$this->prices[$index]['discount_from_original_price']) {
                $this->prices[$index]['total_price'] = number_format($this->num_uf($dollar_price) * ($total_quantity == 0 ? 1 : $total_quantity), num_of_digital_numbers());
                $this->prices[$index]['dinar_total_price'] = number_format($this->num_uf($price) * ($total_quantity == 0 ? 1 : $total_quantity), num_of_digital_numbers());
                $this->prices[$index]['dinar_piece_price'] = number_format($this->num_uf($this->prices[$index]['dinar_price_after_desc']), num_of_digital_numbers());
                $this->prices[$index]['piece_price'] = number_format($this->num_uf($this->prices[$index]['price_after_desc']), num_of_digital_numbers());
            } else {
                $this->prices[$index]['total_price'] = number_format($this->num_uf($dollar_price) * $this->num_uf($this->prices[$index]['discount_quantity']), num_of_digital_numbers());
                $this->prices[$index]['dinar_total_price'] = number_format($this->num_uf($price) * $this->num_uf($this->prices[$index]['discount_quantity']), num_of_digital_numbers());
                $this->prices[$index]['dinar_piece_price'] = $total_quantity > 0 ? number_format($this->num_uf($this->prices[$index]['dinar_total_price']) /  $total_quantity, num_of_digital_numbers()) : 0;
                $this->prices[$index]['piece_price'] = number_format($this->num_uf($this->prices[$index]['total_price']) / ($total_quantity == 0 ? 1 : $total_quantity), num_of_digital_numbers());
            }
        }
    }
    public function applyOnAllCustomers($key)
    {
        $fill_id = $this->prices[$key]['fill_id'];
        if ($this->prices[$key]['apply_on_all_customers'] == 1) {
            $row_index = $this->getKey($fill_id) ?? null;
            if ($row_index >= 0) {
                $customer_type = $this->prices[$key]['price_customer_types'];
                $price_key = $this->getCustomerType($row_index, $customer_type);
                $percent = ($this->num_uf($this->prices[$key]['dinar_price'] ?? 1) / $this->num_uf($this->rows[$row_index]['prices'][$price_key]['dinar_sell_price'] ?? 1));
                $dollar_percent = ($this->num_uf($this->prices[$key]['price'] ?? 1) / $this->num_uf($this->rows[$row_index]['prices'][$price_key]['dollar_sell_price'] ?? 1));
                if ($price_key >= 0) {
                    foreach ($this->rows[$row_index]['prices'] as $index => $price) {
                        if ($price['customer_type_id'] != $this->prices[$key]['price_customer_types']) {
                            $dinar_price_value = $this->num_uf($this->rows[$row_index]['prices'][$index]['dinar_sell_price']) * ($percent);
                            $price_value = $this->num_uf($this->rows[$row_index]['prices'][$index]['dollar_sell_price']) * ($dollar_percent);
                            $new_price = [
                                'fill_id' => $this->prices[$key]['fill_id'],
                                'price_type' => $this->prices[$key]['price_type'],
                                'price_category' => $this->prices[$key]['price_category'],
                                'price_currency' => $this->prices[$key]['price_currency'],
                                'price' => $this->prices[$key]['price_type'] == 'percentage' ? $this->prices[$key]['price'] : ($price_value ?? 0),
                                'dinar_price' => $this->prices[$key]['price_type'] == 'percentage' ? $this->prices[$key]['dinar_price'] : ($dinar_price_value ?? 0),
                                'discount_quantity' => $this->prices[$key]['discount_quantity'],
                                'bonus_quantity' => $this->prices[$key]['bonus_quantity'],
                                'price_customer_types' => $this->rows[$row_index]['prices'][$index]['customer_type_id'],
                                'price_after_desc' => $this->prices[$key]['price_type'] == $this->prices[$key]['price_after_desc'],
                                'dinar_price_after_desc' => $this->prices[$key]['dinar_price_after_desc'],
                                'total_price' => $this->prices[$key]['total_price'],
                                'dinar_total_price' => $this->prices[$key]['dinar_total_price'],
                                'piece_price' => $this->prices[$key]['piece_price'],
                                'dinar_piece_price' => $this->prices[$key]['dinar_piece_price'],
                                'apply_on_all_customers' => 0,
                                'parent_price' => 1,
                                'discount_from_original_price' => 0,
                            ];
                            $this->prices[] = $new_price;
                            $this->changePrice(count($this->prices) - 1);
                        }
                    }
                }
            }
        } else {
            foreach ($this->prices as $i => $price) {
                if ($i != $key) {
                    if ($fill_id == $price['fill_id']) {
                        unset($this->prices[$i]);
                    }
                }
            }
        }
    }
    public function getKey($fill_id)
    {
        foreach ($this->rows as $key => $row) {
            if ($this->rows[$key]['unit_id'] == $fill_id) {
                return $key;
            }
        }
    }
    public function getCustomerType($index, $customer_type)
    {
        if (isset($index)) {
            foreach ($this->rows[$index]['prices'] as $key => $row) {
                if ($this->rows[$index]['prices'][$key]['customer_type_id'] == $customer_type) {
                    return $key;
                }
            }
        }
    }
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';
        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);
        return (float)$num;
    }
    public function changeSellPrice($index, $key)
    {
        if ($this->transaction_currency == 2) {
            $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($this->rows[$index]['prices'][$key]['dinar_sell_price'], num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) * $this->num_uf($this->exchange_rate), num_of_digital_numbers());
        } else {
            $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
        }
        $this->changeUnitPrices($index);
    }
    public function toggle_suppliers_dropdown()
    {
        if ($this->toggle_customers_dropdown) {
            $this->item[0]['supplier_id'] = 0;
        } else {
            $this->item[0]['customer_id'] = 0;
        }
    }
}
