<?php

namespace App\Http\Livewire\Invoices;

use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\EarningOfPoint;
use App\Models\Invoice;
use App\Models\MoneySafeTransaction;
use App\Models\PaymentTransactionSellLine;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\RedemptionOfPoint;
use App\Models\SellLine;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\System;
use App\Models\TransactionPayment;
use App\Models\TransactionSellLine;
use App\Models\Variation;
use App\Utils\pos;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $products = [], $department_id = null, $items = [], $price  ,$total = 0, $client_phone,
        $client_id, $client, $not_paid, $cash = 0, $rest, $invoice,$invoice_id, $date,
        $payments_amount, $data = [], $payments = [], $invoice_lang, $transaction_currency, $store_id, $store_pos_id,
        $showModal = false, $showColumn = false, $anotherPayment = false, $sale_note, $payment_note, $staff_note,$payment_types,
        $discount = 0.00, $total_after_discount = 0.00;

    protected $rules = [
//            'items' => 'min:1',
//            'price' => 'required',
//            'total' => 'required',
//            'rest' => 'nullable|numeric',
            'client_id' => 'required',
            'store_id' => 'required',
            'store_pos_id' => 'required',
            'transaction_currency' => 'required',
            'invoice_lang' => 'required',
    ];



    public function mount(Util $commonUtil)
    {
        $this->payment_types = $commonUtil->getPaymentTypeArrayForPos();
        $this->department_id = null;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $allproducts = Product::get();
        $departments = Category::get();
        $customers   = Customer::get();
        $store_pos = StorePos::where('user_id', Auth::user()->id)->pluck('name','id');
        $store_poses = [];
        $languages = System::getLanguageDropdown();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $stores = Store::getDropdown();
        if (empty($store_pos)) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.kindly_assign_pos_for_that_user_to_able_to_use_it']);
            return redirect()->to('/home');
        }

        return view('livewire.invoices.create', compact(
            'departments',
            'allproducts',
            'customers',
            'store_poses',
            'store_pos',
            'languages',
            'selected_currencies',
            'stores',
            ));
    }

    public function submit($status = null){
        try {
            // Add Transaction Sell Line
            $transaction_data = [
                'store_id' => $this->store_id,
                'customer_id' => $this->client_id,
                'store_pos_id' => $this->store_pos_id,
                'exchange_rate' => 0,
                'transaction_currency' => $this->transaction_currency,
                'final_total' => $this->num_uf($this->total),
                'grand_total' => $this->num_uf($this->price),
                'transaction_date' => Carbon::now(),
                'invoice_no' => $this->generateInvoivceNumber(),
                'status' => 'final',
                'payment_status' => 'pending',
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
//                $sell_line->tax_id = !empty($item['tax_id']) ? $item['tax_id'] : null;
//                $sell_line->tax_method = !empty($item['tax_method']) ? $item['tax_method'] : null;
//                $sell_line->tax_rate = !empty($item['tax_rate']) ? $this->num_uf($item['tax_rate']) : 0;
//                $sell_line->item_tax = !empty($item['item_tax']) ? $this->num_uf($item['item_tax']) : 0;
                $sell_line->save();
                $keep_sell_lines[] = $sell_line->id;

                $stock_id = $item['current_stock']['id'];

                // Update Sold Quantity in stock line
                $this->updateSoldQuantityInAddStockLine($sell_line->product_id, $transaction->store_id, (float)$item['quantity'], $old_quantity, $stock_id);

            }

            // Add Payment Method
            if (!empty($this->payments)) {
                $payment_formated = [];

                foreach ($this->payments as $payment) {
                    $old_tp = null;
                    $payment_data = [
                        'transaction_id' => $transaction->id,
                        'amount' => $payment['amount'],
                        'method' => $payment['method'],
                        'paid_on' => !empty($payment['paid_on']) ? Carbon::createFromTimestamp(strtotime($payment['paid_on']))->format('Y-m-d H:i:s') : Carbon::now(),
                        'payment_note' => $this->payment_note,
                        'received_currency' => $payment['received_currency'],
                        'exchange_rate' => 0,
                    ];
                    if ($payment['amount'] > 0) {
                        $transaction_payment = null;
                        if (!empty($payment_data['amount'])) {
                            $payment_data['created_by'] = Auth::user()->id;
                            $payment_data['payment_for'] =  $transaction->customer_id;
                            $transaction_payment = PaymentTransactionSellLine::create($payment_data);
                        }
                    }
                    $this->updateTransactionPaymentStatus($transaction->id);

                    $this->addPayments($transaction, $payment_data, 'credit', null, $transaction_payment->id);
                }
            }
            DB::commit();
            $payment_types = $this->getPaymentTypeArrayForPos();
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم إضافة الفاتورة بنجاح']);
//            $html_content = $this->getInvoicePrint($transaction, $payment_types, $this->invoice_lang);

            return $this->redirect('/invoices/create');

        } catch(\Exception $e){
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);
            dd($e);
        }

