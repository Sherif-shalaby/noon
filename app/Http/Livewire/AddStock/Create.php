<?php

namespace App\Http\Livewire\AddStock;

use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $selectedProducts = [], $selectedProductData = [], $quantity = [], $purchase_price =[], $selling_price = [],
        $base_unit = [], $divide_costs , $other_expenses = 0, $other_payments = 0, $total_size = [], $total_weight =[],
        $cost = [], $total_cost = [], $sub_total = [], $change_price_stock =[], $store_id, $status, $order_date,
        $purchase_type, $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $exchange_rate,
        $amount, $method, $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date,
        $dollar_purchase_price = [], $dollar_selling_price =[], $dollar_sub_total = [], $dollar_cost = [], $dollar_total_cost = [],
        $showColumn = false, $transaction_currency, $current_stock, $clear_all_input_stock_form ;

    protected $rules = [
    'store_id' => 'required',
    'supplier' => 'required',
    'status' => 'required',
    'paying_currency' => 'required',
    'purchase_type' => 'required',
    'payment_status' => 'required',
    'method' => 'required',
    'amount' => 'required',
    'transaction_currency' => 'required'
];

    public function render(): Factory|View|Application
    {
        $this->clear_all_input_stock_form = System::getProperty('clear_all_input_stock_form');
        if($this->clear_all_input_stock_form ==0){
            $transaction_payment=[];
            $recent_stock=[];
        }else{
            $recent_stock = StockTransaction::where('type','add_stock')->orderBy('created_at', 'desc')->first();
//dd($recent_stock);
            if(!empty($recent_stock)){
                $transaction_payment = $recent_stock->transaction_payments->first();
                $this->store_id =$recent_stock->store_id;
                $this->supplier = $recent_stock->supplier_id;
                $this->status = $recent_stock->status;
                $this->transaction_date = $recent_stock->transaction_date;
                $this->transaction_currency = $recent_stock->transaction_currency;
                $this->purchase_type = $recent_stock->purchase_type;
                $this->divide_costs = $recent_stock->divide_costs;
                $this->payment_status = $recent_stock->payment_status;
                $this->invoice_no = $recent_stock->invoice_no;
                $this->other_expenses = $recent_stock->other_expenses;
                $this->discount_amount = $recent_stock->discount_amount;
                $this->other_payments = $recent_stock->other_payments;
                $this->amount = $transaction_payment->amount;
                $this->method = $transaction_payment->method;
                $this->paying_currency = $transaction_payment->paying_currency;
                $this->source_type =$transaction_payment->source_type;
                $this->source_id = $transaction_payment->source_id;
                $this->paid_on = $transaction_payment->paid_on;



            }
        }

        $status_array = $this->getPurchaseOrderStatusArray();
        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $product_id = request()->get('product_id');
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        $products = Product::all();
        $stores = Store::getDropdown();

        if ($this->source_type == 'pos') {
            $users = StorePos::pluck('name', 'id');
        } elseif ($this->source_type == 'store') {
            $users = Store::pluck('name', 'id');
        } elseif ($this->source_type == 'safe') {
            $users = MoneySafe::pluck('name', 'id');
        } else {
            $users = User::Notview()->pluck('name', 'id');
        }

        $this->changeExchangeRate();


        return view('livewire.add-stock.create',
            compact('status_array',
            'payment_status_array',
            'payment_type_array',
            'stores',
            'product_id',
            'payment_types',
            'payment_status_array',
            'suppliers',
            'selected_currencies',
            'preparers' ,
            'products',
            'users'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store(): Redirector|Application|RedirectResponse
    {
        if (!empty($this->other_expenses) || !empty($this->other_payments)){
            $this->rules = [
                'store_id' => 'required',
                'supplier' => 'required',
                'status' => 'required',
                'paying_currency' => 'required',
                'purchase_type' => 'required',
                'divide_costs' => 'required',
                'payment_status' => 'required',
                'method' => 'required',
                'amount' => 'required',
            ];
        }

        $this->validate();

        try {

            // Add stock transaction
            $transaction = new StockTransaction();
            $transaction->store_id = $this->store_id;
            $transaction->status = $this->status;
            $transaction->order_date = !empty($this->order_date) ? $this->order_date : Carbon::now();
            $transaction->transaction_date = !empty($this->transaction_date) ? $this->transaction_date : Carbon::now();
            $transaction->purchase_type = $this->purchase_type;
            $transaction->type = 'add_stock';
            $transaction->invoice_no = !empty($this->invoice_no) ? $this->invoice_no : null;
            $transaction->discount_amount = !empty($this->discount_amount) ? $this->discount_amount : 0;
            $transaction->supplier_id = $this->supplier;
            $transaction->transaction_currency = $this->transaction_currency;
            $transaction->payment_status = $this->payment_status;
            $transaction->other_payments = !empty($this->other_payments) ? $this->other_payments : 0;
            $transaction->other_expenses = !empty($this->other_expenses) ? $this->other_expenses : 0;
            $transaction->grand_total = array_sum($this->total_cost);
            $transaction->final_total = isset($this->discount_amount) ? (array_sum($this->total_cost) - $this->discount_amount) : array_sum($this->total_cost);
            $transaction->dollar_grand_total = $this->sum_dollar_total_cost();
            $transaction->dollar_final_total = $this->dollar_final_total();
            $transaction->notes = !empty($this->notes) ? $this->notes : null;
            $transaction->notify_before_days = !empty($this->notify_before_days) ? $this->notify_before_days : 0;
            $transaction->notify_me = !empty($this->notify_before_days) ? 1 : 0;
            $transaction->created_by = Auth::user()->id;
            $transaction->source_id = !empty($this->source_id) ? $this->source_id : null;
            $transaction->source_type = !empty($this->source_type) ? $this->source_type : null;
            $transaction->due_date = !empty($this->due_date) ? $this->due_date : null;
            $transaction->divide_costs = !empty($this->divide_costs) ? $this->divide_costs : null;

            DB::beginTransaction();
            // preparer_id
            // $transaction->preparer_id = !empty($this->preparer_id) ? $this->preparer_id : null;

            $transaction->save();


            // Add payment transaction
            if(!empty($this->amount)){
                $payment  = new StockTransactionPayment();
                $payment->stock_transaction_id  = $transaction->id;
                $payment->amount  = $this->amount;
                $payment->method = $this->method;
                $payment->paid_on = !empty($this->paid_on) ? $this->paid_on :  Carbon::now() ;
                $payment->source_type = !empty($this->source_type) ? $this->source_type : null;
                $payment->source_id = !empty($this->source_id) ? $this->source_id : null;
                $payment->payment_note =!empty($this->notes) ? $this->notes : null;
                $payment->created_by = Auth::user()->id;
                $payment->exchange_rate = $this->exchange_rate;
                $payment->paying_currency = $this->paying_currency;

                // check user and add money to user
                if  ($payment->method == 'cash'){
                    $user_id = null;
                    if (!empty($this->source_id)) {
                        if ($this->source_type == 'pos') {
                            $user_id = StorePos::where('id', $this->source_id)->first()->user_id;
                        }
                        if ($this->source_type == 'user') {
                            $user_id = $this->source_id;
                        }
                        if ($this->source_type == 'safe') {
                            $money_safe = MoneySafe::find($this->source_id);
                            $money_safe_Date = [
                                'created_by' => Auth::user()->id,
                                'type' => 'debit',
                                'source_type' => 'safe',
                                'source_id' => $this->source_id,
                                'store_id' =>  $this->store_id,
                                'transaction_date' => !empty($this->transaction_date) ? $this->transaction_date : Carbon::now(),
                                'currency_id' => $this->paying_currency,
                                'amount' => $this->amount,
                                'money_safe_id' => $money_safe->id,
                            ];
                            $transaction= $money_safe->transactions()->latest()->first();
                            if(!empty($transaction->balance)){
                                $money_safe_Date['balance'] = $money_safe_Date['amount'] + $transaction->balance;
                            }else{
                                $money_safe_Date['balance'] = $money_safe_Date['amount'];
                            }
                            MoneySafeTransaction::create($money_safe_Date);
                        }
                    }
                    if(!empty($user_id)){
                        $register =  $this->getCurrentCashRegisterOrCreate($user_id);
                        if (!empty($user_id)) {
                            $payments_formatted[] = new CashRegisterTransaction([
                                'amount' => $this->amount,
                                'pay_method' => $this->method,
                                'type' => 'debit',
                                'transaction_type' => 'add_stock',
                                'transaction_id' => $transaction->id,
                                'transaction_payment_id' => null
                            ]);
                        }
                        if (!empty($payments_formatted) && !empty($register)) {
                            $register->cash_register_transactions()->saveMany($payments_formatted);
                        }
                    }
                }
                $payment->save();
            }


            // add  products to stock lines
            foreach ($this->selectedProductData as $index => $product){
                if (isset($this->change_price_stock[$index]) && $this->change_price_stock[$index]) {
                    if (isset($product->stock_lines)) {
                        foreach ($product->stock_lines as $line) {
                            $line->purchase_price = !empty($this->purchase_price[$index]) ? $this->purchase_price[$index] : null;
                            $line->sell_price = !empty($this->selling_price[$index]) ? $this->selling_price[$index] : null;
                            $line->dollar_purchase_price = empty($this->dollar_purchase_price[$index]) ? $this->dollar_purchase_price[$index] : null;
                            $line->dollar_sell_price = !empty($this->dollar_selling_price[$index]) ? $this->dollar_selling_price[$index] : null;
                            $line->save();
                        }
                    }
                }
                $supplier = Supplier::find($this->supplier);
                $add_stock_data = [
                    'product_id' => $product->id,
                    'stock_transaction_id' =>$transaction->id ,
                    'quantity' => $this->quantity[$index],
                    'purchase_price' => !empty($this->purchase_price[$index]) ? $this->purchase_price[$index] : null ,
                    'final_cost' => !empty($this->total_cost[$index]) ? $this->total_cost[$index] : null,
                    'sub_total' => !empty($this->sub_total[$index]) ? $this->sub_total[$index] : null,
                    'sell_price' => !empty($this->selling_price[$index]) ? $this->selling_price[$index] : null,
                    'dollar_purchase_price' => !empty($this->dollar_purchase_price[$index]) ? $this->dollar_purchase_price[$index] : null,
                    'dollar_final_cost' => !empty($this->dollar_total_cost[$index]) ? $this->dollar_total_cost[$index] : 0,
                    'dollar_sub_total' => !empty($this->dollar_sub_total($index)) ? $this->dollar_sub_total($index) : null,
                    'dollar_sell_price' => !empty($this->dollar_selling_price[$index]) ? $this->dollar_selling_price[$index] : null,
                    'cost' => !empty($this->cost[$index]) ?  $this->cost[$index] : null,
                    'dollar_cost' => !empty($this->dollar_cost[$index]) ? $this->dollar_cost[$index] : null,
                    'exchange_rate' => !empty($supplier->exchange_rate) ? str_replace(',' ,'',$supplier->exchange_rate) : null,
                ];
                AddStockLine::create($add_stock_data);
                $this->updateProductQuantityStore($product->id, $transaction->store_id,  $this->quantity[$index], 0);

            }

            DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'lang.success',]);
        }
        catch (\Exception $e){
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
        return redirect('/add-stock/create');
    }

    public function fetchSelectedProducts()
    {
        $this->emit('closeModal');
        $this->selectedProductData = Product::whereIn('id', $this->selectedProducts)->get();

    }

    public function get_product($index){
        return Product::where('id' ,$this->selectedProductData[$index]->id)->first();
    }

    public function sub_total($index)
    {
        if(isset($this->quantity[$index]) && (isset($this->purchase_price[$index]) ||isset($this->dollar_purchase_price[$index]) )){
            // convert purchase price from Dollar To Dinar
            $purchase_price = $this->convertDollarPrice($index);

            if(isset($this->get_product($index)->unit->base_unit_multiplier)){
                $this->base_unit[$index] = $this->get_product($index)->unit->base_unit_multiplier;
            }
            else{
                $this->base_unit[$index] = 1;
            }
            $this->sub_total[$index] = (int)$this->quantity[$index] * (float)$purchase_price * $this->base_unit[$index];

            return number_format($this->sub_total[$index], 2);
        }
    }

    public function dollar_sub_total($index)
    {
        if(isset($this->quantity[$index]) && (isset($this->dollar_purchase_price[$index]) || isset($this->purchase_price[$index]))){
            // convert purchase price from Dinar To Dollar
            $purchase_price = $this->convertDinarPrice($index);
            if(isset($this->get_product($index)->unit->base_unit_multiplier)){
                $this->base_unit[$index] = $this->get_product($index)->unit->base_unit_multiplier;
            }
            else{
                $this->base_unit[$index] = 1;
            }
            $this->dollar_sub_total[$index] = (int)$this->quantity[$index] * (float)$purchase_price * $this->base_unit[$index];

            return number_format($this->dollar_sub_total[$index], 2);
        }
        else{
            $this->quantity[$index] = 0;
            $this->dollar_purchase_price[$index] = 0;
        }
    }

    public function total_quantity($index){
        if (isset($this->get_product($index)->unit->base_unit_multiplier)){
            return  $this->get_product($index)->unit->base_unit_multiplier * (int)$this->quantity[$index];
        }
        else{
            return  (int)$this->quantity[$index];
        }

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

        if($this->paying_currency == 2){
            $cost = ( (float)$this->other_expenses + (float)$this->other_payments ) * $this->exchange_rate;
        }
        else{
            $cost = (float)$this->other_expenses + (float)$this->other_payments ;
        }
        // convert purchase price from Dollar To Dinar
        $purchase_price = $this->convertDollarPrice($index);
//        dd($purchase_price);


        if (isset($this->divide_costs)){

            if ($this->divide_costs == 'size'){
                if($this->sum_size() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_sizes_less_equal_zero']);
                    unset($this->divide_costs);
                }
                else{
                    (float)$this->cost[$index] = ( ( $cost / $this->sum_size() ) * $product->size ) + (float)$purchase_price;
                }
            }
            elseif ($this->divide_costs == 'weight'){
                if($this->sum_weight() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_weights_less_equal_zero']);
                    unset($this->divide_costs);

                }
                else {
                    (float)$this->cost[$index] = (($cost / $this->sum_weight()) * $product->weight) + (float)$purchase_price;
                }
            }
            else{
                (float)$this->cost[$index] = ( ( $cost / array_sum($this->sub_total) ) * (float)$purchase_price ) + (float)$purchase_price;
            }
        }
        else{
            $this->cost[$index] = (float)$purchase_price;
        }

        return number_format($this->cost[$index],2);
    }

    public function total_cost($index){
        $this->total_cost[$index] = (float)$this->cost[$index] * $this->total_quantity($index);
        return number_format($this->total_cost[$index],2) ;
}

    public function dollar_cost($index){

        $product = $this->get_product($index);

        if($this->paying_currency == 2){
            $dollar_cost = ( (float)$this->other_expenses + (float)$this->other_payments ) * $this->exchange_rate;
        }
        else{
            $dollar_cost = (float)$this->other_expenses + (float)$this->other_payments ;
        }
        // convert purchase price from Dinar to Dollar
       $purchase_price = $this->convertDinarPrice($index);
//        dd($purchase_price);


        if (isset($this->divide_costs)){

            if ($this->divide_costs == 'size'){
                if($this->sum_size() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_sizes_less_equal_zero']);
                    unset($this->divide_costs);
                }
                else{
                    (float)$this->cost[$index] = ( ( $dollar_cost / $this->sum_size() ) * $product->size ) + (float)$purchase_price;
                }
            }
            elseif ($this->divide_costs == 'weight'){
                if($this->sum_weight() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_weights_less_equal_zero']);
                    unset($this->divide_costs);

                }
                else {
                    (float)$this->dollar_cost[$index] = (($dollar_cost / $this->sum_weight()) * $product->weight) + (float)$purchase_price;
                }
            }
            else{
                (float)$this->dollar_cost[$index] = ( ( $dollar_cost / array_sum($this->sub_total) ) * (float)$purchase_price ) + (float)$purchase_price;
            }
        }
        else{
            $this->dollar_cost[$index] = (float)$purchase_price;
        }
        return number_format($this->dollar_cost[$index],2);
    }

    public function dollar_total_cost($index){
        $this->dollar_total_cost[$index] = $this->dollar_cost[$index] * $this->total_quantity($index);
        return number_format($this->dollar_total_cost[$index], 2);

    }

    public function sum_total_cost(){
        return number_format(array_sum($this->total_cost),2);
    }

    public function sum_dollar_total_cost(){
        return number_format(array_sum($this->dollar_total_cost),2);
    }

    public function sum_sub_total(){
        return number_format(array_sum($this->sub_total),2);
    }

    public function sum_dollar_tsub_total(){
        return number_format(array_sum($this->dollar_sub_total),2);
    }

    public function final_total(){
        if(isset($this->discount_amount)){
            return $this->sum_total_cost() - $this->discount_amount;
        }
        else
            return $this->sum_total_cost();
    }

    public function dollar_final_total(){
        if(isset($this->discount_amount)){
            return $this->sum_dollar_total_cost() - $this->discount_amount;
        }
        else
            return $this->sum_dollar_total_cost();
    }

    public function delete_product($index){
        unset($this->selectedProducts[$index]);
        unset($this->selectedProductData[$index]);
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
                'store_pos_id' => !empty($store_pos) ? $store_pos->id : null
            ]);
        }

        return $register;
    }

    public function convertDollarPrice($index){
        if(empty($this->purchase_price[$index]) && !empty($this->dollar_purchase_price[$index])){
            (float)$purchase_price = (float)$this->dollar_purchase_price[$index] * $this->exchange_rate;
        }
        else{
            $purchase_price = $this->purchase_price[$index];
        }
        return $purchase_price;
    }

    public function convertDinarPrice($index)
    {
//        dd($this->purchase_price[$index]);
        if (!empty($this->purchase_price[$index]) && empty($this->dollar_purchase_price[$index])) {
            $purchase_price = $this->purchase_price[$index] / $this->exchange_rate;
        }
        else {
            $purchase_price = $this->dollar_purchase_price[$index];
        }
        return $purchase_price;

    }

    public function changeExchangeRate(){
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

    public function ShowDollarCol(){
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


}
