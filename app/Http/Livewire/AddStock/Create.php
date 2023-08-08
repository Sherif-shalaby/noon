<?php

namespace App\Http\Livewire\AddStock;

use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Currency;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\Product;
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
use Livewire\Component;

class Create extends Component
{
    public $selectedProducts = []; public $selectedProductData = []; public $quantity = []; public $purchase_price =[];
    public $selling_price = []; public $base_unit = []; public $divide_costs ;  public $other_expenses = 0;
    public $other_payments = 0; public $total_size = []; public $total_weight =[]; public $cost = [];
    public $total_cost = []; public $sub_total = []; public $change_price_stock =[]; public $store_id;
    public $status; public $order_date; public $purchase_type; public $invoice_no; public $discount_amount;
    public $source_type; public $payment_status; public $source_id; public $supplier; public $exchange_rate;
    public $amount; public $method; public $paid_on; public $paying_currency; public $transaction_date;
    public $notes; public $notify_before_days; public $due_date; public $dollar_purchase_price = []; public $dollar_selling_price =[];
    public $dollar_sub_total = []; public $dollar_cost = []; public $dollar_total_cost = [];

    protected $rules = [
    'store_id' => 'required',
    'supplier' => 'required',
    'status' => 'required',
    'paying_currency' => 'required',
    'purchase_type' => 'required',
    'payment_status' => 'required',
    'method' => 'required',
    'amount' => 'required',
];

