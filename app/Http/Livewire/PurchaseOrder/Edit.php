<?php

namespace App\Http\Livewire\PurchaseOrder;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Store;
use App\Models\System;
use App\Models\JobType;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\SellLine;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\MoneySafe;
use App\Models\Variation;
use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CustomerType;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use Livewire\WithPagination;
use App\Models\StockTransaction;
use App\Models\PurchaseOrderLine;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionSellLine;
use Illuminate\Contracts\View\View;
use App\Models\MoneySafeTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Models\CashRegisterTransaction;
use App\Models\StockTransactionPayment;
use App\Models\PurchaseOrderTransaction;
use App\Models\PaymentTransactionSellLine;
use Illuminate\Contracts\Foundation\Application;

class Edit extends Component
{
    use WithPagination;

    public $divide_costs , $other_expenses = 0, $other_payments = 0 , $block_for_days , $tax_method , $validity_days , $store_id,$block_qty , $suppliers,$supplier_id ,$stores, $status, $order_date, $purchase_type,
    $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier,$supplier_id2, $po_no ,$exchange_rate, $amount, $method,
    $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false,
    $transaction_currency, $current_stock, $clear_all_input_stock_form, $searchProduct, $items = [], $department_id,
    $files, $upload_documents , $details , $dollar_total_cost ,$total_subtotal , $productUtil , $discount_type , $discount_value , $total_cost , $dollar_total_cost_var=[] , $total_cost_var=[] ,
    $allproducts = [] ,$dollar_final_total, $discount = 0.00, $variations , $brand_id = 1, $brands = [] , $total , $search_by_product_symbol , $product_id , $purchase_transaction_id ,
    $data = [], $payments = [], $invoice_lang, $store_pos_id,
    $anotherPayment = false, $sale_note, $payment_note, $staff_note, $payment_types,
    $total_dollar, $add_customer = [], $customers = [], $discount_dollar, $store_pos, $deliveryman_id = null, $delivery_cost,
    // "الباقي دولار" , "الباقي دينار"
    $dollar_remaining = 0, $dinar_remaining = 0,$purchase_transaction,$reprsenative_sell_car = false,
    $final_total, $dollar_amount = 0, $redirectToHome = false,
    $draft_transactions, $show_modal = false, $highest_price, $lowest_price, $from_a_to_z, $from_z_to_a, $nearest_expiry_filter, $longest_expiry_filter, $dollar_highest_price, $dollar_lowest_price;

    protected $rules = [
//         'store_id' => 'required',
//         'supplier' => 'required',
// //    'status' => 'required',
//         // 'paying_currency' => 'required',
//         'purchase_type' => 'required',
//         'payment_status' => 'required',
//         'method' => 'required',
//         // 'amount' => 'required',
//         'transaction_currency' => 'required',
//         'items.*.variation_id' => 'required',
//         'source_type' => 'required',
//         'source_id' => 'required'
    ];

