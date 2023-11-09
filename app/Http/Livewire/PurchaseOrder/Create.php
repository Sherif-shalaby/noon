<?php

namespace App\Http\Livewire\PurchaseOrder;

use Carbon\Carbon;
use App\Models\User;
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
use App\Models\GeneralTax;
use App\Utils\ProductUtil;
use App\Models\AddStockLine;
use App\Models\Brand;
use App\Models\CashRegister;
use App\Models\ProductStore;
use Livewire\WithPagination;
use App\Models\StockTransaction;
use App\Models\CustomerOfferPrice;
use App\Models\CustomerPriceOffer;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionSellLine;
use Illuminate\Contracts\View\View;
use App\Models\MoneySafeTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Models\CashRegisterTransaction;
use App\Models\PurchaseOrderLine;
use App\Models\StockTransactionPayment;
use App\Models\PurchaseOrderTransaction;
use App\Models\TransactionCustomerOfferPrice;
use Illuminate\Contracts\Foundation\Application;

class Create extends Component
{
    use WithPagination;

    public $divide_costs , $other_expenses = 0, $other_payments = 0 , $block_for_days , $tax_method , $validity_days , $store_id,$block_qty , $suppliers,$supplier_id ,$stores, $status, $order_date, $purchase_type,
        $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $po_no ,$exchange_rate, $amount, $method,
        $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false,
        $transaction_currency, $current_stock, $clear_all_input_stock_form, $searchProduct, $items = [], $department_id,
        $files, $upload_documents , $details , $dollar_total_cost ,$total_subtotal , $productUtil , $discount_type , $discount_value , $total_cost , $dollar_total_cost_var=[] , $total_cost_var=[] ,
        $allproducts = [] , $brand_id = 1, $brands = [];
    protected $rules =
    [
        'store_id' => 'required',
        'supplier_id' => 'required',
        'supplier' => 'required',
        'status' => 'required',
        'paying_currency' => 'required',
        'purchase_type' => 'required',
        'payment_status' => 'required',
        'method' => 'required',
        'amount' => 'required',
        'transaction_currency' => 'required'
    ];
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    protected $listeners = ['listenerReferenceHere', 'create_purchase_order'];

