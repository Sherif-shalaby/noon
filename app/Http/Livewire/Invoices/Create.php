<?php

namespace App\Http\Livewire\Invoices;

use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\EarningOfPoint;
use App\Models\Invoice;
use App\Models\MoneySafeTransaction;
use App\Models\PaymentTransactionSellLine;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use App\Models\RedemptionOfPoint;
use App\Models\SellLine;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\System;
use App\Models\TransactionPayment;
use App\Models\TransactionSellLine;
use App\Models\Variation;
use App\Utils\pos;
use App\Utils\Util;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $products = [],$variations = [], $department_id = null, $items = [], $price  ,$total, $client_phone,
        $client_id, $client, $cash = 0, $rest, $invoice,$invoice_id, $date, $payment_status,
         $data = [], $payments = [], $invoice_lang, $transaction_currency, $store_id, $store_pos_id,
         $showColumn = false, $anotherPayment = false, $sale_note, $payment_note, $staff_note,$payment_types,
        $discount = 0.00, $total_dollar, $add_customer=[], $customers = [],$discount_dollar, $store_pos,
        // "الباقي دولار" , "الباقي دينار"
        $dollar_remaining=0 , $dinar_remaining=0 ,

        $final_total, $dollar_final_total, $dollar_amount = 0 , $amount = 0 ,$redirectToHome = false, $status = 'final',
        $draft_transactions, $show_modal = false;

    protected $rules = [
            'items' => 'array|min:1',
            'client_id' => 'required',
            'store_id' => 'required',
            'store_pos_id' => 'required',
            'payment_status' => 'required',
            'invoice_lang' => 'required',
    ];


    protected $listeners = ['listenerReferenceHere'];
    public function listenerReferenceHere($data)
    {
        if(isset($data['var1'])) {
            $this->{$data['var1']} = $data['var2'];
        }
//        dd(11);
    }
    public function mount(Util $commonUtil)
    {
        $this->payment_types = $commonUtil->getPaymentTypeArrayForPos();
        $this->department_id = null;
        $this->invoice_lang = !empty(System::getProperty('invoice_lang')) ? System::getProperty('invoice_lang') : 'en';
        $stores = Store::getDropdown();
        $this->store_id = array_key_first($stores);
        $this->draft_transactions = TransactionSellLine::where('status','draft')->get();
        $this->store_pos = StorePos::where('store_id', $this->store_id)->where('user_id', Auth::user()->id)->pluck('name','id')->toArray();
        $this->store_pos_id = array_key_first($this->store_pos);
        $this->loadCustomers();
    }

    public function loadCustomers()
    {
        $this->customers = Customer::all();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

    }

    public function render()
    {
        $allproducts = Product::get();
        $departments = Category::get();
        $this->customers   = Customer::get();
        $languages = System::getLanguageDropdown();
        $currenciesId = [System::getProperty('currency'), 2];
        $this->store_pos = StorePos::where('store_id', $this->store_id)->where('user_id', Auth::user()->id)->pluck('name','id')->toArray();
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $customer_types=CustomerType::latest()->pluck('name','id');
        $stores = Store::getDropdown();
        if (empty($store_pos)) {
            $this->dispatchBrowserEvent('showCreateProductConfirmation');
        }
        // $variations=Variation::orderBy('created_at','desc')->get();
        // $this->variations=Variation::all();

        $this->dispatchBrowserEvent('initialize-select2');
        return view('livewire.invoices.create', compact(
            'departments',
            'allproducts',
            'languages',
            'selected_currencies',
            'stores',
            'customer_types'
            ));
    }

    public function changeStorePos(){
        dd($this->store_id);
        $this->store_pos = StorePos::where('store_id', $this->store_id)->where('user_id', Auth::user()->id)->pluck('name','id')->toArray();
    }
    // ++++++++++++ submit() : save "cachier data" in "TransactionSellLine" Table ++++++++++++
    public function submit(){
        $this->validate();
        try {

            // Add Transaction Sell Line
            $transaction_data = [
                'store_id' => $this->store_id,
                'customer_id' => $this->client_id,
                'store_pos_id' => $this->store_pos_id,
                'exchange_rate' => 0,
                'type' => 'sell',
//                'transaction_currency' => $this->transaction_currency,
                'final_total' => $this->num_uf($this->final_total),
                'grand_total' => $this->num_uf($this->total),
                // 'dollar_final_total' :  'النهائي بالدولار'
                'dollar_final_total' => $this->num_uf($this->dollar_final_total),
                'dollar_grand_total' => $this->num_uf($this->total_dollar),
                'transaction_date' => Carbon::now(),
                // "dollar_remaining" inputField : الباقي بالدولار
                'dollar_remaining' => $this->num_uf( $this->dollar_remaining ),
                // "dinar_remaining" inputField : الباقي بالدينار
                'dinar_remaining' => $this->num_uf( $this->dinar_remaining ) ,
                'invoice_no' => $this->generateInvoivceNumber(),
                'status' => $this->status,
                'payment_status' => $this->payment_status,
                'sale_note' => $this->sale_note,
                'staff_note' => $this->staff_note,
                'discount_value' => $this->num_uf($this->discount),
//            'discount_amount' => $this->commonUtil->num_uf($request->discount_amount),
//            'current_deposit_balance' => $this->commonUtil->num_uf($request->current_deposit_balance),
//            'used_deposit_balance' => $this->commonUtil->num_uf($request->used_deposit_balance),
//            'remaining_deposit_balance' => $this->commonUtil->num_uf($request->remaining_deposit_balance),
//            'add_to_deposit' => $this->commonUtil->num_uf($request->add_to_deposit),
//            'tax_id' => !empty($request->tax_id_hidden) ? $request->tax_id_hidden : null,
//            'tax_method' => $request->tax_method ?? null,
//            'total_tax' => $this->commonUtil->num_uf($request->total_tax),
//            'total_item_tax' => $this->commonUtil->num_uf($request->total_item_tax),
//            'terms_and_condition_id' => !empty($request->terms_and_condition_id) ? $request->terms_and_condition_id : null,
                'created_by' => Auth::user()->id,
            ];
            DB::beginTransaction();
            $transaction = TransactionSellLine::create($transaction_data);

            // Add Sell line
            foreach ($this->items as $item) {
                if ($item['discount_type'] == 0) {
                    $item['discount_type'] = null;
                }
                $old_quantity = 0;
                $sell_line = new SellLine();
                $sell_line->transaction_id = $transaction->id;
                $sell_line->product_id = $item['product']['id'];
                $sell_line->variation_id = $item['variation']['id'];
                $sell_line->product_discount_type = !empty($item['discount_type']) ? $item['discount_type'] : null;
                $sell_line->product_discount_amount = !empty($item['discount_price']) ? $this->num_uf($item['discount_price'], 2) : 0;
                $sell_line->product_discount_category = !empty($item['discount_category']) ? $item['discount_category'] : 0;
                $sell_line->quantity = (float)$item['quantity'];
                $sell_line->sell_price = !empty($item['current_stock']['sell_price']) ? $item['current_stock']['sell_price'] : null;
                $sell_line->dollar_sell_price = !empty($item['current_stock']['dollar_sell_price']) ? $item['current_stock']['dollar_sell_price'] : null;
                $sell_line->purchase_price = !empty($item['current_stock']['purchase_price']) ? $item['current_stock']['purchase_price'] : null;
                $sell_line->dollar_purchase_price = !empty($item['current_stock']['dollar_purchase_price']) ? $item['current_stock']['dollar_purchase_price'] : null;
                $sell_line->exchange_rate = $item['exchange_rate'];
                $sell_line->sub_total = $this->num_uf($item['sub_total']);
                $sell_line->dollar_sub_total = $this->num_uf($item['dollar_sub_total']);
//                $sell_line->tax_id = !empty($item['tax_id']) ? $item['tax_id'] : null;
//                $sell_line->tax_method = !empty($item['tax_method']) ? $item['tax_method'] : null;
//                $sell_line->tax_rate = !empty($item['tax_rate']) ? $this->num_uf($item['tax_rate']) : 0;
//                $sell_line->item_tax = !empty($item['item_tax']) ? $this->num_uf($item['item_tax']) : 0;
                $sell_line->save();
                $keep_sell_lines[] = $sell_line->id;

                $stock_id = $item['current_stock']['id'];

                // Update Sold Quantity in stock line
                $this->updateSoldQuantityInAddStockLine($sell_line->product_id, $transaction->store_id, (float)$item['quantity'], $old_quantity, $stock_id);
                if ($transaction->status == 'final') {
                    $product = Product::find($sell_line->product_id);
                    $this->decreaseProductQuantity($sell_line->product_id, $transaction->store_id, (float) $sell_line->quantity);
                }

            }

                // Add Payment Method
            if ($transaction->status != 'draft'){
                if(!empty($this->dollar_amount) || !empty($this->amount)){
                    $payment_data = [
                        'transaction_id' => $transaction->id,
                        'amount' => $this->amount,
                        'dollar_amount' => $this->dollar_amount,
                        // "dollar_remaining" inputField
                        'dollar_remaining' => $this->dollar_remaining ,
                        // "dinar_remaining" inputField
                        'dinar_remaining' => $this->dinar_remaining ,
                        'method' => 'cash',
                        'paid_on' => Carbon::now(),
                        'payment_note' => $this->payment_note,
                        'exchange_rate' => System::getProperty('dollar_exchange'),
                    ];
                    if ($this->dollar_amount > 0 || $this->amount > 0) {
                        $transaction_payment = null;
                        if (!empty($this->dollar_amount) || !empty($this->amount)) {
                            $payment_data['created_by'] = Auth::user()->id;
                            $payment_data['payment_for'] =  $transaction->customer_id;
                            $transaction_payment = PaymentTransactionSellLine::create($payment_data);
                        }
                    }
//                $this->updateTransactionPaymentStatus($transaction->id);

                    $this->addPayments($transaction, $payment_data, 'credit', null, $transaction_payment->id);
                }



                // update customer balance
                $customer = Customer::find($transaction->customer_id);
                $customer->dollar_balance += $this->dollar_amount - $this->total_dollar;
                $customer->balance += $this->amount - $this->total;
                $customer->save();
                $payment_types = $this->getPaymentTypeArrayForPos();
                $html_content = $this->getInvoicePrint($transaction, $payment_types, $this->invoice_lang);

                // Emit a browser event to trigger the invoice printing
                $this->emit('printInvoice', $html_content);
            }
            dd($this->items);

            DB::commit();
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم إضافة الفاتورة بنجاح']);
            return $this->redirect('/invoices/create');

        } catch(\Exception $e){
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
//        return $html_content;

//
    }

    public function changeStatus(){
        $this->status = 'draft';
        $this->submit();
    }

    public function getClient()
    {
        if ($this->client_phone) {
            $this->client = Customer::where('phone', $this->client_phone)->first();
            if ($this->client) {
                $this->client_id = $this->client->id;
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'تم إيجاد العميل بنجاح',]);
            } else {
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'عذرا, لم يتم إيجاد العميل']);
            }
        } else {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'يرجى إدخال رقم العميل']);
        }
    }

    public function updatedDepartmentId($department_id)
    {
        $this->variations = $department_id > 0? Variation::whereHas('product', function ($query) use ($department_id) {
            $query->where('category_id', $department_id);
        })->get() : Variation::all();
    }

    public function addCustomer(){
        $this->add_customer['created_by']=Auth::user()->id;
        $customer = Customer::create($this->add_customer);
        $this->customers = Customer::all();
        $this->client_id = $customer->id;
        $this->add_customer = [];
        $this->emit('hideModal',$customer);
        $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'تم اضافه العميل بنجاح',]);
        $this->emit('customerAdded');

    }

    public function refreshSelect()
    {
        $this->customers = Customer::get();
//        dump($this->customers);
    }

    public function add_product($id)
    {

        $product = Product::where('id',$id)->first();
        $quantity_available = $this->quantityAvailable($product);
        if ( $quantity_available < 1) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
        }

        else {
            $current_stock = $this->getCurrentStock($product);
//            $exchange_rate = $this->getProductExchangeRate($current_stock);
            $exchange_rate =  !empty($current_stock->exchange_rate) ? $current_stock->exchange_rate : System::getProperty('dollar_exchange');
            $product_stores = $this->getProductStores($product);
//            dd($product_stores);
//            dd($current_stock->prices);
//            $discount = $this->getProductDiscount($current_stock);
            if(isset($discount)){
                $discounts = $discount;
            }
            else
                $discounts = 0;

            $newArr = array_filter($this->items, function ($item) use ($product) {
                return $item['product']['id'] == $product->id;
            });
            if (count($newArr) > 0) {
                $key = array_keys($newArr)[0];
                ++$this->items[$key]['quantity'];

                if ($quantity_available  < $this->items[$key]['quantity']) {
                    --$this->items[$key]['quantity'];
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
                }else {
                    $this->items[$key]['sub_total'] = ( $this->items[$key]['price'] * $this->items[$key]['quantity'] ) -( $this->items[$key]['quantity'] * $this->items[$key]['discount']);
                }
            }
            else {
                $price = !empty($current_stock->sell_price) ? number_format($current_stock->sell_price,2) : 0;
                $dollar_price = !empty($current_stock->dollar_sell_price) ? number_format($current_stock->dollar_sell_price,2) : 0;
//                dd($price);
                $this->items[] = [
                    'variation' => $product->variations,
                    'product' => $product,
                    'quantity' => 1,
                    'price' => $this->num_uf($price),
                    'category_id' => $product->category?->id,
                    'department_name' => $product->category?->name,
                    'client_id' => $product->customer?->id,
                    'exchange_rate' => $exchange_rate,
                    'quantity_available' => $quantity_available,
                    'sub_total' => !empty($product->unit) ? (float)($product->unit->base_unit_multiplier * $this->num_uf($price)) : (float) 1 * $this->num_uf($price),
                    'dollar_sub_total' => !empty($product->unit) ? $product->unit->base_unit_multiplier * $dollar_price : 1 * $this->num_uf($dollar_price),
                    'current_stock' => $current_stock,
//                    'discount_categories' =>  $discounts,
                    'discount_categories' =>  null,
                    'discount' => null,
                    'discount_price' => 0,
                    'discount_type' =>  null,
                    'discount_category' =>  null,
                    'dollar_price' => $this->num_uf($dollar_price),
                    'unit_name' =>!empty($product->unit) ? $product->unit->name : '',
                    'base_unit_multiplier' =>!empty($product->unit) ? $product->unit->base_unit_multiplier : 1,
                    'total_quantity' => !empty($product->unit) ?  1 * $product->unit->base_unit_multiplier : 1,
                    'stores' => $product_stores,
//                    'store' => $product_stores->first()->store->name,
                ];

            }
        }
        $this->computeForAll();