    // Get "suppliers" and "stores" and "product number"
    public function mount($id)
    {
        $recent_purchase_transaction = PurchaseOrderTransaction::with('transaction_purchase_order_lines')->find($id);
        $this->purchase_transaction = $recent_purchase_transaction;
        // dd($recent_purchase_transaction);
        $this->purchase_transaction_id = $id;
        $this->po_no = $recent_purchase_transaction->po_no;
        $this->store_id = $recent_purchase_transaction->store_id ?? '';
        $this->supplier = $recent_purchase_transaction->supplier_id ?? '';
        $this->brands = Brand::orderby('created_at', 'desc')->pluck('name', 'id');
        // عرض المنتجات اسفل الفلاتر
        if (!empty($this->store_id))
        {
            $products_store = ProductStore::where('store_id', $this->store_id)->pluck('product_id');
            $this->allproducts = Product::whereIn('id', $products_store)->get();
        } else {
            $this->allproducts = Product::get();
        }
        $this->department_id = null;
        // dd($recent_purchase_transaction);
        foreach ($recent_purchase_transaction->transaction_purchase_order_lines as  $line){
            $this->addLineProduct($line);
        }
    }
    protected $listeners = ['listenerReferenceHere'];
    // +++++++++++++++++++ listenerReferenceHere +++++++++++++++++++
    public function listenerReferenceHere($data)
    {
        if(isset($data['var1'])) {
            $this->{$data['var1']} = $data['var2'];
        }
        // +++++++++++++ 26-11-2023 المشكلة هنا +++++++++++++
        if($data['var1'] == 'supplier_id'){
            $this->exchange_rate = $this->changeExchangeRate();
        }
    }
    // +++++++++++++++++++ render +++++++++++++++++++++++
    public function render(): Factory|View|Application
    {
        // $status_array = $this->getPurchaseOrderStatusArray();
        $this->stores = Store::getDropdown();
        $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();

        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $product_id = request()->get('product_id');
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        $departments = Category::get();
        $customer_types = CustomerType::latest()->get();
        $search_result = '';
        if(!empty($this->searchProduct)){
            $search_result = Product::when($this->searchProduct,function ($query){
                return $query->where('name','like','%'.$this->searchProduct.'%')
                    ->orWhere('sku','like','%'.$this->searchProduct.'%');
            });
            $search_result = $search_result->paginate();
            if(count($search_result) == 0){
                $variation = Variation::when($this->searchProduct,function ($query){
                    return $query->where('sku','like','%'.$this->searchProduct.'%');
                })->pluck('product_id');
                $search_result = Product::whereIn('id',$variation);
                $search_result = $search_result->paginate();
            }

            if(count($search_result) === 1){
                $this->add_product($search_result->first()->id);
                $search_result = '';
                $this->searchProduct = '';
            }
        }
        if ($this->source_type == 'pos') {
            $users = StorePos::pluck('name', 'id');
        } elseif ($this->source_type == 'store') {
            $users = Store::pluck('name', 'id');
        } elseif ($this->source_type == 'safe') {
            $users = MoneySafe::pluck('name', 'id');
        } else {
            $users = User::Notview()->pluck('name', 'id');
        }
        if(!empty($this->department_id)){
            $products = Product::where('category_id' , $this->department_id)->get();
        }
        else{
            $products = Product::paginate();
        }
        // Get "exchange_rate" value
        $this->changeExchangeRate();

        $this->dispatchBrowserEvent('initialize-select2');
        return view('livewire.purchase-order.edit',
            compact(
                // 'stores',
                // 'suppliers',
                // 'status_array',
                'payment_status_array',
                'payment_type_array',
                'product_id',
                // 'payment_types',
                // 'payment_status_array',
                'selected_currencies',
                'preparers' ,
                'products',
                'customer_types',
                'departments',
                'search_result',
                'users'));
    }
    // +++++++++++++++++++ addLineProduct : اللي عايز اعدله purchase_order_transaction بتاعت ال purchase_lines بتجيب ال  +++++++++++++++++++++++
    public function addLineProduct($line)
    {
        // dd($line);
        $product = Product::with('stock_lines')->where('id', $line->product_id)->first();
        if( isset($product) )
        {
            $quantity_available = $this->quantityAvailable($product);
            // dd($quantity_available);
            $current_stock = $this->getCurrentStock($product);
            $product_stores = $this->getProductStores($product);
        }
        $exchange_rate =  !empty($current_stock->exchange_rate) ? $current_stock->exchange_rate : System::getProperty('dollar_exchange');


        $price = !empty($current_stock->sell_price) ? number_format($current_stock->sell_price,2) : 0;
        $dollar_price = !empty($current_stock->dollar_sell_price) ? number_format($current_stock->dollar_sell_price,2) : 0;
        $this->items[] = [
            'purchase_order_line' => $line->id,
            'product' => $product,
            'quantity' => number_format($line->quantity,3),
            'extra_quantity' => $line->extra_quantity,
            'price' => !empty($line->sell_price) ? $this->num_uf(number_format($line->sell_price,3)) : 0,
            // 'category_id' => $product->category?->id,
            'category_id' => isset($product->category) ? $product->category->id : null,
            // 'department_name' => $product->category?->name,
            'department_name' => isset($product->category) ? $product->category->name : null,
            // 'client_id' => $product->customer?->id,
            'client_id' => isset($product->customer) ? $product->category->id : null,
            'exchange_rate' => $line->exchange_rate,
            'quantity_available' => isset($quantity_available) ? $quantity_available : null,
            'sub_total' => $line->sub_total,
            'dollar_sub_total' => !empty($product->unit) ? $product->unit->base_unit_multiplier * $line->quantity  * $line->dollar_sell_price : $line->quantity * $this->num_uf($dollar_price),
            'current_stock' => isset($current_stock) ? $current_stock : null,
            'dollar_purchasing_price' => isset($line->purchase_price_dollar) ? $line->purchase_price_dollar : 0 ,
            // get "purchasing_price" from "add_stock_line" table
            'purchasing_price' => isset($line->purchase_price) ? $line->purchase_price : 0 ,
            // 'discount_categories' =>  $current_stock->prices()->get(),
            'discount' => $line->product_discount_category,
            'discount_price' => number_format($line->product_discount_amount,3),
            'discount_type' =>  $line->product_discount_type,
            'discount_category' =>  null,
            'dollar_price' => !empty($line->dollar_sell_price) ? number_format($line->dollar_sell_price,2) : 0  ,
            'unit_name' =>!empty($product->unit) ? $product->unit->name : '',
            'base_unit_multiplier' =>!empty($product->unit) ? $product->unit->base_unit_multiplier : 1,
            'total_quantity' => !empty($product->unit) ?  number_format($line->quantity,3) * $product->unit->base_unit_multiplier : number_format($line->quantity,3),
            'stores' => isset($product_stores) ? $product_stores : null,
            'sell_line_id' => $line->id,
        ];

        // $this->computeForAll();
    }
    // +++++++++++++++++++ quantityAvailable +++++++++++++++++++++++
    // public function quantityAvailable($product)
    // {
    //     $quantity_available = ProductStore::where('product_id', $product->id)->where('store_id', $this->store_id)
    //         ->first()->quantity_available ?? 0;
    //     return $quantity_available;
    // }
    public function quantityAvailable($product)
    {
        if(isset($product->id))
        {
            // Query the database to get the quantity_available for the specified product and store
            $productStore = ProductStore::where('product_id', $product->id)
                ->where('store_id', $this->store_id)
                ->first();
                // Check if a record was found
            if ($productStore) {
                // Access the quantity_available attribute
                return $productStore->quantity_available ?? 0;
            }

            // No record found, return a default value (in this case, 0)
            return 0;
        }

    }