    public function listenerReferenceHere($data)
    {
        // ++++++++++++ department filter ++++++++++++
        if (isset($data['var1']) && $data['var1'] == "department_id") {
            $this->updatedDepartmentId($data['var2'], 'department_id');
        }
        // ++++++++++++ brand filter ++++++++++++
        if (isset($data['var1']) && $data['var1'] == "brand_id") {
            $this->updatedDepartmentId($data['var2'], 'brand_id');

        }
        // ++++++++++++ supplier filter ++++++++++++
        if (isset($data['var1']) && $data['var1'] == "supplier_id") {
            $this->updatedDepartmentId($data['var2'], 'supplier_id');
        }
    }
    // ++++++++++++++++++ when click on filters , execute updatedDepartmentId() ++++++++++++++++++
    public function updatedDepartmentId($value, $name)
    {
        // Handle department and brand filters
        $query = Product::query();
        // "department" filter
        if ($name == 'department_id')
        {
            $query->where(function ($query) use ($value)
            {
                $query->where('category_id', $value)
                    ->orWhere('subcategory_id1', $value)
                    ->orWhere('subcategory_id2', $value)
                    ->orWhere('subcategory_id3', $value);
            });
        }
        // "brand" filter
        if ($name == 'brand_id')
        {
            $query->where('brand_id', $value);
        }
        // "supplier" filter
        if ($name == 'supplier_id')
        {
            // Get the stock transaction IDs associated with the supplier ID
            $stockTransactionIds = StockTransaction::where('supplier_id', $value)->pluck('id');
            // Get all product IDs associated with the stock transaction IDs
            $productIds = AddStockLine::whereIn('stock_transaction_id', $stockTransactionIds)->pluck('product_id');
            // Apply the filter to the products based on the retrieved product IDs
            $query->whereIn('id', $productIds);
        }
        // Get the filtered products
        $this->allproducts = $query->get();
    }

    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    // Get "suppliers" and "stores" and "product number"
    public function mount()
    {
        // +++++++++ get "all suppliers" +++++++++
        $this->loadSuppliers();
        // +++++++++ get "all stores" +++++++++
        $this->loadStores();

        // +++++++++ get "product number" +++++++++
        $this->loadPoNo();
        if (!empty($this->store_id)) {
            $products_store = ProductStore::where('store_id', $this->store_id)->pluck('product_id');
            $this->allproducts = Product::whereIn('id', $products_store)->get();
        } else {
            $this->allproducts = Product::get();
        }
        $this->department_id = null;

    }
    // +++++++++ Get "suppliers" +++++++++
    public function loadSuppliers()
    {
        $this->suppliers = Supplier::all();
    }
    // +++++++++ Get "stores" +++++++++
    public function loadStores()
    {
        $this->stores = Store::all();
    }
    // +++++++++ Get "loadPoNo" +++++++++
    public function loadPoNo()
    {
        $this->po_no = $this->getNumberByType('purchase_order');
    }
    /* ++++++++++++++++ getNumberByType() : get "product number" ++++++++++++++++ */
    public function getNumberByType($type, $store_id = null, $i = 1)
    {
        $number = '';
        $store_string = '';
        if (!empty($store_id)) {
            $store_string = $this->getStoreNameFirstLetters($store_id);
        }
        if ($type == 'purchase_order')
        {
            $po_count = PurchaseOrderTransaction::where('type', $type)->count() + $i;
            $number = 'PO' . $store_string . $po_count;
        }
        return $number;
    }
    // ++++++++++++++++++++++++++++++++++ render() == index() method ++++++++++++++++++++++++++++++++++
    public function render(): Factory|View|Application
    {
        $this->brands = Brand::orderby('created_at', 'desc')->pluck('name', 'id');

        $status_array = $this->getPurchaseOrderStatusArray();
        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $product_id = request()->get('product_id');
        $suppliers  = Supplier::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $stock_lines = AddStockLine::get();

        $customers   = Customer::get();
        $stores   = Store::get();

        $taxes      = GeneralTax::get();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        $stores = Store::getDropdown();
        $departments = Category::get();
        $search_result = '';
        $products = '';
        // $branch_id = Employee::select('branch_id')->where('id', auth()->user()->id)->latest()->first();
        $brands = Brand::orderby('created_at', 'desc')->pluck('name', 'id');
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        // dd($suppliers);

        if(!empty($this->searchProduct))
        {
            $search_result = Product::when($this->searchProduct,function ($query)
            {
                // return $query->where('name','like','%'.$this->searchProduct.'%');
                return $query->where('name', 'like', '%' . $this->searchProduct . '%')
                             ->orWhere('sku', 'like', '%' . $this->searchProduct . '%');
            });
            $search_result = $search_result->paginate();
            if(count($search_result) === 1){
                $this->add_product($search_result->first()->id);
                $search_result = '';
                $this->searchProduct = '';
            }
        }

        if ($this->source_type == 'pos')
        {
            $users = StorePos::pluck('name', 'id');
        }
        elseif ($this->source_type == 'store')
        {
            $users = Store::pluck('name', 'id');
        }
        elseif ($this->source_type == 'safe')
        {
            $users = MoneySafe::pluck('name', 'id');
        }
        else
        {
            $users = User::Notview()->pluck('name', 'id');
        }
        if(!empty($this->department_id)){
            // return($this->department_id);
            $products = Product::where('category_id' ,1)->get();
        }
        else{
            $products = Product::paginate();
        }

        $this->changeExchangeRate();
        $this->dispatchBrowserEvent('initialize-select2');


        return view('livewire.purchase-order.create',
            compact('status_array',
            'payment_status_array',
            'payment_type_array',
            'stores',
            'stock_lines' ,
            'product_id',
            'payment_types',
            'payment_status_array',
            'suppliers',
            'customers',
            'taxes',
            'selected_currencies',
            'preparers' ,
            'products',
            'departments',
            'search_result',
            'users',
            'brands',
            'suppliers'
        ));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    // ++++++++++++++++++++++++++++++++++ store() method ++++++++++++++++++++++++++++++++++

    public function store(): Redirector|Application|RedirectResponse
    {
        $this->validate([
            'store_id' => 'required',
            'supplier_id' => 'required',
        ]);
        try
        {
            // ++++++++++++++++++++++++++++ TransactionCustomerOfferPrice table ++++++++++++++++++++++++++++
            // Add stock transaction
            $purchaseOrderTransaction = new PurchaseOrderTransaction();
            $purchaseOrderTransaction->store_id = $this->store_id;
            $purchaseOrderTransaction->supplier_id = $this->supplier_id;
            $purchaseOrderTransaction->po_no = $this->po_no;
            $purchaseOrderTransaction->details = $this->details;
            $purchaseOrderTransaction->transaction_date = !empty($this->transaction_date) ? $this->transaction_date : Carbon::now();
            $purchaseOrderTransaction->created_by = auth()->user()->id;
            // grand_total
            $purchaseOrderTransaction->grand_total = $this->num_uf($this->sum_total_cost());
            // final_total
            $purchaseOrderTransaction->final_total = isset($this->discount_amount) ? ($this->num_uf($this->sum_total_cost()) - $this->discount_amount) : $this->num_uf($this->sum_total_cost());
            // deleted_by
            // $purchaseOrderTransaction->deleted_by = null;
            // created_at
            $purchaseOrderTransaction->created_at = now();
            // updated_at
            $purchaseOrderTransaction->updated_at = null;
            $purchaseOrderTransaction->order_date = now();
            // Save the purchase order transaction to the database
            $purchaseOrderTransaction->save();

            DB::beginTransaction();
            $purchase_orders = [];
            // ++++++++++++++++++++++++++++ CustomerOfferPrice table : insert Products ++++++++++++++++++++++++++++
            foreach ($this->items as $index => $item)
            {
                if (!empty($item['product']['id']) && !empty($item['quantity']))
                {
                    // dd($item);
                    // Create a new array for each item
                    $purchase_order = [];

                    // Set values for the new array
                    $purchase_order['purchase_order_transaction_id'] = $purchaseOrderTransaction->id;
                    $purchase_order['product_id'] = $item['product']['id'];
                    $purchase_order['quantity'] = $item['quantity'];
                    // $purchase_order['current_stock'] = $item['current_stock'];
                    $purchase_order['purchase_price'] = $item['purchasing_price'];
                    $purchase_order['purchase_price_dollar'] = $item['dollar_purchasing_price'];
                    // sub_total
                    $purchase_order['sub_total'] = !empty($item['sub_total']) ? $this->num_uf($item['sub_total']) : 0 ;
                    // created_by
                    $purchase_order['created_by'] = Auth::user()->id;
                    // updated_by
                    $purchase_order['updated_by'] = null;
                    // deleted_by
                    $purchase_order['deleted_by'] = null;
                    // created_at
                    $purchase_order['created_at'] = now();
                    // updated_at
                    $purchase_order['updated_at'] = null;
                    // deleted_at
                    // $purchase_order['deleted_at'] = null;

                    // Add the purchase_order for this item to the array
                    $purchase_orders[] = $purchase_order;
                }
            }

            // Create multiple PurchaseOrderLine records in the database
            PurchaseOrderLine::insert($purchase_orders);

            DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'lang.success']);
        }
        catch (\Exception $e)
        {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs']);
            dd($e);
        }
        return redirect()->route('purchase_order.create');
    }

    public function add_product($id, $add_via = null)
    {
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
        // Task_9_10_2023 : dollar_purchasing_price
        // $dollar_sell = AddStockLine::select('dollar_sell_price')->where('product_id', $product['id'])->latest()->first();
        // Task_9_10_2023 : dinar_selling_price
        // $dinar_sell = AddStockLine::select('sell_price')->where('product_id', $product['id'])->latest()->first();
        // Task_30_10_2023 : dollar_purchase_price
        $dollar_purchase = AddStockLine::select('dollar_purchase_price')->where('product_id', $product['id'])->latest()->first();
        // Task_30_10_2023 : dinar_purchase_price
        $dinar_purchase = AddStockLine::select('purchase_price')->where('product_id', $product['id'])->latest()->first();
        // Task_9_10_2023 : quantity
        $quantity = AddStockLine::where('product_id', $product['id'])->sum('quantity');
        // The "Total quantity" of "each product"
        $current_stock = AddStockLine::where('product_id', $product['id'])->sum('quantity');
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
            //    dd($item['dollar_total_cost']);
                $totalDollarCost += $item['dollar_total_cost'];
            }
        }
//        dd($totalDollarCost);
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

    public function total_quantity(){
        $totalQuantity = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item){
                $totalQuantity += (int)$item['quantity'];
            }
        }
       return $totalQuantity;
    }
    // +++++++++++ final_total() : get the final total cost in dollars +++++++++++++++++
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

    public function changeExchangeRate()
    {
        if (isset($this->supplier)){
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

    public function ShowDollarCol()
    {
        $this->showColumn= !$this->showColumn;
    }

    public function updateProductQuantityStore($product_id, $store_id, $new_quantity, $old_quantity = 0)
    {
        $qty_difference = $new_quantity - $old_quantity;

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
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';
        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);
        return (float)$num;
    }


}