    public function render(): Factory|View|Application
    {
        $status_array = $this->getPurchaseOrderStatusArray();
        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $product_id = request()->get('product_id');
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
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
        if (isset($this->supplier)){
            $supplier = Supplier::find($this->supplier);
            if(isset($supplier->exchange_rate)){
                $this->exchange_rate =  number_format($supplier->exchange_rate ,2);
            }
        }
        else{
            $this->exchange_rate =System::getProperty('dollar_exchange');
        }


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
            $transaction->invoice_no = !empty($this->invoice_no) ? $this->invoice_no : null;
            $transaction->discount_amount = !empty($this->discount_amount) ? $this->discount_amount : 0;
            $transaction->supplier_id = $this->supplier;
            $transaction->paying_currency = $this->paying_currency;
            $transaction->payment_status = $this->payment_status;
            $transaction->other_payments = !empty($this->other_payments) ? $this->other_payments : 0;
            $transaction->other_expenses = !empty($this->other_expenses) ? $this->other_expenses : 0;
            $transaction->grand_total = $this->sum_total_cost();
            $transaction->final_total = $this->final_total();
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
            $transaction->save();

            // Add payment transaction
            $payment  = new StockTransactionPayment();
            $payment->transaction_id  = $transaction->id;
            $payment->amount  = $this->amount;
            $payment->method = $this->method;
            $payment->paid_on = !empty($this->paid_on) ? $this->paid_on :  Carbon::now() ;
            $payment->source_type = !empty($this->source_type) ? $this->source_type : null;
            $payment->source_id = !empty($this->source_id) ? $this->source_id : null;
            $payment->payment_note =!empty($this->notes) ? $this->notes : null;
            $payment->created_by = Auth::user()->id;
            $payment->exchange_rate = $this->exchange_rate;

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

            // add  products to stock lines
            foreach ($this->selectedProductData as $index => $product){
                $add_stock_data = [
                    'product_id' => $product->id,
                    'transaction_id' =>$transaction->id ,
                    'quantity' => $this->quantity[$index],
                    'purchase_price' => $this->purchase_price[$index],
                    'final_cost' => $this->total_cost[$index],
                    'sub_total' => $this->sub_total($index),
                    'sell_price' => $this->selling_price[$index],
                    'dollar_purchase_price' => $this->dollar_purchase_price[$index],
                    'dollar_final_cost' => $this->dollar_total_cost[$index],
                    'dollar_sub_total' => $this->dollar_sub_total($index),
                    'dollar_sell_price' => $this->dollar_selling_price[$index],
                    'cost' => $this->cost($index),
                    'dollar_cost' => $this->dollar_cost($index),
                ];
                AddStockLine::create($add_stock_data);
            }

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'lang.success',]);
        }
        catch (\Exception $e){
//
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
        return redirect('/add-stock/index');
    }

    public function fetchSelectedProducts()
    {
        $this->emit('closeModal');
        $this->selectedProductData = Product::whereIn('id', $this->selectedProducts)->get();
//        dump($this->selectedProductData);
    }

    public function get_product($index){
        return Product::where('id' ,$this->selectedProductData[$index]->id)->first();
    }

    public function sub_total($index)
    {
        if(isset($this->quantity[$index]) && isset($this->purchase_price[$index])){
            if(isset($this->get_product($index)->unit->base_unit_multiplier)){
                $this->base_unit[$index] = $this->get_product($index)->unit->base_unit_multiplier;
            }
            else{
                $this->base_unit[$index] = 1;
            }
            $this->sub_total[$index] = (int)$this->quantity[$index] * (float)$this->purchase_price[$index] * $this->base_unit[$index];

            return number_format($this->sub_total[$index], 2);
        }
        else{
            $this->quantity[$index] = 0;
            $this->purchase_price[$index] = 0;
        }
    }

    public function dollar_sub_total($index)
    {
        if(isset($this->quantity[$index]) && isset($this->dollar_purchase_price[$index])){
            if(isset($this->get_product($index)->unit->base_unit_multiplier)){
                $this->base_unit[$index] = $this->get_product($index)->unit->base_unit_multiplier;
            }
            else{
                $this->base_unit[$index] = 1;
            }
            $this->dollar_sub_total[$index] = (int)$this->quantity[$index] * (float)$this->dollar_purchase_price[$index] * $this->base_unit[$index];

            return number_format($this->dollar_sub_total[$index], 2);
        }
        else{
            $this->quantity[$index] = 0;
            $this->dollar_purchase_price[$index] = 0;
        }
    }

    public function change_purchase_price($index){
        $this->purchase_price[$index] = $this->dollar_purchase_price[$index] * $this->exchange_rate;
    }

    public function change_selling_price($index){
        $this->selling_price[$index] = $this->dollar_selling_price[$index] * $this->exchange_rate;
    }

    public function change_dollar_purchase_price($index){
        $this->dollar_purchase_price[$index] = $this->purchase_price[$index] / $this->exchange_rate;
    }

    public function change_dollar_selling_price($index){
        $this->dollar_selling_price[$index] = $this->selling_price[$index] / $this->exchange_rate;
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

        if (isset($this->divide_costs)){
            if ($this->divide_costs == 'size'){
                (float)$this->cost[$index] = ( ( $cost / $this->sum_size() ) * $product->size ) + (float)$this->purchase_price[$index];
            }
            elseif ($this->divide_costs == 'weight'){
                (float)$this->cost[$index] = ( ( $cost / $this->sum_weight() ) * $product->weight ) + (float)$this->purchase_price[$index];
            }
            else{
                (float)$this->cost[$index] = ( ( $cost / array_sum($this->sub_total) ) * (float)$this->purchase_price[$index] ) + (float)$this->purchase_price[$index];
            }
        }
        else{
            $this->cost[$index] = (float)$this->purchase_price[$index];
        }


        return number_format($this->cost[$index],2);
    }

    public function total_cost($index){
        $this->total_cost[$index] = (float)$this->cost[$index] * $this->total_quantity($index);
        return number_format($this->total_cost[$index],2) ;
    }

    public function dollar_cost($index){

        $product = $this->get_product($index);
        if($this->paying_currency != 2){
            $cost = ( (float)$this->other_expenses + (float)$this->other_payments ) / $this->exchange_rate;
        }
        else{
            $cost = (float)$this->other_expenses + (float)$this->other_payments ;
        }
        if (isset($this->divide_costs)){
            if ($this->divide_costs == 'size'){
                (float)$this->dollar_cost[$index] = ( ( $cost / $this->sum_size() ) * $product->size ) + (float)$this->dollar_purchase_price[$index];
            }
            elseif ($this->divide_costs == 'weight'){
                (float)$this->dollar_cost[$index] = ( ( $cost / $this->sum_weight() ) * $product->weight ) + (float)$this->dollar_purchase_price[$index];
            }
            else{
                (float)$this->dollar_cost[$index] = ( ( $cost / array_sum($this->dollar_sub_total) ) * (float)$this->dollar_purchase_price[$index] ) + $this->dollar_purchase_price[$index];
            }
        }
        else{
            $this->dollar_cost[$index] = (float)$this->dollar_purchase_price[$index];
        }


        return number_format($this->dollar_cost[$index],2);
    }

    public function dollar_total_cost($index){
        $this->dollar_total_cost[$index] = $this->dollar_cost[$index] * $this->total_quantity($index);
        return number_format($this->dollar_total_cost[$index],2) ;
    }

    public function sum_total_cost(){
        return number_format(array_sum($this->total_cost));
    }

    public function sum_dollar_total_cost(){
        return number_format(array_sum($this->dollar_total_cost));
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

}