    // +++++++++++++++++++ getCurrentStock : بيجيب قيمة "المخزون الحالي" في جدول المنتجات +++++++++++++++++++++++
    public function getCurrentStock($product)
    {
        if(isset( $product->stock_lines))
        {
            $product_stocklines = $product->stock_lines;
            // dd($product_stocklines);
            $quantity_available = 0;
            foreach ($product_stocklines as $stockline)
            {
                $quantity_available +=  $stockline->quantity - $stockline->quantity_sold  + $stockline->quantity_returned;
                // dd($quantity_available);
            }
            if ($quantity_available > 0)
            {
                // dd($stockline);
                // return $stockline;
                return $quantity_available;
            }
            return null;
        }
    }
    // ++++++++++++++++++++++++++++++++++ getProductStores() ++++++++++++++++++++++++++++++++++
    public function getProductStores($product)
    {
        // dd($product);
        // if(isset($product->id))
        // {
            $stores = ProductStore::where('product_id', $product->id)->get();
            return $stores;
        // }
    }
    // ++++++++++++++++++++++++++++++++++ changeDollarTotal() method ++++++++++++++++++++++++++++++++++
    // calculate dollar_final_total : "النهائي دولار"
    public function changeDollarTotal()
    {
        //  "النهائي دولار"
        $this->dollar_final_total = $this->total_dollar - $this->discount_dollar;
        // Task : dollar_remaining : الباقي دولار
        $this->dollar_remaining = ($this->dollar_amount - $this->dollar_final_total);
    }
    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
    }
    // ++++++++++++++++++++++++++++ submit() ++++++++++++++++++++++++++++
    public function store() : Redirector|Application|RedirectResponse
    {
        // $this->validate();
        try
        {
            // +++++++++++++++++++ purchaseOrderTransaction table +++++++++++++++++++
            $purchaseOrderTransaction_data =
            [
                // store_id
                'store_id' => $this->store_id,
                // supplier_id
                'supplier_id' => $this->supplier_id,
                // po_no
                'po_no' => $this->po_no,
                // details
                'details' => $this->details,
                // transaction_date
                'transaction_date' => !empty($this->transaction_date) ? $this->transaction_date : Carbon::now(),
                // created_by
                'created_by' => auth()->user()->id,
                // updated_by
                'updated_by' => auth()->user()->id,
                // deleted_by
                'deleted_by' => null,
                // grand_total
                'grand_total' => $this->num_uf($this->sum_total_cost()),
                // final_total
                'final_total' => isset($this->discount_amount) ? ($this->num_uf($this->sum_total_cost()) - $this->discount_amount) : $this->num_uf($this->sum_total_cost()),
                // created_at
                'created_at' => null,
                // updated_at
                'updated_at' => Carbon::now(),
                // transaction_date
                'transaction_date' => Carbon::now(),
                // order_date
                'order_date' => Carbon::now()
            ];
            DB::beginTransaction();
            $purchaseOrderTransaction = $this->purchase_transaction;
            // Save the purchase order transaction to the database
            $purchaseOrderTransaction->update($purchaseOrderTransaction_data);
            // +++++++++++++++++++ purchase_order table +++++++++++++++++++
            foreach ($this->items as $index => $item)
            {
                // dd( $item );
                $purchase_order_line_var = PurchaseOrderLine::where('purchase_order_transaction_id',$purchaseOrderTransaction->id)->pluck('id');
                $purchase_order_line = PurchaseOrderLine::find($purchase_order_line_var);
                $purchase_order_data =
                [
                    'product_id' => $item['product']['id'],
                    'purchase_order_transaction_id' => $purchaseOrderTransaction->id,
                    'quantity' => $item['quantity'],
                    'current_stock' => $item['current_stock'],
                    'purchase_price' => $item['purchasing_price'],
                    'purchase_price_dollar' => $item['dollar_purchasing_price'],
                    // sub_total
                    'sub_total' => !empty($item['sub_total']) ? $this->num_uf($item['sub_total']) : 0 ,
                    // created_by
                    'created_by' => Auth::user()->id ,
                    // updated_by
                    'updated_by' =>  Auth::user()->id ,
                    // deleted_by
                    'deleted_by' => null ,
                    // created_at
                    'created_at' => null ,
                    // updated_at
                    'updated_at' => now() ,
                    // deleted_at
                    'deleted_at' => null
                ];

                if(!empty($item['purchase_order_line']))
                {
                    $purchase_order_line = PurchaseOrderLine::find($item['purchase_order_line']);
                    $purchase_order_line->update($purchase_order_data);
                }
                else
                {
                    $purchase_order_line = PurchaseOrderLine::create($purchase_order_data);
                }
            }
            DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'lang.success']);
        }
        catch (\Exception $e)
        {
            dd($e);
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs']);
        }
        return redirect()->route('purchase_order.index');
    }

    // ++++++++++++++++++++++++++++++++++ add_product() method ++++++++++++++++++++++++++++++++++
    public function add_product($id, $add_via = null)
    {
        $this->product_id = $id;
        if(!empty($this->searchProduct)){
            $this->searchProduct = '';

        }

        $product = Product::find($id);
        $variations = $product->variations;

        if($add_via == 'unit'){
            $show_product_data = false;
            $this->addNewProduct($variations,$product,$show_product_data);
        }
        else{
            if(!empty($this->items)){
                $newArr = array_filter($this->items, function ($item) use ($product) {
                    return $item['product']['id'] == $product->id;
                });
                if (count($newArr) > 0) {
                    $key = array_keys($newArr)[0];
                    ++$this->items[$key]['quantity'];
                       $this->items[$key]['sub_total'] = ( $this->items[$key]['price'] * $this->items[$key]['quantity'] ) -( $this->items[$key]['quantity'] * $this->items[$key]['discount']);
                }
                else{
                    $show_product_data = true;
                    $this->addNewProduct($variations,$product,$show_product_data);
                }
            }
            else{
                $show_product_data = true;
                $this->addNewProduct($variations,$product,$show_product_data);
            }
        }

    }
    // +++++++++++++++++++++++ addNewProduct() +++++++++++++++++++++++
    public function addNewProduct($variations,$product,$show_product_data)
    {
        // Task_30_10_2023 : dollar_purchase_price
        $dollar_purchase = AddStockLine::select('dollar_purchase_price')->where('product_id', $product['id'])->latest()->first();
        // Task_30_10_2023 : dinar_purchase_price
        $dinar_purchase = AddStockLine::select('purchase_price')->where('product_id', $product['id'])->latest()->first();
        // Task_9_10_2023 : quantity
        $quantity = AddStockLine::where('product_id', $product['id'])->sum('quantity');
        $this->product_id = $product['id'];
        // The "Total quantity" of "each product"
        // $current_stock = AddStockLine::where('product_id', $product['id'])->sum('quantity');
        // $current_stock = ProductStore::where('product_id', $product['id'])->pluck('quantity_available');
        $current_stock_all = ProductStore::select('quantity_available')
                            ->where('product_id', $product['id'])
                            ->orderBy('created_at', 'desc')
                            ->first();
        $current_stock = $current_stock_all->quantity_available;
        // dd($current_stock);
        $new_item = [
            'show_product_data' => $show_product_data,
            'variations' => $variations,
            'product' => $product,
            // default "quantity" value
            'quantity' => 1 ,
            // default "current_stock" value : get sum of all "quantity" of "product" from "add_stock_line" table
            'current_stock' => isset($current_stock) ? $current_stock : 0 ,
            'unit' => null,
            'base_unit_multiplier' => null,
            'sub_total' => 0,
            'dollar_sub_total' => 0,
            'size' => !empty($product->size) ? $product->size : 0,
            'total_size' => !empty($product->size) ? $product->size * 1 : 0,
            'weight' => !empty($product->weight) ? $product->weight : 0,
            'total_weight' => !empty($product->weight) ? $product->weight * 1 : 0,
            'dollar_cost' => 0,
            // get "dollar_purchasing_price" from "add_stock_line" table
            'dollar_purchasing_price' => isset($dollar_purchase->dollar_purchase_price) ? $dollar_purchase->dollar_purchase_price : 0 ,
            // get "purchasing_price" from "add_stock_line" table
            'purchasing_price' => isset($dinar_purchase->purchase_price) ? $dinar_purchase->purchase_price : 0 ,
            'cost' => 0,
            'dollar_total_cost' => 0,
            'total_cost' => 0,
            // 'current_stock' =>0,
            'total_stock' => 0 + 1,
        ];
        array_push($this->items, $new_item);
    }
    // +++++++++++++++++++++++++ updateCurrentStock() +++++++++++++++++++
    //  When change "store" Then Change "current_stock" column according to "selected Store"
    public function updateCurrentStock()
    {
        if (!empty($this->store_id))
        {
            $store_id = (int)$this->store_id;
            foreach( $this->items as $key => $item )
            {
                $current_stock_all = ProductStore::select('quantity_available')
                    ->where('product_id', $item['product']['id'])
                    ->where('store_id', $store_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                $current_stock = isset($current_stock_all->quantity_available) ? $current_stock_all->quantity_available : null;
                $this->items[$key]['current_stock'] = $current_stock;

            }
        } else {
            // Handle the case where store_id is empty, set $current_stock to null or a default value
            $this->current_stock = null;
        }
    }
    public function func()
    {
        // Update $current_stock when store_id changes
        $this->updateCurrentStock();
    }

    public function getVariationData($index){
       $variant = Variation::find($this->items[$index]['variation_id']);
       $this->items[$index]['unit'] = $variant->unit->name;
       $this->items[$index]['base_unit_multiplier'] = $variant->equal;
    }

    public function changeFilling($index){
        if(!empty($this->items[$index]['purchase_price'])){
            if($this->items[$index]['fill_type']=='fixed'){
                $this->items[$index]['purchasing_price']=($this->items[$index]['dollar_purchase_price']+(float)$this->items[$index]['fill_quantity']);
            }else{
                $percent=((float)$this->items[$index]['dollar_purchase_price'] * (float)$this->items[$index]['fill_quantity']) / 100;
                $this->items[$index]['purchasing_price']=($this->items[$index]['dollar_purchase_price']+$percent);
            }
        }
        if(!empty($this->items[$index]['dollar_purchase_price'])){
            if($this->items[$index]['fill_type']=='fixed'){
                // dd( $this->items[$index]['dollar_purchasing_price']);
                $this->items[$index]['dollar_purchasing_price']=($this->items[$index]['dollar_purchase_price']+(float)$this->items[$index]['fill_quantity']);
            }
        else{
                $percent = ((float)$this->items[$index]['dollar_purchase_price'] * (float)$this->items[$index]['fill_quantity']) / 100;
                $this->items[$index]['dollar_purchasing_price'] = ($this->items[$index]['dollar_purchase_price'] + $percent);
            }

        }
    }
    public function get_product($index){
        return Variation::where('id' ,$this->selectedProductData[$index]->id)->first();
    }


    public function total_size($index){
        $this->items[$index]['total_size'] =  (int)$this->items[$index]['quantity'] * (float)$this->items[$index]['size'];
        return  $this->items[$index]['total_size'];
    }

    public function total_weight($index){
        $this->items[$index]['total_weight'] = (int)$this->items[$index]['quantity'] * (float)$this->items[$index]['weight'] ;
       return $this->items[$index]['total_weight'];
    }

    public function sum_size(){
        $totalSize = 0;

        foreach ($this->items as $item) {
            $totalSize += $item['total_size'];
        }
        return $totalSize;
    }

    public function sum_weight()
    {
        $totalWeight = 0;

        foreach ($this->items as $item) {
            $totalWeight += $item['total_weight'];
        }
        return $totalWeight;
    }
    // ++++++++++++++++++++++++++ Task :  $ اجمالي التكاليف ++++++++++++++++++++++++++
    public function dollar_total_cost($index)
    {
        $this->items[$index]['dollar_total_cost'] = (float)($this->items[$index]['dollar_purchasing_price'] * $this->items[$index]['quantity']);
        // $this->items[$index]['dollar_total_cost'] = $this->items[$index]['dollar_purchasing_price'] * $this->items[$index]['quantity'];
        $this->items[$index]['dollar_total_cost_var'] = (float)($this->items[$index]['dollar_total_cost']);
        return number_format($this->items[$index]['dollar_total_cost'], 2);
    }
    // ++++++++++++++++++++++++++ Task : اجمالي التكاليف بالدينار ++++++++++++++++++++++++++
    public function total_cost($index)
    {
        $this->items[$index]['total_cost'] = (float)($this->items[$index]['purchasing_price'] * $this->items[$index]['quantity']);
        $this->items[$index]['total_cost_var'] = (float)($this->items[$index]['total_cost']) ;
        return number_format($this->items[$index]['total_cost'],2) ;
    }
    // ++++++++++++++++++++++++++ Task : convert_dinar_price() : سعر البيع بالدينار ++++++++++++++++++++++++++
    public function convert_dinar_price($index)
    {
        if (!empty($this->items[$index]['dollar_purchasing_price']) )
        {
            $this->items[$index]['purchasing_price'] = (float)($this->items[$index]['dollar_purchasing_price'] * $this->exchange_rate);
        }
        else
        {
            $this->items[$index]['purchasing_price'] = (float)($this->items[$index]['dollar_purchasing_price']);
        }
        // return $purchasing_price;
    }
    // ++++++++++++++++++++++++++ Task : convert_dollar_price() : سعر البيع بالدولار ++++++++++++++++++++++++++
    public function convert_dollar_price($index)
    {
        // dd($this->exchange_rate);
        if (!empty($this->items[$index]['purchasing_price']) )
        {
            $this->items[$index]['dollar_purchasing_price'] = (float)($this->items[$index]['purchasing_price'] / $this->exchange_rate);
        }
        else
        {
            $this->items[$index]['dollar_purchasing_price'] = (float)($this->items[$index]['purchasing_price']);
        }
        // return $purchasing_price;
    }

    // +++++++++++++++ sum_total_cost() : sum all "dinar_sell_price" values ++++++++++++++++
    public function sum_total_cost()
    {
        $totalCost = 0;
        if(!empty($this->items))
        {
            foreach ($this->items as $item)
            {
                $totalCost += (float)$item['total_cost'];
            }
        }
        return number_format($this->num_uf($totalCost),2);
    }
    // +++++++++++++++ sum_dollar_total_cost() : sum all "dollar_sell_price" values ++++++++++++++++
    public function sum_dollar_total_cost()
    {
        $totalDollarCost = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item)
            {
                $totalDollarCost += $item['dollar_total_cost'];
            }
        }
        return number_format($totalDollarCost,2);
    }
    // +++++++++++++++++++++++ sub_total() +++++++++++++++++++++++
    public function sub_total($index)
    {
        $this->changeFilling($index);
        if(isset($this->items[$index]['quantity']) && (isset($this->items[$index]['purchase_price']) ||isset($this->items[$index]['dollar_purchase_price']) )){
            // convert purchase price from Dollar To Dinar
            $purchase_price = $this->convertDollarPrice($index);

            $this->items[$index]['sub_total'] = (int)$this->items[$index]['quantity'] * (float)$purchase_price ;

            return number_format($this->items[$index]['sub_total'], 3);
        }
        else{
            $this->items[$index]['purchase_price'] = null;
        }

    }

    public function sum_sub_total(){
        $totalSubTotal = 0;

        foreach ($this->items as $item) {
            $totalSubTotal += $item['sub_total'];
        }
        return number_format($totalSubTotal,2);
    }
    // +++++++++ Task : "مجموع اجمالي التكاليف " بالدولار +++++++++
    public function sum_dollar_sub_total()
    {
        $totalDollarSubTotal = 0;

        foreach ($this->items as $item)
        {
            $totalDollarSubTotal += $item['dollar_total_cost'];
        }
        return number_format($totalDollarSubTotal,2);
    }
    // +++++++++ Task : "مجموع اجمالي التكاليف " بالدينار +++++++++
    public function sum_dinar_sub_total()
    {
        $totalDinarSubTotal = 0;

        foreach ($this->items as $item)
        {
            $totalDinarSubTotal += $item['total_cost'];
        }
        return number_format($totalDinarSubTotal,2);
    }

    public function changeCurrentStock($index)
    {
        $this->items[$index]['total_stock'] = $this->items[$index]['quantity'] + $this->items[$index]['current_stock'];
    }
    // +++++++++++++++++ total_quantity() +++++++++++++++++
    public function total_quantity(){
        $totalQuantity = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item){
                $totalQuantity += (int)$item['quantity'];
            }
        }
       return $totalQuantity;
    }
    // +++++++++++++++++ final_total() : get the final total cost in dollars +++++++++++++++++
    public function final_total()
    {
        if(isset($this->discount_amount)){
            return $this->sum_total_cost() - $this->discount_amount;
        }
        else
            return $this->sum_total_cost();
    }
    // +++++++++++ dollar_final_total() : get the final total cost in dollars +++++++++++++++++
    public function dollar_final_total()
    {
        if(isset($this->discount_value))
        {
            return $this->sum_dollar_total_cost() - $this->discount_value;
        }
        else
            return $this->sum_dollar_total_cost();
    }

    public function delete_product($index){
        unset($this->items[$index]);
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

    public function getCurrentCashRegisterOrCreate($user_id)
    {
        $register =  CashRegister::where('user_id', $user_id)
            ->where('status', 'open')
            ->first();

        if (empty($register)) {
            $store_pos = StorePos::where('user_id', $user_id)->first();
            $register = CashRegister::create([
                'user_id' => $user_id,
                'status' => 'open',
                'store_id' => $this->store_id,
                'supplier_id' => $this->supplier_id,
                'store_pos_id' => !empty($store_pos) ? $store_pos->id : null
            ]);
        }
        return $register;
    }
    // +++++++++++++++++++++ changeExchangeRate() : Get "exchange_rate" value +++++++++++++++++++++
    public function changeExchangeRate()
    {
        if (isset($this->supplier))
        {
            $supplier = Supplier::find($this->supplier);
            if(isset($supplier->exchange_rate)){
                $this->exchange_rate =  str_replace(',' ,'',$supplier->exchange_rate);
            }
            else
                $this->exchange_rate =System::getProperty('dollar_exchange');
        }
        else{
            $this->exchange_rate =System::getProperty('dollar_exchange');
        }
    }

    // public function ShowDollarCol()
    // {
    //     $this->showColumn= !$this->showColumn;
    // }

    // public function updateProductQuantityStore($product_id, $store_id, $new_quantity, $old_quantity = 0)
    // {
    //     $qty_difference = $new_quantity - $old_quantity;

    //     if ($qty_difference != 0) {
    //         $product_store = ProductStore::where('product_id', $product_id)
    //             ->where('store_id', $store_id)
    //             ->first();

    //         if (empty($product_store)) {
    //             $product_store = new ProductStore();
    //             $product_store->product_id = $product_id;
    //             $product_store->store_id = $store_id;
    //             $product_store->quantity_available = 0;
    //         }

    //         $product_store->quantity_available += $qty_difference;
    //         $product_store->save();
    //     }

    //     return true;
    // }
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';
        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);
        return (float)$num;
    }
}
