<?php

namespace App\Http\Livewire\Returns\Sell;

use App\Models\AddStockLine;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\PaymentTransactionSellLine;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\SellLine;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Create extends Component
{
    public $id, $sellines = [], $quantity = [], $amount, $sell_return, $store,
            $branches,$branch_id,$store_pos,
            $method, $paid_on, $notes,$sale, $transaction_sell_line_id = [] ,
            $payment_status,$payment,$final_total , $store_pos_id ;


    public function __construct($id)
    {
        $this->id = $id;
    }

    public function mount()
    {
        $this->sale = TransactionSellLine::find($this->id);
        $this->sellines = $this->sale->transaction_sell_lines;
        $this->store = $this->sale->store_id;
        $this->branches =  Branch::where('type','branch')->orderBy('created_at', 'desc')->pluck('name','id');
        // $this->branch_id = Store::where('id', $this->sale->store_id)->pluck('branch_id');
        $this->branch_id = Store::where('id', $this->sale->store_id)->value('branch_id');
        $this->store_pos = StorePos::orderBy('name', 'asc')->pluck('name', 'id');
        $this->sell_return = TransactionSellLine::where('type', 'returns')
            ->where('return_parent_id', $this->id)
            ->first();

        $cash_register_id = CashRegisterTransaction::select('cash_register_id')->where('transaction_id', $this->id)->get();
        $this->store_pos_id = CashRegister::where('store_pos_id',$cash_register_id[0]->cash_register_id)->pluck('store_pos_id');

        // dd( $this->store_pos_id);
        foreach ($this->sellines as $key => $product){
            $this->transaction_sell_line_id[$key] = $product->id;

            if(!empty($product->quantity_returned)){
                $this->quantity[$key] = number_format($product->quantity_returned,2);
            }
            else{
                $this->quantity[$key] = number_format(0,2);
            }
        }

        if ( !empty($sell_return) && $sell_return->transaction_payments->count() > 0){
            $this->notes = $sell_return->notes;
            $this->payment = $sell_return->transaction_payments->first();
            if(!empty($this->payment)){
                $this->amount = number_format($this->payment->amount);
                $this->method = $this->payment->method;
                $this->paid_on = $this->payment->paid_on;
            }
        }
        else{
            $this->method = 'cash';
            $this->paid_on = date('Y-m-d');
        }
    }

    public function render()
    {
//        $sale  = TransactionSellLine::find($this->id);
        $categories = Category::whereNull('parent_id')->get();
        $sub_categories = Category::whereNotNull('parent_id')->get();
        $brands = Brand::all();
        $store_pos = StorePos::where('user_id', Auth::user()->id)->first();
        $customers = Customer::getCustomerArrayWithMobile();
        $payment_type_array = $this->getPaymentTypeArrayForPos();
        $deliverymen = Employee::getDropdownByJobType('Deliveryman');

        $walk_in_customer = Customer::where('name', 'Walk-in-customer')->first();


        $stores = Store::getDropdown();




        return view('livewire.returns.sell.create')->with(compact(
//            'sell_return',
//            'sale',
            'categories',
            'walk_in_customer',
            'deliverymen',
            'sub_categories',
            'brands',
            'store_pos',
            'customers',
            'stores',
            'payment_type_array',
        ));
    }

    public function setAmount(){

    }

    public function changeAmount($index){
        foreach ($this->quantity as $key => $quantity ){
            $this->amount = $quantity * $this->sellines[$key]['sell_price'];
        }
        $this->final_total = $this->amount;
    }
    public function store(){
        try {
            $sell_return = TransactionSellLine::where('type', 'sell_return')
                ->where('return_parent_id', $this->id)
                ->first();
            $transaction_data = [
                'store_id' => $this->store,
                'customer_id' => $this->sale->customer_id,
                'store_pos_id' => $this->sale->store_pos_id,
                'return_parent_id' => $this->sale->id,
                'exchange_rate' => 0,
                'type' => 'sell_return',
                // 'transaction_currency' => $this->sale->transaction_currency,
                'final_total' => $this->num_uf($this->final_total),
                'grand_total' => $this->num_uf($this->final_total),
                'transaction_date' => Carbon::now(),
                'invoice_no' => $this->createReturnTransactionInvoiceNoFromInvoice($this->sale->invoice_no),
                'status' => 'final',
                'payment_status' => 'pending',
                'notes' => $this->notes,
//                'discount_value' => $this->num_uf($this->discount),
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

            if (empty($sell_return)) {
                $sell_return = TransactionSellLine::create($transaction_data);
            }
            else {
                $sell_return->final_total = $this->num_uf($this->amount);
                $sell_return->grand_total = $this->num_uf($this->amount);
                $sell_return->status = 'final';
                $sell_return->notes = $this->notes;
                $sell_return->save();
            }


            foreach ($this->sellines as $key => $sell_line) {
//                dd($sell_line);
                if (!empty($this->transaction_sell_line_id[$key])) {

                    $line = SellLine::find($this->transaction_sell_line_id[$key]);
                    $old_quantity = $line->quantity_returned;
                    $line->quantity_returned = $this->quantity[$key];
                    $line->save();
                    $product = Product::find($line->product_id);
                    if (!$product->is_service) {
                        $this->updateProductQuantityStore($line->product_id, $sell_return->store_id, $sell_line['quantity'], $old_quantity);
                        if(isset($line->stock_line_id)){
                            $stock = AddStockLine::where('id',$line->stock_line_id)->first();
                            $stock->update([
                                'quantity' =>  $stock->quantity + $old_quantity,
                                'quantity_sold' =>  $stock->quantity - $old_quantity
                            ]);
                        }
                    }
                }
            }
            //deduct employee commission on returned products
//            $this->transactionUtil->deductCommissionForEmployee($this->sale);

//            if ($request->files) {
//                foreach ($request->file('files', []) as $key => $doc) {
//                    $sell_return->addMedia($doc)->toMediaCollection('sell_return');
//                }
//            }
            if ($this->payment_status != 'pending') {
//                dd($this->payment);
                $payment_data = [
                    'transaction_payment_id' => isset($this->payment)? $this->payment->id : null,
                    'transaction_id' => $sell_return->id,
                    'amount' => $this->num_uf($this->amount),
                    'method' => $this->method,
                    'paid_on' => $this->paid_on . ' ' . date('H:i:s'),
                    'exchange_rate' => 0,
                    // 'is_return' => 1,
                ];
                if($this->sale->payment_status !== "pending" || ($this->sale->payment_status == "partial" &&  ($this->sale->final_total - $this->sale->transaction_payments->sum('amount')) <  $this->amount)){

                    $transaction_payment = $this->createOrUpdateTransactionPayment($sell_return, $payment_data);

                }else{
                    $this->updateTransactionPaymentStatus($this->sale->id);
                }


//                if ($request->upload_documents) {
//                    foreach ($request->file('upload_documents', []) as $key => $doc) {
//                        $transaction_payment->addMedia($doc)->toMediaCollection('transaction_payment');
//                    }
//                }

            }

            $this->updateTransactionPaymentStatus($sell_return->id);
            $this->addPayments($sell_return, $payment_data, 'debit');

            DB::commit();

        $output = [
            'success' => true,
            'msg' => __('lang.success')
        ];
    }

        catch (\Exception $e) {
            dd($e);
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return redirect()->to('/sell-return')->with('status', $output);
    }

    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }

    public function createReturnTransactionInvoiceNoFromInvoice($transaction_invoice_number)
    {
        $number_only = substr($transaction_invoice_number, 3);

        return 'Rets' . $number_only;
    }

    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }

    public function updateProductQuantityStore($product_id, $variation_id, $store_id, $new_quantity, $old_quantity = 0)
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
                $product_store->qty_available = 0;
            }

            $product_store->qty_available += $qty_difference;
            $product_store->save();
        }

        return true;
    }

    public function updateTransactionPaymentStatus($transaction_id)
    {
        $transaction_payments = PaymentTransactionSellLine::where('transaction_id', $transaction_id)->get();

        $total_paid = $transaction_payments->sum('amount');

        $transaction = TransactionSellLine::find($transaction_id);
        $returned_transaction = TransactionSellLine::where('return_parent_id',$transaction_id)->sum('final_total');
        if($returned_transaction){
            $final_amount = $transaction->final_total - $transaction->used_deposit_balance -  $returned_transaction;
        }else{
            $final_amount = $transaction->final_total - $transaction->used_deposit_balance;
        }

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

    public function createOrUpdateTransactionPayment($transaction, $payment_data)
    {
        if (!empty($payment_data['transaction_payment_id'])) {
            $transaction_payment = PaymentTransactionSellLine::find($payment_data['transaction_payment_id']);
            $transaction_payment->amount = $payment_data['amount'];
            $transaction_payment->method = $payment_data['method'];
            $transaction_payment->payment_for = !empty($payment_data['payment_for']) ? $payment_data['payment_for'] : $transaction->customer_id;
            $transaction_payment->ref_number = !empty($payment_data['ref_number']) ? $payment_data['ref_number'] : null;
            $transaction_payment->source_type = !empty($payment_data['source_type']) ? $payment_data['source_type'] : null;
            $transaction_payment->source_id = !empty($payment_data['source_id']) ? $payment_data['source_id'] : null;
            $transaction_payment->bank_deposit_date = !empty($payment_data['bank_deposit_date']) ? $payment_data['bank_deposit_date'] : null;
            $transaction_payment->bank_name = !empty($payment_data['bank_name']) ?  $payment_data['bank_name'] : null;
            $transaction_payment->card_number = !empty($payment_data['card_number']) ?  $payment_data['card_number'] : null;
            $transaction_payment->card_security = !empty($payment_data['card_security']) ?  $payment_data['card_security'] : null;
            $transaction_payment->card_month = !empty($payment_data['card_month']) ?  $payment_data['card_month'] : null;
            $transaction_payment->card_year = !empty($payment_data['card_year']) ?  $payment_data['card_year'] : null;
            $transaction_payment->cheque_number = !empty($payment_data['cheque_number']) ?  $payment_data['cheque_number'] : null;
            $transaction_payment->gift_card_number = !empty($payment_data['gift_card_number']) ?  $payment_data['gift_card_number'] : null;
            $transaction_payment->amount_to_be_used = !empty($payment_data['amount_to_be_used']) ?  $this->num_uf($payment_data['amount_to_be_used']) : 0;
            $transaction_payment->payment_note = !empty($payment_data['payment_note']) ?  $payment_data['payment_note'] : null;
            $transaction_payment->created_by = !empty($payment_data['created_by']) ? $payment_data['created_by'] : Auth::user()->id;
            $transaction_payment->is_return = !empty($payment_data['is_return']) ? 1 : 0;
            $transaction_payment->paid_on = $payment_data['paid_on'];

            $transaction_payment->save();
        } else {
            $transaction_payment = null;
            if (!empty($payment_data['amount'])) {
                $payment_data['created_by'] = Auth::user()->id;
                $payment_data['payment_for'] = !empty($payment_data['payment_for']) ? $payment_data['payment_for'] : $transaction->customer_id;
                $transaction_payment = PaymentTransactionSellLine::create($payment_data);
            }
        }

        return $transaction_payment;
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
                    'transaction_type' => "returns",
                    'transaction_id' => $transaction->id,
                    'transaction_payment_id' => $transaction_payment_id
                ]);

                return true;
            } else {
                CashRegisterTransaction::create([
                    'cash_register_id' => $register->id,
                    'amount' => $this->num_uf($payment['amount']),
                    'pay_method' =>  $payment['method'],
                    'type' => $type,
                    'transaction_type' => "returns",
                    'transaction_id' => $transaction->id,
                    'transaction_payment_id' => $transaction_payment_id
                ]);
                return true;
            }
        } else {
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
            $payments_formatted[0]['amount'] = $payments_formatted[0]['amount'] + !empty($pos_return_transactions) ? $this->num_uf($pos_return_transactions->final_total) : 0;
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
        if (empty($register))
        {
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
}
