<?php

namespace App\Http\Livewire\CustomerPriceOffer;

use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerOfferPrice;
use App\Models\CustomerPriceOffer;
use App\Models\Employee;
use App\Models\GeneralTax;
use App\Models\JobType;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\SellLine;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
use App\Models\TransactionCustomerOfferPrice;
use App\Models\TransactionSellLine;
use App\Models\User;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithPagination;

    public $customer_offer_price , $divide_costs , $other_expenses = 0, $other_payments = 0 , $block_for_days , $tax_method , $validity_days , $store_id,$block_qty, $customer_id , $customers,$stores, $status, $order_date, $purchase_type,
        $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $exchange_rate, $amount, $method,
        $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false,
        $transaction_currency, $current_stock, $clear_all_input_stock_form, $searchProduct, $items = [], $department_id,
        $files, $upload_documents , $discount_type , $discount_value , $total_cost , $dollar_total_cost_var=[] , $total_cost_var=[] ;

    protected $rules =
    [
        'store_id' => 'required',
        'customer_id' => 'required',
        'supplier' => 'required',
        'status' => 'required',
        'paying_currency' => 'required',
        'purchase_type' => 'required',
        'payment_status' => 'required',
        'method' => 'required',
        'amount' => 'required',
        'transaction_currency' => 'required'
    ];
    // Get "customers" and "stores"
    public function mount($id)
    {
        $this->customer_offer_price = TransactionCustomerOfferPrice::with('transaction_customer_offer_price.product')->find($id);
        // dd($this- >customer_offer_price);
        // +++++++++ get "all customers" +++++++++
        $this->loadCustomers();
        // +++++++++ get "all stores" +++++++++
        $this->loadStores();
    }
    // +++++++++ Get "customers" +++++++++
    public function loadCustomers()
    {
        $this->customers = Customer::all();
    }
    // +++++++++ Get "stores" +++++++++
    public function loadStores()
    {
        $this->stores = Store::all();
    }
    // ++++++++++++++++++++++++++++++++++ render() == index() method ++++++++++++++++++++++++++++++++++
    public function render(): Factory|View|Application
    {
        $customer_offer_price = $this->customer_offer_price;
        // dd($customer_offer_price);
        $status_array = $this->getPurchaseOrderStatusArray();
        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $product_id = request()->get('product_id');
        $suppliers  = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        // ++++++++++++++ stores filter ++++++++++++++
        $stores   = Store::get();
        $this->store_id = $customer_offer_price->store_id;
        // ++++++++++++++ customers filter ++++++++++++++
        $customers   = Customer::get();
        $this->customer_id = $customer_offer_price->customer_id;

        $stock_lines = AddStockLine::get();

        $this->block_qty = $customer_offer_price->block_qty;
        $this->block_for_days = $customer_offer_price->block_for_days;
        $this->validity_days = $customer_offer_price->validity_days;
        $this->tax_method = $customer_offer_price->tax_method;
        $this->discount_type = $customer_offer_price->discount_type;
        $this->discount_value = $customer_offer_price->discount_value;

        $taxes      = GeneralTax::get();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        $stores = Store::getDropdown();
        $departments = Category::get();
        $search_result = '';
        if(!empty($this->searchProduct))
        {
            $search_result = Product::when($this->searchProduct,function ($query)
            {
                return $query->where('name','like','%'.$this->searchProduct.'%');
            });
            $search_result = $search_result->paginate();
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

        $this->changeExchangeRate();
        $this->dispatchBrowserEvent('initialize-select2');


        return view('livewire.customer-price-offer.edit',
            compact('status_array','customer_offer_price',
            'payment_status_array',
            'payment_type_array',
            'customer_offer_price',
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
            'users'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    // ++++++++++++++++++++++++++++++++++ store() method ++++++++++++++++++++++++++++++++++
    public function store(): Redirector|Application|RedirectResponse
    {
        try
        {
            // ++++++++++++++++++++++++++++ TransactionCustomerOfferPrice table ++++++++++++++++++++++++++++
            // Add stock transaction
            $transaction_customer_offer = new TransactionCustomerOfferPrice();
            // store_id
            $transaction_customer_offer->store_id = $this->store_id;
            // customer_id
            $transaction_customer_offer->customer_id = $this->customer_id;
            // is_quotation
            $transaction_customer_offer->is_quotation = 1 ;
            // transaction_date
            $transaction_customer_offer->transaction_date = !empty($this->transaction_date) ? $this->transaction_date : Carbon::now();
            // dinar_sell_price
            $transaction_customer_offer->sell_price = $this->num_uf($this->sum_total_cost());
            // $transaction_customer_offer->total_sell_price = isset($this->discount_value) ? ($this->num_uf($this->sum_total_cost()) - $this->discount_value) : $this->num_uf($this->sum_dollar_total_cost());
            $transaction_customer_offer->total_sell_price = isset($this->discount_value) ? ($this->num_uf($this->sum_total_cost()) - $this->discount_value) : $this->num_uf($this->sum_total_cost());
            // dollar_sell_price
            $transaction_customer_offer->dollar_sell_price = $this->num_uf($this->sum_dollar_total_cost());
            $transaction_customer_offer->total_dollar_sell_price = $this->dollar_final_total();
            // status
            $transaction_customer_offer->status = "draft";
            // block_qty , block_for_days , validity_days , tax_method
            $transaction_customer_offer->block_qty = !empty($this->block_qty) ? 1 : 0;
            $transaction_customer_offer->block_for_days = !empty($this->block_for_days) ? $this->block_for_days : 0; //reverse the block qty handle by command using cron job
            $transaction_customer_offer->validity_days = !empty($this->validity_days) ? $this->validity_days : 0;
            $transaction_customer_offer->tax_method = !empty($this->tax_method) ? $this->tax_method : null;
            // discount_type , discount_value
            $transaction_customer_offer->discount_type = !empty($this->discount_type) ? $this->discount_type : null;
            $transaction_customer_offer->discount_value = !empty($this->discount_value) ? $this->discount_value : null;
            // created_by
            $transaction_customer_offer->created_by = Auth::user()->id;
            $transaction_customer_offer->created_at = now();
            $transaction_customer_offer->save();

            DB::beginTransaction();
            // add  products to stock lines
            $customer_offer_prices = [];
            // ++++++++++++++++++++++++++++ CustomerOfferPrice table : insert Products ++++++++++++++++++++++++++++
            // foreach ($this->items as $index => $item)
            // {
            //     // Check if product id and quantity are available in the item
            //     if (!empty($item['product']['id']) && !empty($item['quantity']))
            //     {
            //         $customer_offer_price['transaction_id'] = $transaction->id ;
            //         // product
            //         $customer_offer_price['product_id'] = !empty($item['product']['id']) ? $item['product']['id'] : null ;
            //         // quantity
            //         $customer_offer_price['quantity'] = $item['quantity'];
            //         // dinar sell_price
            //         $customer_offer_price['sell_price'] = $this->num_uf($this->sum_dollar_sub_total());
            //         // dollar sell_price
            //         $customer_offer_price['dollar_sell_price'] = $this->num_uf($this->sum_dollar_sub_total());
            //         // dinar total_sell_price
            //         // $customer_offer_price['total_sell_price'] = $this->num_uf($this->sum_dinar_sub_total());
            //         // dollar total_sell_price
            //         // $customer_offer_price['total_dollar_sell_price'] = $this->num_uf($this->sum_dollar_sub_total());
            //         // Add the customer offer price for this item to the array
            //         $customer_offer_prices[] = $customer_offer_price;
            //     }
            // }
            foreach ($this->items as $index => $item)
            {
                if (!empty($item['product']['id']) && !empty($item['quantity']))
                {
                    // Create a new array for each item
                    $customer_offer_price = [];

                    // Set values for the new array
                    $customer_offer_price['transaction_customer_offer_id'] = $transaction_customer_offer->id;
                    $customer_offer_price['product_id'] = $item['product']['id'];
                    $customer_offer_price['quantity'] = $item['quantity'];
                    $customer_offer_price['sell_price'] = $item['total_cost_var'];
                    $customer_offer_price['dollar_sell_price'] = $item['dollar_total_cost_var'];
                    $customer_offer_price['created_at'] = now();

                    // Add the customer offer price for this item to the array
                    $customer_offer_prices[] = $customer_offer_price;
                }
            }

            // Create multiple CustomerOfferPrice records in the database
            CustomerOfferPrice::insert($customer_offer_prices);

            DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'lang.success']);
        }
        catch (\Exception $e)
        {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs']);
            dd($e);
        }
        return redirect()->route('customer_price_offer.create');
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
        //                $this->items[$key]['sub_total'] = ( $this->items[$key]['price'] * $this->items[$key]['quantity'] ) -( $this->items[$key]['quantity'] * $this->items[$key]['discount']);
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
        $new_item = [
            'show_product_data' => $show_product_data,
            'variations' => $variations,
            'product' => $product,
            'quantity' => 1,
            'unit' => null,
            'base_unit_multiplier' => null,
            'sub_total' => 0,
            'dollar_sub_total' => 0,
            'size' => !empty($product->size) ? $product->size : 0,
            'total_size' => !empty($product->size) ? $product->size * 1 : 0,
            'weight' => !empty($product->weight) ? $product->weight : 0,
            'total_weight' => !empty($product->weight) ? $product->weight * 1 : 0,
            'dollar_cost' => 0,
            'cost' => 0,
            'dollar_total_cost' => 0,
            'total_cost' => 0,
            'current_stock' =>0,
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
                $this->items[$index]['selling_price']=($this->items[$index]['dollar_purchase_price']+(float)$this->items[$index]['fill_quantity']);
            }else{
                $percent=((float)$this->items[$index]['dollar_purchase_price'] * (float)$this->items[$index]['fill_quantity']) / 100;
                $this->items[$index]['selling_price']=($this->items[$index]['dollar_purchase_price']+$percent);
            }
        }
        if(!empty($this->items[$index]['dollar_purchase_price'])){
            if($this->items[$index]['fill_type']=='fixed'){
                $this->items[$index]['dollar_selling_price']=($this->items[$index]['dollar_purchase_price']+(float)$this->items[$index]['fill_quantity']);
            }
        else{
                $percent = ((float)$this->items[$index]['dollar_purchase_price'] * (float)$this->items[$index]['fill_quantity']) / 100;
                $this->items[$index]['dollar_selling_price'] = ($this->items[$index]['dollar_purchase_price'] + $percent);
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
        $this->items[$index]['dollar_total_cost'] = $this->items[$index]['dollar_selling_price'] * $this->items[$index]['quantity'];
        $this->items[$index]['dollar_total_cost_var'] = $this->items[$index]['dollar_total_cost'];
        return number_format($this->items[$index]['dollar_total_cost'], 2);
    }
    // ++++++++++++++++++++++++++ Task : اجمالي التكاليف بالدينار ++++++++++++++++++++++++++
    public function total_cost($index)
    {
        $this->items[$index]['total_cost'] = $this->items[$index]['selling_price'] * $this->items[$index]['quantity'];
        $this->items[$index]['total_cost_var'] = $this->items[$index]['total_cost'] ;
        return number_format($this->items[$index]['total_cost'],2) ;
    }
    // ++++++++++++++++++++++++++ Task : convert_dinar_price() : سعر البيع بالدينار ++++++++++++++++++++++++++
    public function convert_dinar_price($index)
    {
        // dd($this->exchange_rate);
        if (!empty($this->items[$index]['dollar_selling_price']) )
        {
            $this->items[$index]['selling_price'] = $this->items[$index]['dollar_selling_price'] * $this->exchange_rate;
        }
        else
        {
            $this->items[$index]['selling_price'] = $this->items[$index]['dollar_selling_price'];
        }
        // return $selling_price;
    }
    // ++++++++++++++++++++++++++ Task : convert_dollar_price() : سعر البيع بالدولار ++++++++++++++++++++++++++
    public function convert_dollar_price($index)
    {
        // dd($this->exchange_rate);
        if (!empty($this->items[$index]['selling_price']) )
        {
            $this->items[$index]['dollar_selling_price'] = $this->items[$index]['selling_price'] / $this->exchange_rate;
        }
        else
        {
            $this->items[$index]['dollar_selling_price'] = $this->items[$index]['selling_price'];
        }
        // return $selling_price;
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
//                dd($item['dollar_total_cost']);
                $totalDollarCost += $item['dollar_total_cost'];
            }
        }
//        dd($totalDollarCost);
        return number_format($totalDollarCost,2);
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
                'customer_id' => $this->customer_id,
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
