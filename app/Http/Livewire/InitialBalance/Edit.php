<?php

namespace App\Http\Livewire\InitialBalance;

use App\Models\AddStockLine;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Country;
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
use App\Models\VariationPrice;
use App\Models\VariationStockline;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

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
            'isExist' => 0,
            'status' => '',
            'product_tax_id' => '',
            'change_current_stock' => 0,
            'basic_unit_variation_id' => '',
            'method' => '',
            'exchange_rate' => 0,
            'product_symbol' => '',
            'balance_return_request' => ''
        ]
    ];
    public $prices = [
        //        'apply_on_all_customers' => 0,
    ];
    public $fill_stores = [
        [
            'stock_id' => '',
            'extra_store_id' => '',
            'data' => [
                [
                    'stock_line_id' => '',
                    'store_fill_id' => '',
                    'quantity' => '',
                ]
            ]
        ]
    ];
    public $stockId;
    public $subcategories1 = [], $subcategories2 = [], $subcategories3 = [], $deleted_variations = [], $deleted_fill_stocks = [], $deleted_stocks = [];
    public $quantity = [], $purchase_price = [], $selling_price = [],
        $base_unit = [], $divide_costs, $total_size = [], $total_weight = [],
        $sub_total = [], $change_price_stock = [], $store_id, $status,
        $supplier, $exchange_rate, $exchangeRate, $transaction_date, $transaction_currency,
        $dollar_purchase_price = [], $dollar_selling_price = [], $dollar_sub_total = [], $dollar_cost = [], $dollar_total_cost = [],
        $current_stock, $totalQuantity = 0, $edit_product = [], $current_sub_category, $product_tax, $subcategories = [],
        $deleted_items = [], $deleted_prices = [], $discount_from_original_price, $basic_unit_variations = [], $unit_variations = [], $branches = [], $customer_types = [],
        $show_dimensions = 0, $show_category1 = 0, $show_category2 = 0, $show_category3 = 0, $show_discount = 0, $show_store = 1, $variations = [], $deteted_prices = [], $variationStoreSums, $variationFillStoreSums, $toggle_suppliers, $variationSums = [];
    public $rows = [], $countryId, $countryName, $stores_count, $units_count;

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
        $this->item[0]['size'] = $this->item[0]['height'] * $this->item[0]['length'] * $this->item[0]['width'];
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
            } else if ($data['var1'] == "fill_id" && $data['var3'] !== '') {
                $this->prices[$data['var3']]['fill_id'] = $data['var2'];
            } else if ($data['var1'] == "store_fill_id" && $data['var3'] !== '') {
                $this->fill_stores[$data['var3']]['data'][$data['var4']]['store_fill_id'] = $data['var2'];
            } else if ($data['var1'] == "extra_store_id" && $data['var3'] !== '') {
                $this->fill_stores[$data['var3']]['extra_store_id'] = $data['var2'];
            } else if ($data['var1'] == "price_customer_types" && $data['var3'] !== '') {
                $this->prices[$data['var3']]['price_customer_types'] = $data['var2'];
                $this->changePrice($data['var3']);
//                $row = $this->rows[$data['var3']]['prices'][$data['var4']]['price_customer_types'] = $data['var2'];
                // dd($data['var2']);
                // $row[$data['var4']]['price_customer_types']=$data['var2'];

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
            }
            $this->subcategories = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            $this->exchange_rate = $this->changeExchangeRate();
        }
    }

    public function addStoreRow()
    {
        $new_store = [
            'stock_id' => '',
            'extra_store_id' => '',
            'data' => [
                [
                    'stock_line_id' => '',
                    'store_fill_id' => '',
                    'quantity' => '',
                ]
            ]
        ];
        array_unshift($this->fill_stores, $new_store);
        $this->calculateFillStoreCount();
    }

    public $fill_stores_count;

    public function calculateFillStoreCount()
    {
        $this->fill_stores_count = count($this->fill_stores);
    }


    public function addStoreDataRow($index)
    {
        // dd($this->fill_stores);
        $new_store_data = [
            'stock_line_id' => '',
            'store_fill_id' => '',
            'quantity' => '',
        ];
        array_unshift($this->fill_stores[$index]['data'], $new_store_data);
    }

    public $basic_unit_variations_count;

    public function calculateBasicUnitVariationsCount()
    {
        $this->basic_unit_variations_count = $this->basic_unit_variations->count();
    }

    public $rows_count;

    public function calculateRowsCount()
    {
        $this->rows_count = count($this->rows);
    }

    public function addPrices()
    {
        $newRow = [
            'id' => '',
            'stock_line_id' => '',
            'sku' => '',
            'quantity' => '',
            'unit_id' => '',
            'purchase_price' => '',
            'prices' => [],
            'fill' =>
                '',
            'show_prices' => false,
        ];
        $this->rows[] = $newRow;
        $index = count($this->rows) - 1;

        $this->calculateRowsCount();
        // array_unshift($this->rows, $newRow);
        foreach ($this->customer_types as $customer_type) {
            $new_price = [
                'id' => null,
                'customer_type_id' => $customer_type->id,
                'customer_name' => $customer_type->name,
                'percent' => null,
                'dollar_increase' => 0,
                'dinar_increase' => null,
                'dollar_sell_price' => null,
                'dinar_sell_price' => null,
                'quantity' => null,
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
            $row['show_prices'] = !$row['show_prices'];
        }
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
            'discount_from_original_price' => 0,
        ];
        $this->prices[] = $new_price;

    }

    public function changeFill($index)
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
            } else if (!empty($this->rows[$index - 1]['prices'][$key]['dinar_increase']) || !empty($this->rows[$index - 1]['prices'][$key]['dollar_increase'])) {
                $this->rows[$index]['prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->rows[$index - 1]['prices'][$key]['dinar_increase']) / $this->num_uf($fill), num_of_digital_numbers());
                $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index - 1]['prices'][$key]['dollar_increase']) / $this->num_uf($fill), num_of_digital_numbers());
                if ($this->transaction_currency != 2) {
                    $dinar_sell_price = $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) + ($this->num_uf($this->rows[$index]['purchase_price']));
                    $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($dinar_sell_price, num_of_digital_numbers());
                    $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($dinar_sell_price / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                } else {
                    $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) + ($this->num_uf($this->rows[$index]['purchase_price']) * $this->num_uf($this->exchange_rate)), num_of_digital_numbers());
                    //                    dd($this->rows[$index][]);
                    $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($this->num_uf($this->rows[$index]['purchase_price']) + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
                }
                // $this->changeIncrease($index, $key);
            } else {
                $this->rows[$index]['prices'][$key]['dinar_increase'] = $this->rows[$index - 1]['prices'][$key]['dinar_increase'] ?? 0;
                $this->rows[$index]['prices'][$key]['dollar_increase'] = $this->rows[$index - 1]['prices'][$key]['dollar_increase'] ?? 0;
                $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($this->num_uf($this->rows[$index - 1]['prices'][$key]['dinar_sell_price']) / $this->num_uf($fill), num_of_digital_numbers());
                $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($this->num_uf($this->rows[$index - 1]['prices'][$key]['dollar_sell_price']) / $this->num_uf($fill), num_of_digital_numbers());
            }
        }
    }

    public function changeUnitPurchasePrice($index)
    {
        $purchase_price = $this->num_uf($this->rows[$index]['purchase_price']);
        foreach ($this->rows[$index]['prices'] as $key => $price) {
            if ($index == 0 && $key > 0 && !empty($this->rows[$key]['fill'])) {
                $this->rows[$key]['purchase_price'] = number_format($this->num_uf($this->rows[$key - 1]['purchase_price']) / $this->num_uf($this->rows[$key]['fill']), num_of_digital_numbers());
                $this->changeUnitPurchasePrice($key);
            }
            $percent = $this->num_uf($this->rows[$index]['prices'][$key]['percent']);
            $amount = $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']);
            if ($this->transaction_currency != 2) {
                if ((($percent != 0 || $percent != null) || ($amount != 0 || $amount != null))) {
                    if (($percent != 0 && $percent != null)) {
                        $this->rows[$index]['prices'][$key]['dinar_increase'] = ($purchase_price * $percent) / 100;
                        $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    }
                    // $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
                    $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format(($purchase_price / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase'] ?? 0), num_of_digital_numbers());
                }
            } else {
                if ((($percent != 0 || $percent != null) || ($amount != 0 || $amount != null))) {
                    if (($percent != 0 && $percent != null)) {
                        $this->rows[$index]['prices'][$key]['dollar_increase'] = ($purchase_price * $percent) / 100;
                        $this->rows[$index]['prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']) * $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    }
                    $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format(($purchase_price * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
                    $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase'] ?? 0), num_of_digital_numbers());
                }
            }
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

    public function render()
    {
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $this->branches = Branch::where('type', 'branch')->orderBy('created_by', 'desc')->pluck('name', 'id');
//        $this->discount_from_original_price = System::getProperty('discount_from_original_price');
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $categories = Category::orderBy('name', 'asc')->where('parent_id', 1)->pluck('name', 'id')->toArray();
        $this->subcategories = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $products = Product::all();
        $stores = Store::getDropdown();
        $this->stores_count = count($stores);
        $units = Unit::orderBy('created_at', 'desc')->get();
        $this->units_count = $units->count();
        $basic_units = Unit::orderBy('created_at', 'desc')->pluck('name', 'id');
        $product_taxes = Tax::select('name', 'id', 'status')->get();
        $customer_types = CustomerType::latest()->get();
        $this->dispatchBrowserEvent('initialize-select2');
        $this->count_total_by_variations();
        $this->dispatchBrowserEvent('componentRefreshed');

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
        $this->customer_types = CustomerType::orderBy('name', 'desc')->get();
        $recent_stocks = StockTransaction::where('id', $stockId)->where('type', 'initial_balance')->orderBy('created_at', 'desc')->get();
        // dd(count($recent_stocks));
        foreach ($recent_stocks as $recent_stock) {
            if (!empty($recent_stock)) {
                $this->transaction_currency = $recent_stock->transaction_currency;
                $this->item[0]['stockId'] = $stockId;
                $this->item[0]['id'] = $recent_stock->add_stock_lines->first()->product->id ?? null;
                $this->item[0]['store_id'] = $recent_stock->store_id;
                $this->item[0]['supplier_id'] = $recent_stock->supplier_id;
                $this->item[0]['name'] = $recent_stock->add_stock_lines->first()->product->name ?? null;
                $this->item[0]['exchange_rate'] = $recent_stock->exchange_rate;
                $this->item[0]['balance_return_request'] = $recent_stock->add_stock_lines->first()->product->balance_return_request ?? null;
                $this->item[0]['category_id'] = $recent_stock->add_stock_lines->first()->product->category_id ?? null;
                $this->item[0]['product_symbol'] = $recent_stock->add_stock_lines->first()->product->product_symbol ?? null;
                if (!empty($this->item[0]['category_id'])) {
                    $this->subcategories1 = Category::where('parent_id', 2)->orderBy('name', 'asc')->pluck('name', 'id');
                }
                $this->item[0]['subcategory_id1'] = $recent_stock->add_stock_lines->first()->product->subcategory_id1 ?? null;
                if (!empty($this->item[0]['subcategory_id1'])) {
                    $this->subcategories2 = Category::where('parent_id', 3)->orderBy('name', 'asc')->pluck('name', 'id');
                }
                $this->item[0]['subcategory_id2'] = $recent_stock->add_stock_lines->first()->product->subcategory_id2 ?? null;
                if (!empty($this->item[0]['subcategory_id2'])) {
                    $this->subcategories3 = Category::where('parent_id', 4)->orderBy('name', 'asc')->pluck('name', 'id');
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
                $previousEqual = 0; // Initialize with default value
                foreach ($recent_stock->add_stock_lines as $stock) {
                    if (!empty($stock->variation)) {
                        $newRow = [
                            'stock_line_id' => $stock->id,
                            'id' => $stock->variation->id,
                            'sku' => $stock->variation->sku,
                            'quantity' => $stock->quantity,
                            'purchase_price' => ($this->transaction_currency == 2) ? number_format($stock->dollar_purchase_price * $this->num_uf($this->exchangeRate), num_of_digital_numbers()) : number_format($stock->purchase_price, num_of_digital_numbers()),
                            'unit_id' => $stock->variation->unit_id,
                            'fill_currency' => 'dinar',
                            'prices' => [],
                            'fill' => $previousEqual,
                            'show_prices' => false,
                        ];
                        // Update previousEqual for the next iteration
                        $previousEqual = $stock->variation->equal ?? 0;
                        // $this->rows[] = $newRow;


                        $this->unit_variations[] = $stock->variation->unit_id;

                        // $new_price=[];
                        if (!empty($stock->prices->isNotEmpty())) {
                            foreach ($stock->prices as $price) {
                                $new_price = [
                                    'id' => $price->id,
                                    'fill_id' => $price['unit_id'] ?? null,
                                    'stock_line_id' => $price->stock_line_id,
                                    'price_type' => $price->price_type,
                                    'price_category' => $price->price_category,
                                    'price' => $price->price,
                                    'dinar_price' => $price->dinar_price,
                                    'price_currency' => 'dinar',
                                    'discount_quantity' => $price->quantity,
                                    'bonus_quantity' => $price->bonus_quantity,
                                    'price_customer_types' => $price->price_customer_types,
                                    'price_after_desc' => $price->price_customers,
                                    'dinar_price_after_desc' => $price->dinar_price_customers,
                                    'product_price_id' => $price->id,
                                    'total_price' => $price->total_price,
                                    'piece_price' => $price->piece_price,
//                                    'dinar_price' => $price->dinar_price,
                                    'dinar_total_price' => $price->dinar_total_price,
                                    'dinar_piece_price' => $price->dinar_piece_price,
                                    'discount_from_original_price' => $price->dinar_piece_price == $price->dinar_price_customers ? false : true,
                                ];
                                array_unshift($this->prices, $new_price);
                            }
                        }
                        // else {
                        //     $new_price = [
                        //         'fill_id' => null,
                        //         'stock_line_id' => null,
                        //         'price_type' => null,
                        //         'price_category' => null,
                        //         'price' => null,
                        //         'price_currency' => 'dollar',
                        //         'discount_quantity' => null,
                        //         'bonus_quantity' => null,
                        //         'price_customer_types' => null,
                        //         'price_after_desc' => null,
                        //         'dinar_price_after_desc' => null,
                        //         'total_price' => null,
                        //         'piece_price' => null,
                        //         'dinar_price' => null,
                        //         'dinar_total_price' => null,
                        //         'dinar_piece_price' => null,
                        //         'discount_from_original_price' => false,
                        //     ];
                        //     array_unshift($this->prices, $new_price);
                        // }
                        $this->rows[] = $newRow;

                        $index = count($this->rows) - 1;
                        foreach ($this->customer_types as $customer_type) {
                            $v_price = VariationPrice::where('customer_type_id', $customer_type->id)->where('variation_id', $stock->variation->id)->first();
                            // dd(44);
                            if (!empty($v_price)) {
                                $new_price = [
                                    'id' => $v_price->id,
                                    'variation_id' => $v_price->variation_id,
                                    'customer_type_id' => $v_price->customer_type_id,
                                    'customer_name' => $customer_type->name,
                                    'percent' => number_format($v_price->percent, num_of_digital_numbers()),
                                    // 'dollar_increase' => 0,
                                    // 'dinar_increase' => null,
                                    'dollar_sell_price' => number_format($v_price->dollar_sell_price, num_of_digital_numbers()),
                                    'dinar_sell_price' => number_format($v_price->dinar_sell_price, num_of_digital_numbers()),
                                    'quantity' => $v_price->quantity,
                                    'dinar_increase' => number_format($v_price->dinar_increase, num_of_digital_numbers()),
                                    'dollar_increase' => number_format($v_price->dollar_increase, num_of_digital_numbers()),
                                ];
                                $this->rows[$index]['prices'][] = $new_price;
                            } else {
                                $new_price = [
                                    'id' => null,
                                    'customer_type_id' => $customer_type->id,
                                    'customer_name' => $customer_type->name,
                                    'percent' => null,
                                    'dollar_sell_price' => null,
                                    'dinar_sell_price' => null,
                                    'quantity' => null,
                                ];
                                $this->rows[$index]['prices'][] = $new_price;
                            }
                        }
                    }
                }
                $this->basic_unit_variations = Unit::whereIn('id', $this->unit_variations)->orderBy('name', 'asc')->pluck('name', 'id');

                $this->calculateBasicUnitVariationsCount();
                $this->item[0]['basic_unit_variation_id'] = Variation::find($recent_stock->add_stock_lines->first()->product->product_dimensions->variation_id ?? 0)->unit_id ?? null;
                ///////////////////////
                $recent_stock_extra = StockTransaction::where('parent_transction', $stockId)->where('type', 'initial_balance')->orderBy('created_at', 'desc')->get();
                foreach ($recent_stock_extra as $i => $stock) {
                    $new_store = [
                        'stock_id' => $stock->id,
                        'extra_store_id' => $stock->store_id,
                        'data' => []
                    ];
                    $this->fill_stores[$i] = $new_store;
                    foreach ($stock->add_stock_lines as $stockline) {
                        $data = [
                            'stock_line_id' => $stockline->id,
                            'store_fill_id' => $stockline->variation->unit_id,
                            'quantity' => $stockline->quantity,
                        ];
                        $this->fill_stores[$i]['data'][] = $data;
                    }
                }
            }
        }
        $this->countryId = System::getProperty('country_id');
        $this->countryName = Country::where('id', $this->countryId)->pluck('name')->first();
        $this->calculateTotalQuantity();
        $this->dispatchBrowserEvent('initialize-select2');
        $this->count_total_by_variation_stores();
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
        $this->calculateBasicUnitVariationsCount();
    }

    public function changeBaseUnit($index)
    {
        //////////////////////////////// calculate row based on other rows//////////////
        $base_unit = $this->rows[$index]['basic_unit_id'];
        $unit_index = '';
        $basic_unit_index = '';
        foreach ($this->rows as $i => $item) {
            if ($i != $index) {
                if ($item['unit_id'] === $base_unit) {
                    $unit_index = $i;
                    break;
                }
            }
        }
        if ($unit_index == '') {
            foreach ($this->rows as $i => $item) {
                if ($i != $index) {
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
                $this->rows[$index]['purchase_price'] = number_format(($this->num_uf($this->rows[$unit_index]['purchase_price'])) * (float)$this->rows[$index]['equal'], num_of_digital_numbers());
                $this->rows[$index]['selling_price'] = ($this->num_uf($this->rows[$unit_index]['selling_price'])) * (float)$this->rows[$index]['equal'];
                // dd($this->rows[$unit_index]);
                if ($this->rows[$index]['fill_type'] == "fixed") {
                    $this->rows[$index]['fill_quantity'] = ($this->num_uf($this->rows[$unit_index]['fill_quantity'])) * (float)$this->rows[$index]['equal'];
                    $this->rows[$index]['fill_currency'] = $this->rows[$unit_index]['fill_currency'];
                } else {
                    $this->rows[$index]['fill_quantity'] = $this->rows[$unit_index]['fill_quantity'];
                }
                // $this->changePurchasePrice($index);
            }
        } else {
            if ($basic_unit_index !== '') {
                $this->rows[$index]['quantity'] = 0;
                $this->rows[$index]['fill_type'] = $this->rows[$basic_unit_index]['fill_type'];
                if ((float)$this->rows[$basic_unit_index]['equal'] != 0) {
                    $this->rows[$index]['dollar_purchase_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['dollar_purchase_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], num_of_digital_numbers());
                    $this->rows[$index]['purchase_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['purchase_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], num_of_digital_numbers());
                    $this->rows[$index]['dollar_selling_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['dollar_selling_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], num_of_digital_numbers());
                    $this->rows[$index]['selling_price'] = number_format(($this->num_uf($this->rows[$basic_unit_index]['selling_price']) / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], num_of_digital_numbers());
                    // dd($this->rows[$basic_unit_index]);
                    if ($this->rows[$index]['fill_type'] == "fixed") {
                        $this->rows[$index]['fill_quantity'] = number_format(((float)$this->rows[$basic_unit_index]['fill_quantity'] / (float)$this->rows[$basic_unit_index]['equal']) * (float)$this->rows[$index]['equal'], num_of_digital_numbers());
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
//        try {
        if (empty($this->rows)) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.add_sku_with_sku_for_product'),]);
        } else {
            DB::beginTransaction();
            // Add stock transaction
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
            $product->balance_return_request = $this->item[0]['balance_return_request'] ?? 0;
            $product->save();
            if (!empty($this->item[0]['product_tax_id'])) {
                $product_tax = ProductTax::where('product_tax_id', $this->item[0]['product_tax_id'])->where('product_id', $product->id)->first();
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
            } else {
                $product_tax = ProductTax::where('product_id', $product->id)->delete();
            }
            // add  products to stock lines
            foreach ($this->rows as $index => $row) {
                if (!empty($row['id'])) {
                    $Variation = Variation::find($row['id']);
                } else {
                    $Variation = new Variation();
                }

                $Variation->sku = !empty($this->rows[$index]['sku']) ? $this->rows[$index]['sku'] : $this->generateSku($product->name);
                // $Variation->equal = !empty($this->rows[$index]['equal']) ? (float)$this->rows[$index]['equal'] : null;
                $Variation->product_id = $product->id;
                $Variation->equal = !empty($this->rows[$index + 1]) ? $this->num_uf($this->rows[$index + 1]['fill']) : null;
                $Variation->unit_id = isset($this->rows[$index]['unit_id']) && $this->rows[$index]['unit_id'] !== "" ? $this->rows[$index]['unit_id'] : null;
                $Variation->product_symbol = $this->item[0]['product_symbol'] . ($index + 1);
                $Variation->created_by = Auth::user()->id;
                $Variation->save();
                $this->variations[$index] = $Variation->id;
                foreach ($this->rows[$index]['prices'] as $key => $price) {
                    if (!empty($this->rows[$index]['prices'][$key]['id'])) {
                        $Variation_price = VariationPrice::find($this->rows[$index]['prices'][$key]['id']);
                    } else {
                        $Variation_price = new VariationPrice();
                    }
                    $Variation_price->variation_id = $Variation->id;
                    $Variation_price->customer_type_id = $this->rows[$index]['prices'][$key]['customer_type_id'] ?? null;
                    $Variation_price->dinar_increase = $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase'] ?? null);
                    $Variation_price->dollar_increase = $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase'] ?? null);

                    $Variation_price->dinar_sell_price = $this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) ?? null;
                    $Variation_price->dollar_sell_price = $this->num_uf($this->rows[$index]['prices'][$key]['dollar_sell_price']) ?? null;
                    $Variation_price->percent = $this->num_uf($this->rows[$index]['prices'][$key]['percent']) ?? null;

//                    $Variation_price->variation_id = $Variation->id;
//                    $Variation_price->customer_type_id = $price['customer_type_id'] ?? null;
//                    $Variation_price->dinar_sell_price = $this->num_uf($price['dinar_sell_price']) ?? null;
//                    $Variation_price->dollar_sell_price = ($this->num_uf($price['dollar_sell_price']) ?? null);
//                    $Variation_price->percent = $this->num_uf($price['percent']) ?? null;
//                    $Variation_price->dinar_increase = $this->num_uf($price['dinar_increase']) ?? null;
//                    $Variation_price->dollar_increase = $this->num_uf($price['dollar_increase']) ?? null;
                    $Variation_price->save();
                    // }
                }
            }

            Variation::whereIn('id', $this->deleted_variations)->delete();
            AddStockLine::whereIn('variation_id', $this->deleted_variations)->delete();
            AddStockLine::whereIn('id', $this->deleted_items)->delete();
            $variation_prices = VariationPrice::whereIn('variation_id', $this->deleted_variations)->pluck('id')->toArray();
            VariationPrice::whereIn('variation_id', $this->deleted_variations)->delete();
            VariationStockline::whereIn('variation_price_id', $variation_prices)->delete();
            if (
                $this->item[0]['height'] == ('' || 0) && $this->item[0]['width'] == ('' || 0)
                || $this->item[0]['size'] == ('' || 0) && $this->item[0]['weight'] == ('' || 0)
            ) {
                ProductDimension::where('product_id', $product->id)->delete();
            } else {
                // dd($this->item[0]['basic_unit_variation_id']);
                ProductDimension::where('product_id', $product->id)->update([
                    'product_id' => $product->id,
                    'variation_id' => !empty($this->item[0]['basic_unit_variation_id']) ? (Variation::where('product_id', $product->id)->where('unit_id', $this->item[0]['basic_unit_variation_id'])->first()->id ?? null) : null,
                    'height' => !empty($this->item[0]['height']) ? $this->item[0]['height'] : 0,
                    'length' => !empty($this->item[0]['length']) ? $this->item[0]['length'] : 0,
                    'width' => !empty($this->item[0]['width']) ? $this->item[0]['width'] : 0,
                    'weight' => !empty($this->item[0]['weight']) ? $this->item[0]['weight'] : 0,
                    'size' => !empty($this->item[0]['size']) ? $this->item[0]['size'] : 0,
                ]);
            }
            $this->saveTransaction($product->id);
            DB::commit();
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => __('lang.success'),]);
            return redirect()->route('initial-balance.edit', $this->stockId);
        }
//                 } catch (\Exception $e) {
//                     $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.something_went_wrongs'),]);
//                     dd($e);
//                 }
    }

    public function saveTransaction($product_id, $variations = [])
    {
        $transaction = StockTransaction::find($this->stockId);
        $transaction->store_id = $this->item[0]['store_id'];
        $transaction->status = 'received';
        $transaction->order_date = Carbon::now();
        $transaction->transaction_date = Carbon::now();
        $transaction->purchase_type = 'local';
        $transaction->type = 'initial_balance';
        $transaction->supplier_id = !empty($this->item[0]['supplier_id']) ? $this->item[0]['supplier_id'] : null;
        $transaction->transaction_currency = $this->transaction_currency;
        $transaction->created_by = Auth::user()->id;
        $transaction->parent_transction = 0;
        $transaction->save();
        foreach ($this->rows as $index => $row) {
            $add_stock_data = [
                'product_id' => $product_id,
                'variation_id' => Variation::where('product_id', $product_id)->where('unit_id', $this->rows[$index]['unit_id'])->first()->id ?? '',
                'stock_transaction_id' => $transaction->id,
                'quantity' => $this->rows[$index]['quantity'] !== '' ? $this->num_uf($this->rows[$index]['quantity']) : 0,
                'purchase_price' => ($this->transaction_currency != 2) ? $this->num_uf($this->rows[$index]['purchase_price']) : null,
                'sell_price' => null,
                'dollar_purchase_price' => ($this->transaction_currency == 2) ? $this->num_uf($this->rows[$index]['purchase_price']) / $this->num_uf($this->exchange_rate) : null,
                'dollar_sell_price' => null,
                'dollar_sub_total' => null,
                'exchange_rate' => !empty($this->exchange_rate) ? $this->num_uf($this->exchange_rate) : null,
                'store_id' => $this->item[0]['store_id'],
            ];
            if (!empty($this->rows[$index]['stock_line_id'])) {
                $stock_line = AddStockLine::find($this->rows[$index]['stock_line_id']);
                if (!empty($stock_line)) {
                    $stock_line->update($add_stock_data);
                }
            }
            else {
                AddStockLine::create($add_stock_data);
            }
        }
        ///////////////discouts for basic store ////////////////////////////////
        if (!empty($this->prices)) {
            foreach ($this->prices as $p => $price) {
                if (!empty($price['fill_id'])) {
                    if (!empty($price['dinar_price']) || !empty($price['discount_quantity'])) {
                        $variation_id = Variation::where('product_id', $product_id)->where('unit_id', $price['fill_id'])->first()->id ?? '';
                        $stock_line = AddStockLine::where('product_id', $product_id)->where('variation_id', $variation_id)->where('stock_transaction_id', $transaction->id)->first();
                        if ($stock_line){
                            $price_data = [
                                'variation_id' => $variation_id,
                                'stock_line_id' => isset($stock_line) ? $stock_line->id : 0,
                                'unit_id' => !empty($price['fill_id']) ? $price['fill_id'] : null,
                                'price_type' => !empty($price['price_type']) ? $price['price_type'] : null,
                                'price' => !empty($price['price']) ? $this->num_uf($price['price']) : null,
                                'dinar_price' => !empty($price['dinar_price']) ? $this->num_uf($price['dinar_price']) : null,
                                'price_customers' => !empty($price['price_after_desc']) ? $this->num_uf($price['price_after_desc']) : null,
                                'dinar_price_customers' => !empty($price['dinar_price_after_desc']) ? $this->num_uf($price['dinar_price_after_desc']) : null,
                                'price_category' => isset($price['price_category']) ? $price['price_category'] : null,
                                'quantity' => !empty($price['discount_quantity']) ? $this->num_uf($price['discount_quantity']) : null,
                                'bonus_quantity' => !empty($price['bonus_quantity']) ? $this->num_uf($price['bonus_quantity']) : null,
                                'price_customer_types' => !empty($price['price_customer_types']) ? $price['price_customer_types'] : null,
                                'created_by' => Auth::user()->id,
                                'dinar_total_price' => !empty($price['dinar_total_price']) ? $this->num_uf($price['dinar_total_price']) : null,
                                'total_price' => !empty($price['total_price']) ? $this->num_uf($price['total_price']) : null,
                                'dinar_piece_price' => !empty($price['dinar_piece_price']) ? $this->num_uf($price['dinar_piece_price']) : null,
                                'piece_price' => !empty($price['piece_price']) ? $this->num_uf($price['piece_price']) : null,
                            ];

                            if (!empty($price['id'])) {
                                if (!empty(ProductPrice::find($price['id']))) {
                                    ProductPrice::find($price['id'])->update($price_data);
                                }
                            } else {
                                ProductPrice::create($price_data);
                            }
                        }

                    }
                }
            }
        }
        ///////////////discouts for basic store ////////////////////////////////
        ///////////////////// Variation Stockline ///////////////////////
        foreach ($this->rows as $index => $row) {
            foreach ($row['prices'] as $key => $price) {
                if (!empty($this->rows[$index]['prices'][$key]['customer_type_id'])) {
                    if (!empty($this->rows[$index]['prices'][$key]['dollar_sell_price']) || !empty($this->rows[$index]['prices'][$key]['dinar_sell_price'])) {
                        $variation_id = Variation::where('product_id', $product_id)->where('unit_id', $this->rows[$index]['unit_id'])->first()->id ?? '';
                        $variation_price = VariationPrice::where('variation_id', $variation_id)->where('customer_type_id', $this->rows[$index]['prices'][$key]['customer_type_id'])->first();
                        $stock_line = AddStockLine::where('product_id', $product_id)->where('variation_id', $variation_id)->where('stock_transaction_id', $transaction->id)->first();

                        $add_variation_stock_data = [
                            'variation_price_id' => $variation_price->id,
                            'stock_line_id' => $stock_line->id,
                            'purchase_price' => ($this->transaction_currency != 2) ? $this->num_uf($this->rows[$index]['purchase_price']) : null,
                            'sell_price' => ($this->transaction_currency != 2) ? $this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) : null,
                            'sub_total' => !empty($this->sub_total[$index]) ? $this->num_uf((float)$this->sub_total[$index]) : null,
                            'dollar_purchase_price' => ($this->transaction_currency == 2) ? $this->num_uf($this->rows[$index]['purchase_price']) : null,
                            'dollar_sell_price' => ($this->transaction_currency == 2) ? ($this->num_uf($this->rows[$index]['prices'][$key]['dollar_sell_price'])) : 0,
                            'dollar_sub_total' => !empty($this->dollar_sub_total($index, $key)) ? $this->num_uf((float)$this->dollar_sub_total($index, $key)) : null,
                            // 'exchange_rate' => !empty($this->exchange_rate) ? $this->num_uf($this->exchange_rate)  : null,
                        ];
                        if (!empty(VariationStockline::where('variation_price_id', $variation_price->id)->where('stock_line_id', $stock_line->id)->first())) {
                            // $ids[]=VariationStockline::where('variation_price_id',$variation_price->id)->where('stock_line_id',$stock_line->id)->first()->id;
                            VariationStockline::where('variation_price_id', $variation_price->id)->where('stock_line_id', $stock_line->id)->update($add_variation_stock_data);
                        } else {
                            VariationStockline::create($add_variation_stock_data);
                        }
                    }
                }
            }
        }
        /////////////////// VariationStockline ////////////////////////////
        //************************************************************** */
        //////////////////////////////////
        for ($i = 0; $i < count($this->fill_stores); $i++) {

            if (!empty($this->fill_stores[$i]['extra_store_id'])) {

                if (!empty($this->fill_stores[$i]['stock_id'])) {
                    $transaction_store = StockTransaction::find($this->fill_stores[$i]['stock_id']);
                } else {
                    $transaction_store = new StockTransaction();
                }
                $store_id = !empty($this->fill_stores[$i]['extra_store_id']) ? $this->num_uf($this->fill_stores[$i]['extra_store_id']) : null;

                $transaction_store->store_id = !empty($this->fill_stores[$i]['extra_store_id']) ? $this->num_uf($this->fill_stores[$i]['extra_store_id']) : null;
                $transaction_store->status = 'received';
                $transaction_store->order_date = Carbon::now();
                $transaction_store->transaction_date = Carbon::now();
                $transaction_store->purchase_type = 'local';
                $transaction_store->type = 'initial_balance';
                $transaction_store->supplier_id = !empty($this->item[0]['supplier_id']) ? $this->item[0]['supplier_id'] : null;
                $transaction_store->transaction_currency = $this->transaction_currency;
                $transaction_store->created_by = Auth::user()->id;
                $transaction_store->parent_transction = $i >= 0 ? $this->stockId : 0;
                $transaction_store->save();

                foreach ($this->fill_stores[$i]['data'] as $key => $store) {
                    $purchase_price = $this->get_purchase_price($this->fill_stores[$i]['data'][$key]['store_fill_id']);
                    $variation = Variation::where('product_id', $product_id)->where('unit_id', $this->fill_stores[$i]['data'][$key]['store_fill_id'])->first();
                    $add_stock_data = [
                        'product_id' => $product_id,
                        'variation_id' => $variation_id ? $variation_id : $variation->id,
                        'stock_transaction_id' => $transaction_store->id,
                        'quantity' => $this->fill_stores[$i]['data'][$key] !== '' ? $this->num_uf($this->fill_stores[$i]['data'][$key]['quantity']) : 0,
                        'purchase_price' => ($this->transaction_currency != 2) ? $this->num_uf($purchase_price) : null,
                        'sell_price' => null,
                        'dollar_purchase_price' => ($this->transaction_currency == 2) ? $this->num_uf($purchase_price) : null,
                        'dollar_sell_price' => null,
                        'dollar_sub_total' => null,
                        'exchange_rate' => !empty($this->exchange_rate) ? $this->num_uf($this->exchange_rate) : null,
                    ];
                    if (!empty($this->fill_stores[$i]['data'][$key]['stock_line_id'])) {
                        $stock_line = AddStockLine::find($this->fill_stores[$i]['data'][$key]['stock_line_id']);
                        if (!empty($stock_line)) {
                            $stock_line->update($add_stock_data);
                        }
                    } else {
                        AddStockLine::create($add_stock_data);
                    }
                    $index = $this->getKey($variation->unit_id) ?? null;
                    foreach ($this->rows[$index]['prices'] as $key => $row) {
                        if (!empty($this->rows[$index]['prices'][$key]['customer_type_id'])) {
                            if (!empty($this->rows[$index]['prices'][$key]['dollar_sell_price']) || !empty($this->rows[$index]['prices'][$key]['dinar_sell_price'])) {
                                $variation_price = VariationPrice::where('variation_id', $variation->id)->where('customer_type_id', $this->rows[$index]['prices'][$key]['customer_type_id'])->first();
                                $stock_line = AddStockLine::where('product_id', $product_id)->where('variation_id', $variation_id)->where('stock_transaction_id', $transaction_store->id)->first();

                                $add_variation_stock_data = [
                                    'variation_price_id' => $variation_price->id,
                                    'stock_line_id' => $stock_line->id,
                                    // 'quantity' => ($i == -1) && $this->rows[$index]['quantity'] !== '' ? $this->num_uf($this->rows[$index]['quantity'])  : $quantity,
                                    'purchase_price' => ($this->transaction_currency != 2) ? $this->num_uf($this->rows[$index]['purchase_price']) : null,
                                    'sell_price' => ($this->transaction_currency != 2) ? $this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) : null,
                                    'sub_total' => !empty($this->sub_total[$index]) ? $this->num_uf((float)$this->sub_total[$index]) : null,
                                    'dollar_purchase_price' => ($this->transaction_currency == 2) ? $this->num_uf($this->rows[$index]['purchase_price']) : null,
                                    'dollar_sell_price' => ($this->transaction_currency == 2) ? ($this->num_uf($this->rows[$index]['prices'][$key]['dollar_sell_price'])) : 0,
                                    'dollar_sub_total' => !empty($this->dollar_sub_total($index, $key)) ? $this->num_uf((float)$this->dollar_sub_total($index, $key)) : null,
                                    // 'exchange_rate' => !empty($this->exchange_rate) ? $this->num_uf($this->exchange_rate)  : null,
                                ];
                                if (!empty(VariationStockline::where('variation_price_id', $variation_price->id)->where('stock_line_id', $stock_line->id)->first())) {
                                    VariationStockline::where('variation_price_id', $variation_price->id)->where('stock_line_id', $stock_line->id)->update($add_variation_stock_data);
                                } else {
                                    VariationStockline::create($add_variation_stock_data);
                                }
                            }
                        }
                    }
                }
                ///////////////discouts for stores ////////////////////////////////
                if (!empty($this->prices)) {
                    foreach ($this->prices as $p => $price) {
                        if (!empty($price['fill_id'])) {
                            if (!empty($price['dinar_price']) || !empty($price['discount_quantity'])) {
                                $variation_id = Variation::where('product_id', $product_id)->where('unit_id', $price['fill_id'])->first()->id ?? '';
                                $stock_line = AddStockLine::where('product_id', $product_id)->where('variation_id', $variation_id)->where('stock_transaction_id', $transaction_store->id)->first();
                                if ($stock_line) {
                                    $price_data = [
                                        'variation_id' => $variation_id,
                                        'stock_line_id' => isset($stock_line) ? $stock_line->id : 0,
                                        'unit_id' => !empty($price['fill_id']) ? $price['fill_id'] : null,
                                        'price_type' => !empty($price['price_type']) ? $price['price_type'] : null,
                                        'price' => !empty($price['price']) ? $this->num_uf($price['price']) : null,
                                        'dinar_price' => !empty($price['dinar_price']) ? $this->num_uf($price['dinar_price']) : null,
                                        'price_customers' => !empty($price['price_after_desc']) ? $this->num_uf($price['price_after_desc']) : null,
                                        'dinar_price_customers' => !empty($price['dinar_price_after_desc']) ? $this->num_uf($price['dinar_price_after_desc']) : null,
                                        'price_category' => isset($price['price_category']) ? $price['price_category'] : null,
                                        'quantity' => !empty($price['discount_quantity']) ? $this->num_uf($price['discount_quantity']) : null,
                                        'bonus_quantity' => !empty($price['bonus_quantity']) ? $this->num_uf($price['bonus_quantity']) : null,
                                        'price_customer_types' => !empty($price['price_customer_types']) ? $price['price_customer_types'] : null,
                                        'created_by' => Auth::user()->id,
                                        'dinar_total_price' => !empty($price['dinar_total_price']) ? $this->num_uf($price['dinar_total_price']) : null,
                                        'total_price' => !empty($price['total_price']) ? $this->num_uf($price['total_price']) : null,
                                        'dinar_piece_price' => !empty($price['dinar_piece_price']) ? $this->num_uf($price['dinar_piece_price']) : null,
                                        'piece_price' => !empty($price['piece_price']) ? $this->num_uf($price['piece_price']) : null,
                                    ];

                                    if (!empty($price['id'])) {
                                        $product_price = ProductPrice::find($price['id']);
                                        if ($product_price) {
                                            $product_price->update($price_data);
                                        }
                                    } else {
                                        ProductPrice::create($price_data);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (!empty($this->deteted_prices)) {
            foreach ($this->deteted_prices as $index =>  $element){
                if (is_array($element)){
                    unset($this->deteted_prices[$index]);
                }
            }
            ProductPrice::whereIn('id', $this->deteted_prices)->delete();
        }
        StockTransaction::whereIn('id', $this->deleted_stocks)->delete();
        $stock_lines = AddStockLine::whereIn('stock_transaction_id', $this->deleted_stocks)->pluck('id')->toArray();
        AddStockLine::whereIn('stock_transaction_id', $this->deleted_stocks)->delete();
        AddStockLine::whereIn('id', $this->deleted_fill_stocks)->delete();
        ProductPrice::whereIn('stock_line_id', $stock_lines)->delete();
        ProductPrice::whereIn('stock_line_id', $this->deleted_fill_stocks)->delete();
        VariationStockline::whereIn('stock_line_id', $stock_lines)->delete();
        VariationStockline::whereIn('stock_line_id', $this->deleted_fill_stocks)->delete();
    }

    public function get_purchase_price($store_fill_id)
    {
        foreach ($this->rows as $index => $row) {
            if ($this->rows[$index]['unit_id'] == $store_fill_id) {
                return $this->rows[$index]['purchase_price'];
            }
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
        $this->subcategories1 = Category::where('parent_id', 2)->orderBy('name', 'asc')->pluck('name', 'id');
        $this->subcategories2 = Category::where('parent_id', 3)->orderBy('name', 'asc')->pluck('name', 'id');
        $this->subcategories3 = Category::where('parent_id', 4)->orderBy('name', 'asc')->pluck('name', 'id');
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
                'supplier_id' => '',
                'product_tax_id' => ''
            ];


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
                    'show_prices' => false,
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
        if (isset($this->rows[$index]['quantity']) && (isset($this->rows[$index]['purchase_price']) || isset($this->dollar_purchase_price[$index]))) {
            // convert purchase price from Dollar To Dinar
            $purchase_price = $this->convertDollarPrice($index);

            if (isset($this->get_product($index)->base_unit_multiplier)) {
                $this->base_unit[$index] = $this->get_product($index)->base_unit_multiplier;
            } else {
                $this->base_unit[$index] = 1;
            }
            $this->sub_total[$index] = (int)$this->rows[$index]['quantity'] * (float)$purchase_price * (float)$this->rows[$index]['equal'];

            return number_format($this->sub_total[$index], num_of_digital_numbers());
        }
    }

    public function dollar_sub_total($index)
    {
        if (isset($this->rows[$index]['quantity']) && (isset($this->rows[$index]['dollar_purchase_price']) || isset($this->rows[$index]['purchase_price']))) {
            // convert purchase price from Dinar To Dollar
            $purchase_price = $this->convertDinarPrice($index);
            $this->dollar_sub_total[$index] = (int)$this->rows[$index]['quantity'] * (float)$purchase_price * (isset($this->rows[$index]['equal']) ? (float)$this->rows[$index]['equal'] : 1);

            return number_format($this->dollar_sub_total[$index], num_of_digital_numbers());
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
        return (int)$this->rows[$index]['quantity'];
        //        }

    }

    public function sum_sub_total()
    {
        return number_format(array_sum($this->sub_total), num_of_digital_numbers());
    }

    public function sum_dollar_tsub_total()
    {
        return number_format(array_sum($this->dollar_sub_total), num_of_digital_numbers());
    }

    public function delete_product($index)
    {
        if (!empty($this->rows[$index]['stock_line_id'])) {
            $this->deleted_items[] = $this->rows[$index]['stock_line_id'];
        }
        if (!empty($this->rows[$index]['id'])) {
            $this->deleted_variations[] = $this->rows[$index]['id'];
        }
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
        $this->calculateRowsCount();
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
            $purchase_price = $this->num_uf($this->rows[$index]['purchase_price']) / $this->num_uf($this->exchange_rate);
        } else {
            $purchase_price = $this->num_uf($this->rows[$index]['dollar_purchase_price']);
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
                return $this->exchangeRate = str_replace(',', '', $supplier->exchange_rate);
            } else
                return $this->exchangeRate = System::getProperty('dollar_exchange');
        } else {
            return $this->exchangeRate = System::getProperty('dollar_exchange');
        }
    }

    public function changePurchasePrice($index)
    {
        $this->rows[$index]['purchase_price'] = number_format((float)$this->rows[$index]['dollar_purchase_price'] * (float)$this->exchange_rate, num_of_digital_numbers());
        $this->changeFilling($index);
    }

    public function changeDollarPurchasePrice($index)
    {
        $this->rows[$index]['dollar_purchase_price'] = number_format((float)$this->num_uf($this->rows[$index]['purchase_price']) / (float)$this->exchange_rate, num_of_digital_numbers());
        $this->changeDollarFilling($index);
    }

    public function changePercent($index, $key)
    {
        $purchase_price = $this->num_uf($this->rows[$index]['purchase_price']);
        $percent = $this->num_uf($this->rows[$index]['prices'][$key]['percent']);
        if ($this->transaction_currency != 2) {

            $this->rows[$index]['prices'][$key]['dinar_increase'] = ($purchase_price * $percent) / 100;
            $this->rows[$index]['prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format(($purchase_price / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
        } else {
            $this->rows[$index]['prices'][$key]['dollar_increase'] = ($purchase_price * $percent) / 100;
            $this->rows[$index]['prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']) * $this->num_uf($this->exchange_rate), num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format(($purchase_price * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->rows[$index]['prices'][$key]['dinar_increase']), num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($purchase_price + $this->num_uf($this->rows[$index]['prices'][$key]['dollar_increase']), num_of_digital_numbers());
        }
        $this->changeUnitPrices($index);
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
                    $this->rows[$index]['dollar_selling_price'] = number_format(($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']), num_of_digital_numbers());
                    $this->rows[$index]['selling_price'] = number_format(($this->rows[$index]['dollar_purchase_price'] + (float)$this->rows[$index]['fill_quantity']) * $this->exchange_rate, num_of_digital_numbers());
                } else {
                    $percent = ($this->num_uf($this->rows[$index]['dollar_purchase_price']) * (float)$this->rows[$index]['fill_quantity']) / 100;
                    $this->rows[$index]['dollar_selling_price'] = number_format(((float)$this->rows[$index]['dollar_purchase_price'] + $percent), num_of_digital_numbers());
                    $this->rows[$index]['selling_price'] = number_format(((float)$this->rows[$index]['dollar_purchase_price'] + $percent) * $this->exchange_rate, num_of_digital_numbers());
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
                    $this->rows[$index]['selling_price'] = number_format(($this->num_uf($this->rows[$index]['purchase_price']) + $percent), num_of_digital_numbers());
                    $this->rows[$index]['dollar_selling_price'] = number_format(((float)$this->num_uf($this->rows[$index]['purchase_price']) + $percent) / $this->exchange_rate, num_of_digital_numbers());
                }
            }
        }
    }

    public function changeSellingPrice($index)
    {
        $this->rows[$index]['selling_price'] = (float)$this->rows[$index]['dollar_selling_price'] * (float)$this->exchange_rate;
    }

    public function applyOnAllCustomers($key)
    {
        $fill_id = $this->prices[$key]['fill_id'];
        if ($this->prices[$key]['apply_on_all_customers']) {
            $row_index = $this->getKey($fill_id) ?? null;
            if ($row_index >= 0) {
                $customer_type = $this->prices[$key]['price_customer_types'];

                // Determine the amount of discount in dinars and dollars
                $amountOfDiscountInDinar = $this->prices[$key]['price_type'] == 'percentage' ?
                    ($this->num_uf($this->prices[$key]['dinar_price']) * 0.01) : ($this->num_uf($this->prices[$key]['dinar_price']));
                $amountOfDiscountInDollar = $this->prices[$key]['price_type'] == 'percentage' ?
                    ($this->num_uf($this->prices[$key]['price']) * 0.01) : ($this->num_uf($this->prices[$key]['price']));

                if (!is_null($row_index) && $row_index >= 0) {
                    $customer_type = $this->prices[$key]['price_customer_types'];
                    $price_key = $this->getCustomerType($row_index, $customer_type);

                    // Determine the amount of discount in dinars and dollars
                    $dinar_price = $this->num_uf($this->prices[$key]['dinar_price']);
                    $dollar_price = $this->num_uf($this->prices[$key]['price']);

                    $log = [];
                    if ($price_key >= 0) {
                        foreach ($this->rows[$row_index]['prices'] as $index => $price) {
                            if ($price['customer_type_id'] == $this->prices[$key]['price_customer_types']) {
                                continue;
                            }
                            $totalQty = $this->num_uf($this->prices[$key]['discount_quantity']) + $this->num_uf($this->prices[$key]['bonus_quantity']);
                            // Calculate the discount amount based on percentage
                            if ($this->prices[$key]['price_type'] == 'percentage') {
                                $percentageDinar = ($dinar_price / 100);
                                $percentageDollar = ($dollar_price / 100);
                                $amountOfDiscountInDinar = $this->num_uf($this->rows[$row_index]['prices'][$index]['dinar_sell_price']) * $percentageDinar;
                                $amountOfDiscountInDollar = $this->num_uf($this->rows[$row_index]['prices'][$index]['dollar_sell_price']) * $percentageDollar;
                            } else {
                                $amountOfDiscountInDinar = $dinar_price;
                                $amountOfDiscountInDollar = $dollar_price;
                            }

                            // Calculate the price after discount
                            $check_discount_from_original_price = ($this->prices[$key]['dinar_price_after_desc'] == $this->prices[$key]['dinar_piece_price']
                                || $this->prices[$key]['price_after_desc'] == $this->prices[$key]['piece_price']) ? 0 : 1;

                            if ($check_discount_from_original_price) {
                                $dinar_price_value = $this->num_uf($this->rows[$row_index]['prices'][$index]['dinar_sell_price']) - $amountOfDiscountInDinar;
                                $price_value = $this->num_uf($this->rows[$row_index]['prices'][$index]['dollar_sell_price']) - $amountOfDiscountInDollar;
                                $total_price_in_dinar = $dinar_price_value * $this->num_uf($this->prices[$key]['discount_quantity']);
                                $total_price_in_dollar = $price_value * $this->num_uf($this->prices[$key]['discount_quantity']);
                                $piecePriceInDollar = $total_price_in_dollar / ($totalQty <= 0 ? 1 : $totalQty);
                                $piecePriceInDinar = $total_price_in_dinar / ($totalQty <= 0 ? 1 : $totalQty);
                                $discount_from_original_price = 1;
                            } else {
                                //we buy 15 piece with price for 10 piece so user will pay 1500 for 15 piece  1st discount
                                //1500 / 15 = 100 "price before apply 2nd discount"
                                // we have 10% percent discount also on piece
                                // 100 - (100 * 10%) = 90
                                //final total = 15 * 90 = 1350
                                //----------------------------------------
                                //150 * 10 / 15 = 100
                                $price_1st = $this->num_uf($this->rows[$row_index]['prices'][$index]['dollar_sell_price']) * $this->num_uf($this->prices[$key]['discount_quantity']) / $totalQty;
                                $dinar_price_1st = $this->num_uf($this->rows[$row_index]['prices'][$index]['dinar_sell_price']) * $this->num_uf($this->prices[$key]['discount_quantity']) / $totalQty;
                                //100 - 10 = 90
                                $price_value = $this->prices[$key]['price_type'] == 'percentage' && $percentageDollar ? $price_1st - ($price_1st * $percentageDollar) : $price_1st - $amountOfDiscountInDollar;
                                $dinar_price_value = $this->prices[$key]['price_type'] == 'percentage' && $percentageDinar ? $dinar_price_1st - ($dinar_price_1st * $percentageDinar) : $dinar_price_1st - $amountOfDiscountInDinar;
                                //90 * 15 = 1350
                                $total_price_in_dinar = $dinar_price_value * $totalQty;
                                $total_price_in_dollar = $price_value * $totalQty;
                                $piecePriceInDollar = $price_value;
                                $piecePriceInDinar = $dinar_price_value;
                                $discount_from_original_price = 0;
                            }

                            $new_price = [
                                'fill_id' => $this->prices[$key]['fill_id'],
                                'price_type' => $this->prices[$key]['price_type'],
                                'price_category' => $this->prices[$key]['price_category'],
                                'price_currency' => $this->prices[$key]['price_currency'],
                                'price' => $this->prices[$key]['price'],
                                'dinar_price' => $this->prices[$key]['dinar_price'],
                                'discount_quantity' => $this->prices[$key]['discount_quantity'],
                                'bonus_quantity' => $this->prices[$key]['bonus_quantity'],
                                'price_customer_types' => $this->rows[$row_index]['prices'][$index]['customer_type_id'],
                                'price_after_desc' => number_format($price_value, num_of_digital_numbers()),
                                'dinar_price_after_desc' => number_format($dinar_price_value, num_of_digital_numbers()),
                                'total_price' => number_format($total_price_in_dollar, num_of_digital_numbers()),
                                'dinar_total_price' => number_format($total_price_in_dinar, num_of_digital_numbers()),
                                'piece_price' => number_format($piecePriceInDollar, num_of_digital_numbers()),
                                'dinar_piece_price' => number_format($piecePriceInDinar, num_of_digital_numbers()),
                                'apply_on_all_customers' => 0,
                                'parent_price' => 1,
                                'discount_from_original_price' => $discount_from_original_price,
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

    public function delete_price_raw($key)
    {
//        if ($this->prices[$key]['apply_on_all_customers']) {
        foreach ($this->prices as $i => $price) {
            if ($i == $key) {
                if ($this->prices[$key]['fill_id'] == $price['fill_id']) {
                    $this->deteted_prices[] = isset($this->prices[$key]['id']) ? $this->prices[$key]['id'] : $this->prices[$key];
                    if (is_array($this->prices[$key])){
                        unset($this->prices[$key]);
                    }
                }
            }
        }
//        }
//        $this->deteted_prices[] = $this->prices[$key]['id'];
//        unset($this->prices[$key]);
    }

    public function delete_store_raw($key)
    {
        if (!empty($this->fill_stores[$key]['stock_id'])) {
            $this->deleted_stocks[] = $this->fill_stores[$key]['stock_id'];
        }
        unset($this->fill_stores[$key]);

        // Reindex the array
        $this->fill_stores = array_values($this->fill_stores);

        $this->calculateFillStoreCount();
    }

    public function delete_store_data_raw($index, $key)
    {
        if (!empty($this->fill_stores[$index]['data'][$key]['stock_line_id'])) {
            $this->deleted_fill_stocks[] = $this->fill_stores[$index]['data'][$key]['stock_line_id'];
        }
        // unset($this->fill_stores[$index]['data'][$key]);

        // Remove the element at the specified index
        array_splice($this->fill_stores[$index]['data'], $key, 1);

        // Reindex the array
        $this->fill_stores[$index]['data'] = array_values($this->fill_stores[$index]['data']);
    }

    public function changePrice($index, $via = 'price')
    {
        $fill_id = $this->prices[$index]['fill_id'];
        $row_index = $this->getKey($fill_id) ?? null;
        $actual_price = 0;
        if ($row_index >= 0) {
            $customer_type = $this->prices[$index]['price_customer_types'];
            $price_key = $this->getCustomerType($row_index, $customer_type);
            $sell_price = ($row_index >= 0) && isset($price_key) ? $this->num_uf($this->rows[$row_index]['prices'][$price_key]['dinar_sell_price']) : null;
            $dollar_sell_price = ($row_index >= 0) && isset($price_key) ? $this->num_uf($this->rows[$row_index]['prices'][$price_key]['dollar_sell_price']) : null;
            $total_quantity = $this->num_uf($this->prices[$index]['discount_quantity']) + $this->num_uf($this->prices[$index]['bonus_quantity']);
            if (!$this->prices[$index]['discount_from_original_price'] && !empty($this->prices[$index]['discount_quantity'])) {
                if ($this->prices[$index]['price_type'] == "fixed") {
                    if ($this->transaction_currency == 2) {
                        if (!empty($this->prices[$index]['dinar_price'])) {
                            if ($via == 'quantity' && !empty($this->prices[$index]['dinar_price']) && !empty($this->prices[$index]['price'])) {
                                $actual_price = $this->prices[$index]['price'];
                            } else {
                                $actual_price = $this->num_uf($this->prices[$index]['dinar_price']);
                                $this->prices[$index]['dinar_price'] = number_format($this->num_uf($this->prices[$index]['dinar_price']));
                            }
                        }
                        $dollar_price = number_format($this->num_uf($actual_price) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    } else {
                        $dollar_price = number_format($this->num_uf($this->prices[$index]['dinar_price']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    }
                    $sell_price = ($sell_price * $this->prices[$index]['discount_quantity']) / ($total_quantity == 0 ? 1 : $total_quantity);
                    $dollar_sell_price = ($dollar_sell_price * $this->prices[$index]['discount_quantity']) / ($total_quantity == 0 ? 1 : $total_quantity);
                    $this->prices[$index]['price'] = $this->num_uf($dollar_price);
                    $this->prices[$index]['dinar_price_after_desc'] = number_format($this->num_uf($sell_price) - $this->num_uf($this->prices[$index]['dinar_price']), num_of_digital_numbers());
                    $this->prices[$index]['price_after_desc'] = number_format($this->num_uf($dollar_sell_price) - $this->num_uf($this->prices[$index]['price']), num_of_digital_numbers());
                } elseif ($this->prices[$index]['price_type'] === 'percentage') {
                    //                    $percent = $this->num_uf($this->prices[$index]['dinar_price'])  / 100;
                    //                    $this->prices[$index]['dinar_price_after_desc'] = number_format(($this->num_uf($sell_price) - ($percent * $this->num_uf($sell_price))), num_of_digital_numbers());
                    //                    $this->prices[$index]['price_after_desc'] = number_format(($this->num_uf($dollar_sell_price) - ($percent * $this->num_uf($dollar_sell_price))), num_of_digital_numbers());
                    //                    dd($this->prices[$index]['dinar_price_after_desc']);
                    $this->prices[$index]['dinar_price_after_desc'] = $this->prices[$index]['dinar_price_after_desc'];
                    $this->prices[$index]['price_after_desc'] = $this->prices[$index]['price_after_desc'];
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
                                $this->prices[$index]['dinar_price'] = number_format($this->num_uf($this->prices[$index]['dinar_price']));
                            }
                        }
                        $dollar_price = number_format($this->num_uf($actual_price) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    } else {
                        $dollar_price = number_format($this->num_uf($this->prices[$index]['dinar_price']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
                    }
                    $this->prices[$index]['price'] = $this->num_uf($dollar_price);
                    $this->prices[$index]['dinar_price_after_desc'] = number_format($this->num_uf($sell_price) - $this->num_uf($this->prices[$index]['dinar_price']), num_of_digital_numbers());
                    $this->prices[$index]['price_after_desc'] = number_format($this->num_uf($dollar_sell_price) - $this->num_uf($this->prices[$index]['price']), num_of_digital_numbers());
                } else {
                    //                    $percent = $this->num_uf($this->prices[$index]['dinar_price'])  / 100;
                    //                    $this->prices[$index]['dinar_price_after_desc'] = number_format(($this->num_uf($sell_price) - ($percent * $this->num_uf($sell_price))), num_of_digital_numbers());
                    //                    $this->prices[$index]['price_after_desc'] = number_format(($this->num_uf($dollar_sell_price) - ($percent * $this->num_uf($dollar_sell_price))), num_of_digital_numbers());
                    $this->prices[$index]['dinar_price_after_desc'] = $this->prices[$index]['dinar_price_after_desc'];
                    $this->prices[$index]['price_after_desc'] = $this->prices[$index]['price_after_desc'];
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
                $this->prices[$index]['dinar_piece_price'] = $total_quantity > 0 ? number_format($this->num_uf($this->prices[$index]['dinar_total_price']) / $total_quantity, num_of_digital_numbers()) : 0;
                $this->prices[$index]['piece_price'] = number_format($this->num_uf($this->prices[$index]['total_price']) / ($total_quantity == 0 ? 1 : $total_quantity), num_of_digital_numbers());
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

        foreach ($this->rows[$index]['prices'] as $key => $row) {
            if ($this->rows[$index]['prices'][$key]['customer_type_id'] == $customer_type) {
                return $key;
            }
        }
    }

    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator = ',';
        $decimal_separator = '.';
        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);
        return (float)$num;
    }

    public function changeSellPrice($index, $key)
    {
        $purchase_price = $this->num_uf($this->rows[$index]['purchase_price']);
        if ($this->rows[$index]['prices'][$key]['percent'] == null || $this->rows[$index]['prices'][$key]['percent'] == 0) {
            $this->rows[$index]['prices'][$key]['percent'] = (($this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) - $purchase_price) * 100) / $purchase_price;
        }
        if ($this->transaction_currency == 2) {
            $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($this->rows[$index]['prices'][$key]['dinar_sell_price'], num_of_digital_numbers());
            $this->rows[$index]['prices'][$key]['dinar_sell_price'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) * $this->num_uf($this->exchange_rate), num_of_digital_numbers());
        } else {
            $this->rows[$index]['prices'][$key]['dollar_sell_price'] = number_format($this->num_uf($this->rows[$index]['prices'][$key]['dinar_sell_price']) / $this->num_uf($this->exchange_rate), num_of_digital_numbers());
        }
        $this->changeUnitPrices($index);
        // $this->changePercent($index, $key);
    }
}