//        $this->sumSubTotal();
    }

    public function computeForAll()
    {
        $this->total = 0;
        $this->total_dollar = 0;
        foreach($this->items as $item)
        {
            // dinar_sub_total
            $this->total += $item['sub_total'];
            // dollar_sub_total
            $this->total_dollar += $item['dollar_sub_total'];
        }
        $this->payments[0]['method'] = 'cash';
        $this->rest  = 0;
        // النهائي دينار
        $this->final_total = $this->total;
        // النهائي دولار
        $this->dollar_final_total = $this->total_dollar;
        // task : الباقي دينار
        $this->dinar_remaining = ($this->amount - $this->final_total);
        // task : الباقي دولار
        $this->dollar_remaining = ($this->dollar_amount - $this->dollar_final_total);
    }

    public function increment($key){

        if ($this->items[$key]['quantity'] < $this->items[$key]['quantity_available']) {
            $this->items[$key]['quantity']++;

            $this->items[$key]['total_quantity'] = $this->items[$key]['base_unit_multiplier']*  $this->items[$key]['quantity'] ;
            $this->items[$key]['sub_total']  =  ( $this->items[$key]['price'] * $this->items[$key]['total_quantity'] ) -
                ( $this->items[$key]['quantity'] * $this->items[$key]['discount_price']);
            $this->items[$key]['dollar_sub_total']  =  ( $this->items[$key]['dollar_price'] * $this->items[$key]['total_quantity'] ) -
                ( $this->items[$key]['total_quantity'] * $this->items[$key]['discount_price']);
        }
        else{
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
        }
        $this->computeForAll();
    }

    public function decrement($key){
        if($this->items[$key]['quantity'] > 1 ){
            $this->items[$key]['quantity']--;
            $this->items[$key]['total_quantity'] = $this->items[$key]['base_unit_multiplier']*  $this->items[$key]['quantity'] ;
            $this->items[$key]['sub_total']  =  ( $this->items[$key]['price'] * $this->items[$key]['total_quantity'] ) -
                ( $this->items[$key]['quantity'] * $this->items[$key]['discount_price']);
            $this->items[$key]['dollar_sub_total']  =  ( $this->items[$key]['dollar_price'] * $this->items[$key]['total_quantity'] ) -
                ( $this->items[$key]['total_quantity'] * $this->items[$key]['discount_price']);
        }

        $this->computeForAll();
    }

    public function delete_item($key)
    {
        unset($this->items[$key]);
        $this->computeForAll();
    }

    public function changePrice($key){
        if(!empty($this->items[$key]['price'])){
            $this->items[$key]['dollar_price'] = number_format($this->items[$key]['price'] / $this->items[$key]['exchange_rate'],2);
            $this->items[$key]['dollar_sub_total'] = number_format($this->num_uf($this->items[$key]['sub_total']) / $this->items[$key]['exchange_rate'],2);
            $this->items[$key]['sub_total'] = 0;
            $this->items[$key]['price'] = 0;
        }
        else{
            $this->items[$key]['price'] = number_format($this->num_uf($this->items[$key]['dollar_price']) * $this->items[$key]['exchange_rate'],2);
            $this->items[$key]['sub_total'] = $this->num_uf($this->items[$key]['dollar_sub_total'] * $this->items[$key]['exchange_rate']);
            $this->items[$key]['dollar_sub_total'] = 0;
            $this->items[$key]['dollar_price'] = 0;
        }
        $this->computeForAll();
    }

    public function resetAll()
    {
        $this->client_id = '';
        $this->reset();
    }

    public function ValidationAttributes(){
        return [
            'client_id' => __('اسم العميل'),
            'cash' => __('الدفع نقدا'),
        ];
    }

    public function subtotal($key){
        if($this->items[$key]['discount'] != 0){
            $discount = ProductPrice::where('id', $this->items[$key]['discount'])->get()->last();
            $this->items[$key]['discount_type'] = $discount->price_type;
            $this->items[$key]['discount_category'] = $discount->price_category;
            $price = $discount->price;
        }
        else
            $price = 0;

        $this->items[$key]['total_quantity'] = $this->items[$key]['base_unit_multiplier'] *  $this->items[$key]['quantity'] ;
        $this->items[$key]['discount_price'] = $price;
        $this->items[$key]['sub_total']  =  ( $this->items[$key]['price'] * $this->items[$key]['total_quantity'] ) -
            ( $this->items[$key]['total_quantity'] * $this->items[$key]['discount_price']);
        $this->items[$key]['dollar_sub_total']  =  ( $this->items[$key]['dollar_price'] * $this->items[$key]['total_quantity'] ) -
            ( $this->items[$key]['total_quantity'] * $this->items[$key]['discount_price']);


        $this->computeForAll();
    }
    // calculate dollar_final_total : "النهائي دولار"
    public function changeDollarTotal()
    {
        // dd("0000000000000000");

        //  "النهائي دولار"
        $this->dollar_final_total = $this->total_dollar - $this->discount_dollar;
        // Task : dollar_remaining : الباقي دولار
        $this->dollar_remaining = ($this->dollar_amount - $this->dollar_final_total);
    }
    // ++++++++++ When change in "الواصل دولار" : calculate dollar_remaining : "الباقي دولار" ++++++++++
    // public function changeReceivedDollar()
    // {
    //     // if 'النهائي دولار' has value and 'النهائي دينار' equal zero or null
    //    if( $this->dollar_amount!==null && $this->dollar_amount !==0 && $this->amount == 0 && $this->amount==null )
    //    {
    //         // Task : dollar_remaining : الباقي دولار = الواصل دولار - النهائي دولار
    //         $this->dollar_remaining = $this->dollar_amount - $this->dollar_final_total;
    //         // Task : dollar_remaining : الباقي دينار = الواصل دولار - النهائي دولار
    //         $this->dinar_remaining = parseFloat($this->dollar_remaining * System::getProperty('dollar_exchange')  - $this->final_total );
    //         dd( $this->final_total);
    //    }
    // }
    //
    // ++++++++++ When change in "الواصل دولار" : calculate dollar_remaining => "الواصل دولار" ++++++++++
    public function changeReceivedDollar()
    {
        // Check if 'الواصل دولار' has a value and 'الواصل دينار' is equal to zero or null
        if ($this->dollar_amount !== null && $this->dollar_amount !== 0 && ($this->amount == 0 || $this->amount == null))
        {
            // Calculate the remaining dollar amount
            $this->dollar_remaining = $this->dollar_final_total - $this->dollar_amount ;
            // Calculate the remaining dinar amount
            $dollar_exchange = System::getProperty('dollar_exchange');
            $this->dinar_remaining = $this->final_total - ($this->dollar_remaining * $dollar_exchange ) ;
        }
    }
    // ++++++++++ When change in "الواصل دينار" : calculate dinar_remaining : "الباقي دينار" ++++++++++
    // public function changeReceivedDinar()
    // {
    //     //   dd(00000000000000);
    //    // Task : dollar_remaining : الباقي دينار
    //    $this->dinar_remaining = $this->amount - $this->final_total;
    // }
    // ++++++++++ When change in "الواصل دينار" : calculate dinar_remaining : "الواصل دينار" ++++++++++
    public function changeReceivedDinar()
    {
        // Check if 'الواصل دولار' has a value and 'الواصل دينار' is equal to zero or null
        if ($this->amount !== null && $this->amount !== 0 && ($this->dollar_amount == 0 || $this->dollar_amount == null))
        {
            // Calculate the remaining dollar amount
            $this->dinar_remaining = $this->final_total - $this->amount;
            // Calculate the remaining dollar amount using the exchange rate
            $dollar_exchange = System::getProperty('dollar_exchange');
            $this->dollar_remaining = $this->dollar_final_total - ($this->dinar_remaining / $dollar_exchange);
        }
    }
    // calculate final_total : "النهائي دينار"
    public function changeTotal()
    {
        // "النهائي دينار"
        $this->final_total = $this->total - $this->discount;
        // Task : dollar_remaining : الباقي دينار
        $this->dinar_remaining = ($this->amount - $this->final_total);
    }

    public function ShowDollarCol(){
        $this->showColumn= !$this->showColumn;
    }

    public function quantityAvailable($product){
        $quantity_available = $product->stock_lines->sum('quantity') - $product->stock_lines->sum('quantity_sold');
        return $quantity_available;
    }

    public function getProductDiscount($sid){
        dd($sid);
        $product  = ProductPrice::where('product_id', $pid);
        if(isset($product)){
            $product->where(function($query){
                $query->where('price_start_date','<=',date('Y-m-d'));
                $query->where('price_end_date','>=',date('Y-m-d'));
                $query->orWhere('is_price_permenant',"1");
            })->get();

        }
        return $product->get();
    }

    public function getCurrentStock($product){
        $product_stocklines = $product->stock_lines;
        foreach ($product_stocklines as $stockline){
            $quantity_available =  $stockline->quantity - $stockline->quantity_sold  + $stockline->quantity_returned;
            if($quantity_available > 0)
            {
                return $stockline;
            }
        }
        return null;

    }

    public function getProductStores($product){
        $stores = ProductStore::where('product_id',$product->id)->get();
//        dd($stores->first()->store);
        return $stores;
    }

    public  function changeQuantity($key){
        if(!empty($this->items[$key]['store'])){
            $store = ProductStore::where('store_id', $this->items[$key]['store'])
                ->where('product_id',$this->items[$key]['product']['id'])->get()->first();
//        dd($store);
            $this->items[$key]['quantity_available'] = $store->quantity_available;
        }
    }

    public function generateInvoivceNumber($i = 1)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $inv_count = TransactionSellLine::all()->count() + $i;

        $invoice_no = 'Inv' . $year . $month . $inv_count;


        return $invoice_no;
    }
    public function updateSoldQuantityInAddStockLine($product_id, $store_id, $new_quantity, $old_quantity,$stock_id=null)
    {
        $product = Product::find($product_id);
        $qty_difference = $new_quantity - $old_quantity;
        if ($qty_difference != 0) {
            $add_stock_lines = AddStockLine::leftjoin('stock_transactions', 'add_stock_lines.stock_transaction_id', 'stock_transactions.id')
                ->where('stock_transactions.store_id', $store_id)
                ->where('product_id', $product_id)
                ->select('add_stock_lines.id', DB::raw('SUM(quantity - quantity_sold) as remaining_qty'))
                ->having('remaining_qty', '>', 0)
                ->groupBy('add_stock_lines.id')
                ->get();
            foreach ($add_stock_lines as $line) {
                if ($qty_difference == 0) {
                    return true;
                }

                if ($line->remaining_qty >= $qty_difference) {
                    $line->increment('quantity_sold', $qty_difference);
                    $qty_difference = 0;
                }
                if ($line->remaining_qty < $qty_difference) {
                    $line->increment('quantity_sold', $line->remaining_qty);
                    $qty_difference = $qty_difference - $line->remaining_qty;
                }
            }
        }

        return true;
    }
    public function updateTransactionPaymentStatus($transaction_id)
    {
        $transaction_payments = PaymentTransactionSellLine::where('transaction_id', $transaction_id)->get();

        $total_paid = $transaction_payments->sum('amount');
        $dollar_total_paid = $transaction_payments->sum('dollar_amount');

        $transaction = TransactionSellLine::find($transaction_id);
//        $returned_transaction = TransactionSellLine::where('return_parent_id',$transaction_id)->sum('final_total');
//        if($returned_transaction){
//            $final_amount = $transaction->final_total - $transaction->used_deposit_balance -  $returned_transaction;
//        }else{
            //  final_amount : 'النهائي بالدينار'
            $final_amount = $transaction->final_total ;
            //  dollar_final_amount : 'النهائي بالدولار'
            $dollar_final_amount = $transaction->dollar_final_total ;
            // dinar_remaining : الباقي دينار
            $dinar_remaining = ($total_paid - $final_amount);
            //  dollar_remaining : 'الباقي بالدولار'
            $dollar_remaining = ($dollar_total_paid - $dollar_final_amount) ;
//        }

        $payment_status = 'pending';
        if ($final_amount <= $total_paid && $dollar_final_amount <= $dollar_total_paid ) {
            $payment_status = 'paid';
        }
        elseif ($total_paid > 0 && $final_amount > $total_paid && $dollar_final_amount > $dollar_total_paid ) {
            $payment_status = 'partial';
        }
        $transaction->payment_status = $payment_status;
        $transaction->save();

        return $transaction;
    }
    public function addPayments($transaction, $payment, $type = 'credit', $user_id = null, $transaction_payment_id = null)
    {
        if (empty($user_id)) {
            $user_id = auth()->user()->id;
        }
        $register =  $this->getCurrentCashRegisterOrCreate($user_id);

        if ($transaction->type == 'returns') {
            $cr_transaction = CashRegisterTransaction::where('transaction_id', $transaction->id)->first();
            if (!empty($cr_transaction)) {
                $cr_transaction->update([
                    'amount' => $this->num_uf($payment['amount']),
                    'pay_method' => $payment['method'],
                    'type' => $type,
                    'transaction_type' => $transaction->type,
                    'transaction_id' => $transaction->id,
                    'transaction_payment_id' => $transaction_payment_id
                ]);

                return true;
            }
            else {
                CashRegisterTransaction::create([
                    'cash_register_id' => $register->id,
                    'amount' => $this->num_uf($payment['amount']),
                    'pay_method' =>  $payment['method'],
                    'type' => $type,
                    'transaction_type' => $transaction->type,
                    'transaction_id' => $transaction->id,
                    'transaction_payment_id' => $transaction_payment_id
                ]);
                return true;
            }
        }
        else {
            $payments_formatted[] = new CashRegisterTransaction([
                'amount' => $this->num_uf($payment['amount']),
                'pay_method' => $payment['method'],
                'type' => $type,
                'transaction_type' => $transaction->type,
                'transaction_id' => $transaction->id,
                'transaction_payment_id' => $transaction_payment_id
            ]);
        }
        //add to cash register pos return amount as sell amount
        if (!empty($pos_return_transactions)) {
            $payments_formatted[0]['amount'] = $payments_formatted[0]['amount'] + !empty($pos_return_transactions) ? number_format($pos_return_transactions->final_total,2) : 0;
        }

        if (!empty($payments_formatted) && !empty($register)) {
            $register->cash_register_transactions()->saveMany($payments_formatted);
        }

        return true;
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
                'store_id' => !empty($store_pos) ? $store_pos->store_id : null,
                'store_pos_id' => !empty($store_pos) ? $store_pos->id : null
            ]);
        }

        return $register;
    }
    public function decreaseProductQuantity($product_id, $store_id, $new_quantity, $old_quantity = 0)
    {
        $qty_difference = $new_quantity - $old_quantity;
        $product = Product::find($product_id);

            //Decrement Quantity in variations store table
            $details = ProductStore::where('product_id', $product_id)
                ->where('store_id', $store_id)
                ->first();

            //If store details not exists create new one
            if (empty($details)) {
                $details = ProductStore::create([
                    'product_id' => $product_id,
                    'store_id' => $store_id,
                    'quantity_available' => 0
                ]);
            }
            $details->decrement('quantity_available', $qty_difference);

        return true;
    }
    public function getInvoicePrint($transaction, $payment_types, $transaction_invoice_lang = null)
    {
        $print_gift_invoice = request()->print_gift_invoice;

        if (!empty($transaction_invoice_lang)) {
            $invoice_lang = $transaction_invoice_lang;
        } else {
            $invoice_lang = System::getProperty('invoice_lang');
            if (empty($invoice_lang)) {
                $invoice_lang = request()->session()->get('language');
            }
        }
//        $total_due= $this->getCustomerBalance($transaction->customer_id)['balance'];

        if ($invoice_lang == 'ar_and_en') {
            $html_content = view('sale_pos.partials.invoice_ar_and_end')->with(compact(
                'transaction',
                'payment_types',
                'print_gift_invoice',
//                'total_due',
            ))->render();
        } else {
            $html_content = view('invoices.partials.invoice')->with(compact(
                'transaction',
                'payment_types',
                'invoice_lang',
//                'total_due',
                'print_gift_invoice'
            ))->render();
        }

        if ($transaction->is_direct_sale == 1) {
            $sale = $transaction;
            $payment_type_array = $payment_types;
            $html_content = view('sale_pos.partials.commercial_invoice')->with(compact(
                'sale',
                'payment_type_array',
                'invoice_lang',
//                'total_due',
                'print_gift_invoice',
            ))->render();
        }

        if ($transaction->is_quotation == 1 && $transaction->status == 'draft') {
            $sale = $transaction;
            $payment_type_array = $payment_types;
            $html_content = view('sale_pos.partials.commercial_invoice')->with(compact(
                'sale',
                'payment_type_array',
                'invoice_lang'
            ))->render();
        }

        return $html_content;
    }
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }
    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
//            'cheque' => __('lang.cheque'),
//            'deposit' => __('lang.use_the_balance'),
//            'paypal' => __('lang.paypal'),
        ];
    }

}