//
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
        $this->products = $department_id > 0? Product::where('category_id', $department_id)->get() : Product::get();
    }

    public function add_product($id){

        $product = Product::find($id);
        $quantity_available = $this->quantityAvailable($product);
        if ( $quantity_available < 1) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
        }

        else {
            $current_stock = $this->getCurrentStock($product);
            $exchange_rate = $this->getProductExchangeRate($current_stock);
            $product_price = $this->getProductPrice($current_stock,$exchange_rate);
            $discount = $this->getProductDiscount($id);
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
//                dd( $product->unit->name);
                $this->items[] = [
                    'product' => $product,
                    'quantity' => 1,
                    'price' => $product_price,
                    'category_id' => $product->category?->id,
                    'department_name' => $product->category?->name,
                    'client_id' => $product->customer?->id,
                    'exchange_rate' => $exchange_rate,
                    'quantity_available' => $quantity_available,
                    'sub_total' => $product->unit->base_unit_multiplier * $product_price,
                    'current_stock' => $current_stock,
                    'discount_categories' =>  $discounts,
                    'discount' => null,
                    'discount_price' => 0,
                    'discount_type' =>  null,
                    'discount_category' =>  null,
                    'dollar_price' => $product_price / $exchange_rate,
                    'unit_name' => $product->unit->name,
                    'base_unit_multiplier' => $product->unit->base_unit_multiplier,
                    'total_quantity' => 1 * $product->unit->base_unit_multiplier
                ];
//                dd($this->items[0]['unit_name']);

            }
        }
        $this->computeForAll();
    }

    public function computeForAll()
    {
        $this->price = 0;
        foreach($this->items as $item){
            $this->price += $item['sub_total'];
        }
        $this->total = $this->price;
        $this->payments[0]['amount'] = $this->total;
        $this->payments[0]['method'] = 'cash';
        $this->rest  = 0;
    }

    public function increment($key){

        if ($this->items[$key]['quantity'] < $this->items[$key]['quantity_available']) {
            $this->items[$key]['quantity']++;

            $this->items[$key]['total_quantity'] = $this->items[$key]['base_unit_multiplier']*  $this->items[$key]['quantity'] ;
            $this->items[$key]['sub_total']  =  ( $this->items[$key]['price'] * $this->items[$key]['total_quantity'] ) -
                ( $this->items[$key]['quantity'] * $this->items[$key]['discount_price']);
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
        }

        $this->computeForAll();
    }

    public function delete_item($key)
    {
        unset($this->items[$key]);
        $this->computeForAll();
    }

    public function resetAll()
    {
        $this->client_id = '';
        $this->reset();
        $this->mount();
    }

    public function ValidationAttributes(){
        return [
            'client_id' => __('اسم العميل'),
            'cash' => __('الدفع نقدا'),
        ];
    }

    public function showModal(){
        $this->validate();

        $this->showModal = true;
    }

    public function closeModal(){
        $this->showModal = false;
    }

    public function updatedCash()
    {
        if ($this->cash) {
            //$this->computeForAll();
            $this->cash = $this->cash == "" ? 0 : $this->cash;
            $this->rest =  $this->total - $this->cash;
        } else {
            $this->rest =  $this->total;
        }
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

        $this->items[$key]['total_quantity'] = $this->items[$key]['base_unit_multiplier']*  $this->items[$key]['quantity'] ;
        $this->items[$key]['discount_price'] = $price;
        $this->items[$key]['sub_total']  =  ( $this->items[$key]['price'] * $this->items[$key]['total_quantity'] ) -
            ( $this->items[$key]['total_quantity'] * $this->items[$key]['discount_price']);

        $this->computeForAll();
    }

    public function ShowDollarCol(){
        $this->showColumn= !$this->showColumn;
    }

    public function quantityAvailable($product){
        $quantity_available = $product->stock_lines->sum('quantity') - $product->stock_lines->sum('quantity_sold');
        return $quantity_available;
    }

    public function getProductDiscount($pid){
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

    public function getProductExchangeRate($current_stock){
        $exchange_rate = $current_stock->transaction()->get()->first()->transaction_payments->last()->exchange_rate;
        return $exchange_rate;
    }

    public function getProductPrice($stock,$exchange_rate){
        if(!empty($stock->dollar_sell_price))
            $price = $stock->dollar_sell_price * $exchange_rate;
        else
            $price = $stock->sell_price;
        return number_format($price, 2);
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

        $transaction = TransactionSellLine::find($transaction_id);
//        $returned_transaction = TransactionSellLine::where('return_parent_id',$transaction_id)->sum('final_total');
//        if($returned_transaction){
//            $final_amount = $transaction->final_total - $transaction->used_deposit_balance -  $returned_transaction;
//        }else{
            $final_amount = $transaction->final_total ;
//        }

        $payment_status = 'pending';
        if ($final_amount <= $total_paid) {
            $payment_status = 'paid';
        } elseif ($total_paid > 0 && $final_amount > $total_paid) {
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

        if ($transaction->type == 'sell_return') {
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
            $html_content = view('sale_pos.partials.invoice')->with(compact(
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

    public function changeTotal(){
        $this->total = $this->price - $this->discount;
        $this->total_after_discount = $this->price - $this->discount;
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
