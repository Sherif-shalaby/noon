<?php

namespace App\Http\Livewire\AddStock;

use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\CustomerType;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
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

    public $divide_costs , $other_expenses = 0, $other_payments = 0, $store_id, $order_date, $purchase_type,
        $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $exchange_rate, $amount, $method,
        $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false,
        $transaction_currency, $current_stock, $clear_all_input_stock_form, $searchProduct, $items = [], $department_id,
        $files, $upload_documents, $ref_number, $bank_deposit_date, $bank_name,$total_amount = 0, $change_exchange_rate_to_supplier,
        $end_date, $deleted_items = [] , $deleted_prices = [], $transaction_id, $discount_from_original_price;

    protected $rules = [
        'store_id' => 'required',
        'supplier' => 'required',
//    'status' => 'required',
        'paying_currency' => 'required',
        'purchase_type' => 'required',
        'payment_status' => 'required',
        'method' => 'required',
        'amount' => 'required',
        'transaction_currency' => 'required',
        'items.*.variation_id' => 'required',
        'source_type' => 'required',
        'source_id' => 'required'
    ];

    public function mount($id)
    {
        $this->transaction_id = $id;
        $recent_stock = StockTransaction::find($id);
        $this->store_id = $recent_stock->store_id ?? '';
        $this->supplier = $recent_stock->supplier_id ?? '';
        $this->transaction_date = $recent_stock->transaction_date ?? '';
        $this->transaction_currency = $recent_stock->transaction_currency ?? '';
        $this->purchase_type = $recent_stock->purchase_type ?? '';
        $this->divide_costs = $recent_stock->divide_costs ?? '';
        $this->payment_status = $recent_stock->payment_status ?? '';
        $this->invoice_no = $recent_stock->invoice_no ?? '';
        $this->other_expenses = !empty((int)$recent_stock->other_expenses) ? $recent_stock->other_expenses : null;
        $this->discount_amount = !empty((int)$recent_stock->discount_amount) ? $recent_stock->discount_amount : null;
        $this->other_payments = !empty((int)$recent_stock->other_payments) ? $recent_stock->other_payments : null;
        $transaction_payment = $recent_stock->transaction_payments->last();
        $this->amount = $transaction_payment->amount ?? '';
        $this->method = $transaction_payment->method ?? '';
        $this->paying_currency = $transaction_payment->paying_currency ?? '';
        $this->source_type = $transaction_payment->source_type ?? '';
        $this->source_id = $transaction_payment->source_id ?? '';
        $this->paid_on = $transaction_payment->paid_on ?? '';
        $this->bank_deposit_date = $transaction_payment->bank_deposit_date ?? '';
        if(!empty($recent_stock->add_stock_lines)){
            foreach ($recent_stock->add_stock_lines as $stock_line){
                $this->addStockProduct($stock_line);
            }
        }
        $this->exchange_rate = $this->changeExchangeRate();
        $this->discount_from_original_price = System::getProperty('discount_from_original_price');
        $this->dispatchBrowserEvent('initialize-select2');
    }
    protected $listeners = ['listenerReferenceHere'];

    public function listenerReferenceHere($data)
    {
        if(isset($data['var1'])) {
            $this->{$data['var1']} = $data['var2'];
        }
        if($data['var1'] == 'supplier'){
            $this->exchange_rate = $this->changeExchangeRate();
        }
    }

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
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        $stores = Store::getDropdown();
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

        $this->dispatchBrowserEvent('initialize-select2');
        return view('livewire.add-stock.edit',
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
                'customer_types',
                'departments',
                'search_result',
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
                'transaction_currency' => 'required',
                'purchase_type' => 'required',
                'divide_costs' => 'required',
                'payment_status' => 'required',
                'method' => 'required',
                'amount' => 'required',
            ];
        }
        if($this->method != 'cash'){
            $this->rules = [
                'store_id' => 'required',
                'supplier' => 'required',
                'transaction_currency' => 'required',
                'purchase_type' => 'required',
                'payment_status' => 'required',
                'method' => 'required',
                'amount' => 'required',
                'bank_name' => 'required',
                'ref_number' => 'required',
                'bank_deposit_date' => 'required',
            ];
        }

        $this->validate();

        try {

            // Add stock transaction
            $transaction = StockTransaction::find($this->transaction_id);
            $transaction->store_id = $this->store_id;
            $transaction->status = 'received';
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
            $transaction->grand_total = $this->num_uf($this->sum_total_cost());
            $transaction->final_total = isset($this->discount_amount) ? ($this->num_uf($this->sum_total_cost()) - $this->discount_amount) : $this->num_uf($this->sum_total_cost());
            $transaction->dollar_grand_total = $this->num_uf($this->sum_dollar_total_cost());
            $transaction->dollar_final_total = $this->num_uf($this->dollar_final_total());
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

            if ($this->files) {
                $transaction->file = store_file($this->files, 'stock_transaction');
            }

            $transaction->save();

            // change exchange_rate to Supplier
            if(!empty($change_exchange_rate_to_supplier)){
                $supplier = Supplier::find($this->supplier);
                $supplier->exchange_rate = $this->exchange_rate;
                $supplier->start_date = Carbon::now();
                $supplier->end_date = $this->end_date ?? null;
                $supplier->save();
            }

            // Add payment transaction
            if(!empty($this->amount))
            {
                $payment = $transaction->transaction_payments->last();
                $payment->stock_transaction_id  = $transaction->id;
                $payment->amount  = $this->amount;
                $payment->method = $this->method;
                $payment->paid_on = !empty($this->paid_on) ? $this->paid_on :  Carbon::now() ;
                $payment->source_type = !empty($this->source_type) ? $this->source_type : null;
                $payment->source_id = !empty($this->source_id) ? $this->source_id : null;
                $payment->payment_note =!empty($this->notes) ? $this->notes : null;
                $payment->created_by = Auth::user()->id;
                $payment->exchange_rate = $this->num_uf($this->exchange_rate);
                $payment->paying_currency = $this->paying_currency;
                $payment->ref_number = $this->ref_number ?? null;
                $payment->bank_name = $this->bank_name ?? null;
                $payment->bank_deposit_date = $this->bank_deposit_date ?? null;

                //upload Documents
                if ($this->upload_documents)
                {
                    $payment->upload_documents = store_file($this->upload_documents, 'stock_transaction_payment');
                }
                $payment->save();

                // check user and add money to user
                if  ($payment->method == 'cash'){
                    $user_id = null;
                    if (!empty($this->source_id)) {
                        if ($this->source_type == 'pos') {
                            $user_id = StorePos::where('id', $this->source_id)->first()->user_id;
                        }
                        if ($this->source_type == 'safe') {
                            $money_safe = MoneySafe::find($this->source_id);
                            $old_ms_transaction = MoneySafeTransaction::where('transaction_id', $transaction->id)->first();
                            if($old_ms_transaction){
                                if ($old_ms_transaction->money_safe_id != $money_safe->id) {
                                    MoneySafeTransaction::where('transaction_id', $transaction->id)->delete();
                                }
                            }
                            $money_safe_Date = [
                                'created_by' => Auth::user()->id,
                                'type' => 'debit',
                                'source_type' => 'safe',
                                'source_id' => $this->source_id,
                                'store_id' =>  $this->store_id,
                                'transaction_id' => $transaction->id,
                                'transaction_type' => 'add_stock',
                                'transaction_payment_id' => $payment->id,
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
            }

            // add  products to stock lines
            foreach ($this->items as $index => $item)
            {
                if (isset($this->product['change_price_stock']) && $this->product['change_price_stock'])
                {
                    if (isset($product['stock_lines']))
                    {
                        foreach ($product['stock_lines'] as $line)
                        {
                            $line->sell_price = !empty($item['selling_price']) ? $item['selling_price'] : null;
                            $line->dollar_sell_price = !empty($item['dollar_selling_price']) ? $item['dollar_selling_price'] : null;
                            $line->save();
                        }
                    }
                }

                $supplier = Supplier::find($this->supplier);
                $add_stock_data = [
                    'variation_id' => $item['variation_id'] ?? null,
                    'product_id' => $item['product']['id'],
                    'stock_transaction_id' =>$transaction->id ,
                    'quantity' => $item['quantity'],
                    'purchase_price' => !empty($item['purchase_price']) ? $item['purchase_price'] : null ,
                    'final_cost' => !empty($item['total_cost']) ? $this->num_uf($item['total_cost'])  : null,
                    'sub_total' => !empty($item['sub_total']) ? $this->num_uf($item['sub_total']) : null,
                    'sell_price' => !empty($item['selling_price']) ? $this->num_uf($item['selling_price']) : null,
                    'dollar_purchase_price' => !empty($item['dollar_purchase_price']) ? $this->num_uf($item['dollar_purchase_price']) : null,
                    'dollar_final_cost' => !empty($item['dollar_total_cost']) ? $this->num_uf($item['dollar_total_cost']) : 0,
                    'dollar_sub_total' => !empty($item['dollar_sub_total']) ? $this->num_uf($item['dollar_sub_total']) : null,
                    'dollar_sell_price' => !empty($item['dollar_selling_price']) ? $this->num_uf($item['dollar_selling_price']) : null,
                    'cost' => !empty($item['cost']) ?  $item['cost'] : null,
                    'dollar_cost' => !empty($item['dollar_cost']) ? $this->num_uf($item['dollar_cost']) : null,
                    'expiry_date' => !empty($item['expiry_date']) ? $this->num_uf($item['expiry_date']) : null,
                    'expiry_warning' => !empty($item['expiry_warning']) ? $item['expiry_warning'] : null,
                    'convert_status_expire' => !empty($item['convert_status_expire']) ? $item['convert_status_expire'] : null,
                    'exchange_rate' => !empty($supplier->exchange_rate) ? str_replace(',' ,'',$supplier->exchange_rate) : null,
                    'fill_type' => $item['fill_type'] ?? null,
                    'fill_quantity' => $item['fill_quantity'] ?? null,
                ];
                if(!empty($item['stock_line_id'])){
                    $stock_line = AddStockLine::find($item['stock_line_id']);
                    $stock_line->update($add_stock_data);
                }
                else{
                    $stock_line = AddStockLine::create($add_stock_data);
                }
                $this->updateProductQuantityStore($item['product']['id'], $transaction->store_id, $item['quantity'], 0);
                if(!empty($this->deleted_items)){
                    foreach ($this->deleted_items as $delete_line){
                        $line = AddStockLine::find($delete_line);
                        $line->forceDelete();
                    }
                }

                if(!empty($item['prices'])){
                    foreach ($item['prices'] as $price){
                        $price_data = [
                            'product_id' => $item['product']['id'],
                            'price_type' => $price['price_type'],
                            'price_category' => $price['price_category'],
                            'price' => $price['price'],
                            'dinar_price' => $price['dinar_price'],
                            'quantity' => $price['discount_quantity'],
                            'bonus_quantity' => $price['bonus_quantity'],
                            'price_customers'=>!empty($price['price_after_desc']) ? $price['price_after_desc'] : null,
                            'dinar_price_customers'=>!empty($price['dinar_price_after_desc']) ? $price['dinar_price_after_desc'] : null,
                            'price_customer_types' => $price['price_customer_types'],
                            'created_by' => Auth::user()->id,
                            'stock_line_id' => $stock_line->id,
                            'dinar_total_price' => isset($price['dinar_total_price']) ? $price['total_price'] : null,
                            'total_price' => isset($price['total_price']) ? $price['total_price'] : null,
                            'dinar_piece_price' => isset($price['dinar_piece_price']) ? $price['dinar_piece_price'] : null,
                            'piece_price' => isset($price['piece_price']) ? $price['piece_price'] : null,
                        ];
                        if(!empty($item['product_price_id'])){
                            $product_price = ProductPrice::find($item['product_price_id']);
                            $product_price->update($price_data);
                        }
                        else{
                            $product_price = ProductPrice::create($price_data);
                        }
                    }
                }
                if(!empty($this->deleted_prices)){
                    foreach ($this->deleted_prices as $delete_price){
                        $line = ProductPrice::find($delete_price);
                        $line->forceDelete();
                    }
                }

            }

            DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'lang.success',]);
        }
        catch (\Exception $e){
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
        return redirect('/add-stock/index');
    }
    public function addStockProduct($line)
    {
//        dd($line);
        $new_item = [
            'variations' => $line->product->variations??'',
            'variation_id' => $line->variation_id,
            'product' => $line->product,
            'quantity' => $line->quantity,
            'unit' => null,
            'base_unit_multiplier' => null,
            'fill_type' => $line->fill_type,
            'fill_quantity' => $line->fill_quantity,
            'purchase_price' => $line->purchase_price,
            'selling_price' => $line->sell_price,
            'dollar_purchase_price' => $line->dollar_purchase_price,
            'dollar_selling_price' => $line->dollar_sell_price,
            'sub_total' => $line->sub_total,
            'dollar_sub_total' => $line->dollar_sub_total,
            'size' => !empty($line->product->size) ? $line->product->size : 0,
            'total_size' => !empty($line->product->size) ? $line->product->size * 1 : 0,
            'weight' => !empty($line->product->weight) ? $line->product->weight : 0,
            'total_weight' => !empty($line->product->weight) ? $line->product->weight * 1 : 0,
            'dollar_cost' => $line->dollar_cost,
            'cost' => $line->cost,
            'dollar_total_cost' => $line->dollar_final_cost,
            'total_cost' => $line->final_cost,
            'current_stock' => 0,
            'total_stock' => 0 + 1,
            'stock_line_id' => $line->id,
            'prices' => []
        ];
        $new_price=[];
        $product_prices = ProductPrice::where('stock_line_id', $line->id)->get();
        if(!empty($product_prices)){
            foreach ($product_prices as $price){
                $new_price = [
                    'price_type' => $price->price_type,
                    'price_category' => $price->price_category,
                    'price' => $price->price,
                    'dinar_price' => $price->dinar_price,
                    'discount_quantity' => $price->discount_quantity,
                    'bonus_quantity' => $price->bonus_quantity,
                    'price_customer_types' => $price->price_customer_types,
                    'price_after_desc' => $price->price_customers,
                    'dinar_price_after_desc' => $price->dinar_price_customers,
                    'dinar_total_price'=> $price->dinar_total_price,
                    'total_price'=> $price->total_price,
                    'piece_price'=> $price->piece_price,
                    'dinar_piece_price'=> $price->dinar_piece_price,
                    'product_price_id' => $price->id,
                ];
            }
        }
        else{
            $new_price = [
                'price_type' => null,
                'price_category' => null,
                'price' => null,
                'dinar_price' => null,
                'discount_quantity' => null,
                'bonus_quantity' => null,
                'price_customer_types' => null,
                'price_after_desc' => null,
                'dinar_price_after_desc' => null,
                'total_price' => null,
                'dinar_total_price' =>null,
                'piece_price' => null,
                'dinar_piece_price' => null,
            ];
        }
        array_unshift($new_item['prices'],$new_price);
        array_unshift($this->items, $new_item);

    }
    public function add_product($id, $add_via = null, $index = null){
        if(!empty($this->searchProduct)){
            $this->searchProduct = '';

        }
        $product = Product::find($id);
        $variations = $product->variations ?? null;
//        dd($product,$variations);
        if($add_via == 'unit'){
            $show_product_data = false;
            $this->addNewProduct($variations,$product,$show_product_data, $index);
        }
        else{
            if(!empty($this->items)){
                $newArr = array_filter($this->items, function ($item) use ($product) {
                    return $item['product']['id'] == $product->id;
                });
                if (count($newArr) > 0) {
                    $key = array_keys($newArr)[0];
                    ++$this->items[$key]['quantity'];
                    // push index to top
                    $item = $this->items[$key];
                    array_splice($this->items, $key, 1);
                    array_unshift($this->items, $item);
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

//    public function getCurrentStock($product_id){
    public function addNewProduct($variations,$product,$show_product_data, $index = null){
//        $current_stock = $this->getCurrentStock($product->id);
        $new_item = [
            'show_product_data' => $show_product_data,
            'variations' => $variations,
            'product' => $product,
            'quantity' => 1,
            'unit' => null,
            'base_unit_multiplier' => null,
            'fill_type' => 'fixed',
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
            'prices' => [
                [
                    'price_type' => null,
                    'price_category' => null,
                    'price' => null,
                    'dinar_price' => null,
                    'discount_quantity' => null,
                    'bonus_quantity' => null,
                    'price_customer_types' => null,
                    'price_after_desc' => null,
                    'dinar_price_after_desc' => null,
                    'total_price' => null,
                    'dinar_total_price' =>null,
                    'piece_price' => null,
                    'dinar_piece_price' => null,
                ],
            ],
        ];
        array_unshift($this->items, $new_item);
    }
    public function addPriceRow($index){
        $new_price = [
            'price_type' => null,
            'price_category' => null,
            'price' => null,
            'dinar_price' => null,
            'discount_quantity' => null,
            'bonus_quantity' => null,
            'price_customer_types' => null,
            'price_after_desc' => null,
            'dinar_price_after_desc' => null,
            'total_price' => null,
            'dinar_total_price' =>null,
            'piece_price' => null,
            'dinar_piece_price' => null,
        ];
        array_unshift($this->items[$index]['prices'], $new_price);
    }

    public function delete_price_raw($index,$key)
    {
        if(!empty($this->items[$index]['prices'][$key]['product_price_id'])){
            $this->deleted_prices[] = $this->items[$index]['prices'][$key]['product_price_id'];
        }
        unset($this->items[$index]['prices'][$key]);
    }

    public function changePrice($index,$key)
    {
        $this->discount_from_original_price = System::getProperty('discount_from_original_price');
        if(!empty($this->items[$index]['selling_price']) || !empty($this->items[$index]['dollar_selling_price'])){
            $sell_price = !empty($this->items[$index]['selling_price']) ?$this->num_uf( $this->items[$index]['selling_price']) : $this->num_uf($this->items[$index]['dollar_selling_price']);
            $total_quantity = (float)$this->items[$index]['prices'][$key]['discount_quantity'] +(float)$this->items[$index]['prices'][$key]['bonus_quantity'];
            if(!empty($this->items[$index]['prices'][$key]['price'])){
                if (empty($this->discount_from_original_price) && !empty($this->items[$index]['prices'][$key]['discount_quantity'])){
                    $total_sell_price = $this->num_uf($sell_price) * $this->num_uf($this->items[$index]['prices'][$key]['discount_quantity']);
                    $sell_price = $this->num_uf($total_sell_price) / $this->num_uf($total_quantity) ;
                }
                if($this->items[$index]['prices'][$key]['price_type'] == 'fixed'){
                    $this->items[$index]['prices'][$key]['price_after_desc'] = number_format($this->num_uf($sell_price) -  $this->num_uf($this->items[$index]['prices'][$key]['price']),num_of_digital_numbers()) ;
                }
                elseif($this->items[$index]['prices'][$key]['price_type'] == 'percentage'){
                    $percent = $this->num_uf($sell_price) * $this->num_uf($this->items[$index]['prices'][$key]['price']) / 100;
                    $this->items[$index]['prices'][$key]['price_after_desc'] = number_format((float)($this->num_uf($sell_price) - $percent ),num_of_digital_numbers()) ;
                }
            }
            $price = !empty($this->items[$index]['prices'][$key]['price_after_desc']) ? $this->num_uf($this->items[$index]['prices'][$key]['price_after_desc']) : $this->num_uf($sell_price);
            if(empty($this->discount_from_original_price)){
                $this->items[$index]['prices'][$key]['total_price'] = number_format($this->num_uf($price) * (!empty($this->items[$index]['prices'][$key]['discount_quantity']) ? $this->num_uf($this->items[$index]['prices'][$key]['discount_quantity']) : 1),num_of_digital_numbers()) ;
                $this->items[$index]['prices'][$key]['piece_price'] = number_format($this->num_uf($this->items[$index]['prices'][$key]['total_price'])/(!empty($total_quantity) ? $total_quantity : 1),num_of_digital_numbers()) ;

            }
            else{
                $this->items[$index]['prices'][$key]['total_price'] = number_format($this->num_uf($price) * (!empty($this->items[$index]['prices'][$key]['discount_quantity']) ? $this->num_uf($this->items[$index]['prices'][$key]['discount_quantity']) : 1),num_of_digital_numbers()) ;
                $this->items[$index]['prices'][$key]['piece_price'] = number_format($this->num_uf($this->items[$index]['prices'][$key]['total_price'] )/ (!empty($total_quantity) ? $this->num_uf($total_quantity) : 1),num_of_digital_numbers()) ;
            }
        }
    }

    public function getVariationData($index){
        if(!empty($this->items[$index]['variation_id'])){
            $variant = Variation::find($this->items[$index]['variation_id']);
            $this->items[$index]['unit'] = $variant->unit->name;
            $this->items[$index]['base_unit_multiplier'] = $variant->equal;
        }
    }

    public function changeFilling($index){
        if(!empty($this->items[$index]['fill_quantity'])){
            if(!empty($this->items[$index]['purchase_price'])){
                if($this->items[$index]['fill_type']=='fixed'){
                    $this->items[$index]['selling_price']= ( $this->num_uf($this->items[$index]['purchase_price']) + (float)$this->num_uf($this->items[$index]['fill_quantity']) );
                }else{
                    $percent=((float)$this->num_uf($this->items[$index]['purchase_price']) * (float)$this->num_uf($this->items[$index]['fill_quantity'])) / 100;
                    $this->items[$index]['selling_price']= (float)($this->num_uf($this->items[$index]['purchase_price']) + $percent);
                }
            }
            if(!empty($this->items[$index]['dollar_purchase_price'])){

                if($this->items[$index]['fill_type']=='fixed'){
                    $this->items[$index]['dollar_selling_price']=($this->num_uf($this->items[$index]['dollar_purchase_price'])+(float)$this->num_uf($this->items[$index]['fill_quantity']));
                }
                else{
                    $percent = ((float)$this->num_uf($this->items[$index]['dollar_purchase_price']) * (float)$this->num_uf($this->items[$index]['fill_quantity'])) / 100;
                    $this->items[$index]['dollar_selling_price'] = ((float)$this->num_uf($this->items[$index]['dollar_purchase_price']) + $percent);
                }
            }
//            dd($this->items[$index]['dollar_selling_price']);
        }
        $this->changeTotalAmount();

    }
    public function get_product($index){
        return Variation::where('id' ,$this->selectedProductData[$index]->id)->first();
    }

    public function sub_total($index)
    {
        if(isset($this->items[$index]['quantity']) && (isset($this->items[$index]['purchase_price']) ||isset($this->items[$index]['dollar_purchase_price']) )){
            // convert purchase price from Dollar To Dinar
            $purchase_price = $this->convertDollarPrice($index);

            $this->items[$index]['sub_total'] = (int)$this->items[$index]['quantity'] * (float)$purchase_price ;

            return number_format($this->items[$index]['sub_total'], num_of_digital_numbers());
        }
        else{
            $this->items[$index]['purchase_price'] = null;
        }
    }

    public function dollar_sub_total($index)
    {
        if(isset($this->items[$index]['quantity']) && isset($this->items[$index]['dollar_purchase_price']) || isset($this->items[$index]['purchase_price'])){
            // convert purchase price from Dinar To Dollar
            $purchase_price = $this->convertDinarPrice($index);

            $this->items[$index]['dollar_sub_total'] = (int)$this->items[$index]['quantity'] * (float)$purchase_price;

            return number_format($this->items[$index]['dollar_sub_total'], num_of_digital_numbers());
        }
        else{
            $this->items[$index]['dollar_purchase_price'] = null;
        }
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

    public function sum_weight(){
        $totalWeight = 0;

        foreach ($this->items as $item) {
            $totalWeight += $item['total_weight'];
        }
        return $totalWeight;
    }

    public function cost($index){

        if($this->paying_currency == 2){
            (float)$cost = ( (float)$this->other_expenses + (float)$this->other_payments ) * $this->num_uf($this->exchange_rate);
        }
        else{
            (float)$cost = (float)$this->other_expenses + (float)$this->other_payments ;
        }
        // convert purchase price from Dollar To Dinar
        $purchase_price = $this->convertDollarPrice($index);


        if (isset($this->divide_costs)){

            if ($this->divide_costs == 'size'){
                if($this->sum_size() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_sizes_less_equal_zero']);
                    unset($this->divide_costs);
                }
                else{
                    (float)$this->items[$index]['cost'] = ( ( $cost / $this->sum_size() ) * $this->items[$index]['size'] ) + (float)$purchase_price;
                }
            }
            elseif ($this->divide_costs == 'weight'){
                if($this->sum_weight() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_weights_less_equal_zero']);
                    unset($this->divide_costs);

                }
                else {
                    (float)$this->items[$index]['cost'] = (($cost / $this->sum_weight()) * $this->items[$index]['weight']) + (float)$purchase_price;
                }
            }
            else{
                $this->items[$index]['cost'] = ( ( (float)$cost /(float)$this->sum_sub_total() ) * (float)$purchase_price ) + (float)$purchase_price;
            }
        }
        else{
            $this->items[$index]['cost'] = (float)$purchase_price;
        }
        return number_format($this->num_uf($this->items[$index]['cost']),num_of_digital_numbers());
    }

    public function total_cost($index){
        $this->items[$index]['total_cost'] = (float)$this->items[$index]['cost'] * $this->items[$index]['quantity'];
        return number_format($this->items[$index]['total_cost'],num_of_digital_numbers()) ;
    }

    public function dollar_cost($index){


        if($this->paying_currency == 2){
            $dollar_cost = ( (float)$this->other_expenses + (float)$this->other_payments ) * $this->num_uf($this->exchange_rate);
        }
        else{
            $dollar_cost = (float)$this->other_expenses + (float)$this->other_payments ;
        }
        // convert purchase price from Dinar to Dollar
        $purchase_price = $this->convertDinarPrice($index);

        if (isset($this->divide_costs)){

            if ($this->divide_costs == 'size'){
                if($this->sum_size() == 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_sizes_less_equal_zero']);
                    unset($this->divide_costs);
                }
                else{
                    (float)$this->items[$index]['dollar_cost'] = ( ( $dollar_cost / $this->sum_size() ) * $this->items[$index]['size'] ) + (float)$purchase_price;
                }
            }
            elseif ($this->divide_costs == 'weight'){
                if($this->sum_weight() == 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_weights_less_equal_zero']);
                    unset($this->divide_costs);

                }
                else {
                    (float)$this->items[$index]['dollar_cost'] = (($dollar_cost / $this->sum_weight()) * $this->items[$index]['weight']) + (float)$purchase_price;
                }
            }
            else{
                (float)$this->items[$index]['dollar_cost'] =$this->num_uf( ( ( $dollar_cost / $this->sum_dollar_sub_total() ) * (float)$purchase_price ) + (float)$purchase_price ) ;
            }
        }
        else{
            $this->items[$index]['dollar_cost'] = (float)$purchase_price;
        }
        return number_format($this->items[$index]['dollar_cost'],num_of_digital_numbers());
    }

    public function dollar_total_cost($index){
        $this->items[$index]['dollar_total_cost'] = $this->items[$index]['dollar_cost'] * $this->items[$index]['quantity'];
        return $this->num_uf($this->items[$index]['dollar_total_cost']);

    }

    public function sum_total_cost(){
        $totalCost = 0;
        if(!empty($this->items)) {
            foreach ($this->items as $item) {
                $totalCost += (float)$item['total_cost'];
            }
        }
        $this->changeAmount(number_format($totalCost,num_of_digital_numbers()));
        return $this->num_uf($totalCost);
    }

    public function sum_dollar_total_cost(){
        $totalDollarCost = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item) {
//                dd($item['dollar_total_cost']);
                $totalDollarCost += $item['dollar_total_cost'];
            }
        }
        $this->changeAmount(number_format($totalDollarCost,num_of_digital_numbers()));
//        dd($totalDollarCost);
        return $this->num_uf($totalDollarCost);
    }

    public function changeAmount($value){
        $this->amount = $this->num_uf($value);
    }
    public function changeTotalAmount(){
        if($this->paying_currency == 2){
            $this->total_amount =$this->num_uf($this->sum_dollar_total_cost()) -$this->calcPayment();
        }else{
            $this->total_amount =$this->sum_total_cost() -$this->calcPayment();
        }
    }
    public function sum_sub_total(){
        $totalSubTotal = 0;

        foreach ($this->items as $item) {
            $totalSubTotal += $item['sub_total'];
        }
        return $this->num_uf($totalSubTotal);
    }
    public function sum_dollar_sub_total(){
        $totalDollarSubTotal = 0;

        foreach ($this->items as $item) {
            $totalDollarSubTotal += $item['dollar_sub_total'];
        }
        return $this->num_uf($totalDollarSubTotal);
    }
    public function changeCurrentStock($index){
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
        if(!empty($this->items[$index]['stock_line_id'])){
            $this->deleted_items [] = $this->items[$index]['stock_line_id'];
        }
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
            'card' => __('lang.credit_card'),
            'bank_transfer' => __('lang.bank_transfer'),
            'cheque' => __('lang.cheque'),
            'money_transfer' => 'Money Transfer',
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
        if(empty($this->items[$index]['purchase_price']) && !empty($this->items[$index]['dollar_purchase_price'])){
            $purchase_price = (float)$this->items[$index]['dollar_purchase_price'] * $this->num_uf($this->exchange_rate);
        }
        else{
            $purchase_price = $this->items[$index]['purchase_price'];
        }
        return $purchase_price;
    }

    public function convertDinarPrice($index)
    {
//        dd($this->purchase_price[$index]);
        if (!empty($this->items[$index]['purchase_price']) && empty($this->items[$index]['dollar_purchase_price'])) {
            $purchase_price = $this->items[$index]['purchase_price'] / $this->num_uf($this->exchange_rate);
        }
        else {
            $purchase_price = $this->items[$index]['dollar_purchase_price'];
        }
        return $purchase_price;

    }

    public function changeExchangeRate(){
        if ( isset($this->supplier) ) {
            $supplier = Supplier::where('id', $this->supplier)
                ->where(function ($query) {
                    $query->where('end_date', '>=', Carbon::now())
                        ->orWhereNull('end_date');
                })->first();
            if (isset($supplier->exchange_rate)) {
                return $this->exchangeRate = number_format(str_replace(',', '', $supplier->exchange_rate),num_of_digital_numbers());
            } else
                return $this->exchangeRate = number_format(System::getProperty('dollar_exchange'),num_of_digital_numbers());
        } else {
            return $this->exchangeRate = number_format(System::getProperty('dollar_exchange'),num_of_digital_numbers());
        }
    }
    public function changeExchangeRateBasedPrices(){
        foreach ($this->items as $index=>$item) {
            if($this->items[$index]['purchase_price']!=""){
                $this->sub_total($index);
                $this->dollar_sub_total($index);
            }
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
    public function num_uf($input_number, $currency_details = null){
        $thousand_separator  = ',';
        $decimal_separator  = '.';
        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);
        return (float)$num;
    }
    public function calcPayment() {
        $otherExpenses = is_numeric($this->other_expenses) ? (float)$this->other_expenses : 0;
        $discountAmount = is_numeric($this->discount_amount) ? (float)$this->discount_amount : 0;
        $otherPayments = is_numeric($this->other_payments) ? (float)$this->other_payments : 0;
        return ($otherExpenses - $discountAmount + $otherPayments);

    }
}
