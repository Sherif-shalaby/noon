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
use App\Models\PurchaseOrderTransaction;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
use App\Models\Transaction;
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
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use function Symfony\Component\String\s;

class Create extends Component
{
    protected $rules = [
        'store_id' => 'required',
        'supplier' => 'required',
        'paying_currency' => 'required',
        'purchase_type' => 'required',
        'payment_status' => 'required',
        'method' => 'required',
        'amount' => 'required',
        'transaction_currency' => 'required',
        'items.*.dollar_purchase_price' => 'required_if:items.*.purchase_price,==,null,0,|nullable|numeric',
        'items.*.purchase_price' => 'required_if:items.*.dollar_purchase_price,==,null,0,|nullable|numeric',
        'items.*.dollar_selling_price' => 'required_if:items.*.purchase_price,!=,null,0,|nullable|numeric',
        'items.*.selling_price' => 'required_if:items.*.dollar_purchase_price,!=,null,0,|nullable|numeric',
        'source_type' => 'required',
        'source_id' => 'required',
    ];

    use WithPagination;

    public $divide_costs , $other_expenses = 0, $other_payments = 0, $store_id, $order_date, $purchase_type,
        $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $exchange_rate, $amount, $method,
        $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false,
        $transaction_currency, $current_stock, $clear_all_input_stock_form, $searchProduct, $items = [], $department_id,
        $files, $upload_documents, $ref_number, $bank_deposit_date, $bank_name,$total_amount = 0, $change_exchange_rate_to_supplier,
        $end_date, $dinar_price_after_desc, $search_by_product_symbol, $discount_from_original_price, $po_id;


    public function mount(){

        $this->paid_on = Carbon::now()->format('Y-m-d');
        $this->bank_deposit_date = Carbon::now()->format('Y-m-d');
        $this->transaction_date = date('Y-m-d\TH:i');
        $this->clear_all_input_stock_form = System::getProperty('clear_all_input_stock_form');
        if($this->clear_all_input_stock_form ==0){
            $transaction_payment=[];
            $recent_stock=[];
        }
        else{
            $recent_stock = StockTransaction::where('type','add_stock')->orderBy('created_at', 'desc')->first();
            if(!empty($recent_stock)){
                $transaction_payment = $recent_stock->transaction_payments->first();
                $this->store_id =$recent_stock->store_id ?? null ;
                $this->supplier = $recent_stock->supplier_id?? null;
                $this->transaction_date = $recent_stock->transaction_date ?? null;
                $this->transaction_currency = $recent_stock->transaction_currency ?? null;
                $this->purchase_type = $recent_stock->purchase_type ?? null;
                $this->divide_costs = $recent_stock->divide_costs ?? null;
                $this->payment_status = $recent_stock->payment_status ?? null;
                $this->invoice_no = $recent_stock->invoice_no ?? null;
                $this->other_expenses = !empty((int)$recent_stock->other_expenses) ? $recent_stock->other_expenses : null;
                $this->discount_amount = !empty((int)$recent_stock->discount_amount) ? $recent_stock->discount_amount: null;
                $this->other_payments = !empty((int)$recent_stock->other_payments) ? $recent_stock->other_payments: null;
                $this->amount = $transaction_payment->amount ?? null;
                $this->method = $transaction_payment->method ?? null;
                $this->paying_currency = $this->transaction_currency ;
                $this->source_type =$transaction_payment->source_type ?? null ;
                $this->source_id = $transaction_payment->source_id ?? null;
                $this->paid_on = $transaction_payment->paid_on ?? null;
            }
        }
        $this->exchange_rate = $this->changeExchangeRate();
        $this->dispatchBrowserEvent('initialize-select2');
    }
    protected $listeners = ['listenerReferenceHere'];

    public function listenerReferenceHere($data)
    {
        if(isset($data['var1'])) {
            $this->{$data['var1']} = $data['var2'];
        }
        if($data['var1'] == 'po_id'){
            $this->{$data['var1']} = (int)$data['var2'];
            if(!empty($this->po_id)){
                $this->add_by_po();
            }
        }
        if ($data['var1'] == 'transaction_currency'){
            $this->paying_currency = $data['var2'];
        }
        if($data['var1'] == 'supplier'){
            $this->exchange_rate = $this->changeExchangeRate();
        }
        if($data['var1'] == ('paying_currency' || 'divide_costs')){
            $this->changeTotalAmount();
        }

    }

    public function render(): Factory|View|Application
    {
        $this->discount_from_original_price = System::getProperty('discount_from_original_price');
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
        $po_nos = PurchaseOrderTransaction::where('status', '!=', 'received')->pluck('po_no', 'id');
        $search_result = '';
        if (!empty($this->search_by_product_symbol)){
            $search_result = Product::when($this->search_by_product_symbol,function ($query){
                return $query->where('product_symbol','like','%'.$this->search_by_product_symbol.'%');
            });
            $search_result = $search_result->paginate();
            if(count($search_result) === 1){
                $this->add_product($search_result->first()->id);
                $search_result = '';
                $this->search_by_product_symbol = '';
            }

        }
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

//        $this->changeExchangeRate();
        $this->dispatchBrowserEvent('initialize-select2');
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
            'customer_types',
            'departments',
            'po_nos',
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
            if(!empty($this->po_id)){
                $ref_transaction_po = PurchaseOrderTransaction::find($this->po_id);
            }

            // Add stock transaction
            $transaction = new StockTransaction();
            $transaction->store_id = $this->store_id;
            $transaction->status = 'received';
            $transaction->order_date = !empty($ref_transaction_po) ? $ref_transaction_po->transaction_date : Carbon::now();
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
            $transaction->po_no = !empty($ref_transaction_po) ? $ref_transaction_po->po_no : null;
            $transaction->purchase_order_id = !empty($this->po_id) ? $this->po_id : null;


            DB::beginTransaction();
            // preparer_id
            // $transaction->preparer_id = !empty($this->preparer_id) ? $this->preparer_id : null;

            if ($this->files) {
                $transaction->file = store_file($this->files, 'stock_transaction');
            }

            $transaction->save();

            //update purchase order status if selected
            if (!empty($transaction->purchase_order_id)) {
                PurchaseOrderTransaction::find($transaction->purchase_order_id)->update(['status' => 'received']);
            }


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
                $payment  = new StockTransactionPayment();
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
                        $cr_transaction = CashRegisterTransaction::where('transaction_id', $transaction->id)->first();
                        if($cr_transaction){
                            $register = CashRegister::where('id', $cr_transaction->cash_register_id)->first();
                            $data = [
                                'cash_register_id' => $register->id,
                                'amount' => $payment->amount,
                                'pay_method' => 'cash',
                                'type' => 'debit',
                                'transaction_type' => 'add_stock',
                                'source_id' => $user_id,
                                'referenced_id' => null,
                                'notes' => '',
                            ];
                            $cash_register_transaction = CashRegisterTransaction::where('id', $cr_transaction->id)->first();
                            if (!empty($cash_register_transaction)) {
                                $cash_register_transaction->update($data);
                            } else {
                                $cash_register_transaction = CashRegisterTransaction::create($data);
                            }
                        }else{
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
                            $line->sell_price = !empty($item['selling_price']) ? $this->num_uf($item['selling_price'])  : null;
                            $line->dollar_sell_price = !empty($item['dollar_selling_price']) ? $this->num_uf( $item['dollar_selling_price'] ) : null;
                            $line->save();
                        }
                    }
                }
                $supplier = Supplier::find($this->supplier);
                $add_stock_data = [
                    'variation_id' => $item['variation_id'] ?? null,
                    'product_id' => $item['product']['id'],
                    'stock_transaction_id' =>$transaction->id ,
                    'quantity' => $this->num_uf($item['quantity']),
                    'purchase_price' => !empty($item['purchase_price']) ? $this->num_uf($item['purchase_price'])  : null ,
                    'final_cost' => !empty($item['total_cost']) ? $this->num_uf($item['total_cost'])  : null,
                    'sub_total' => !empty($item['sub_total']) ? $this->num_uf($item['sub_total']) : null,
                    'sell_price' => !empty($item['selling_price']) ? $this->num_uf($item['selling_price']) : null,
                    'dollar_purchase_price' => !empty($item['dollar_purchase_price']) ? $this->num_uf($item['dollar_purchase_price']) : null,
                    'dollar_final_cost' => !empty($item['dollar_total_cost']) ? $this->num_uf($item['dollar_total_cost']) : 0,
                    'dollar_sub_total' => !empty($item['dollar_sub_total']) ? $this->num_uf($item['dollar_sub_total']) : null,
                    'dollar_sell_price' => !empty($item['dollar_selling_price']) ? $this->num_uf($item['dollar_selling_price']) : null,
                    'cost' => !empty($item['cost']) ? $this->num_uf(  $item['cost'] ): null,
                    'dollar_cost' => !empty($item['dollar_cost']) ? $this->num_uf($item['dollar_cost']) : null,
                    'expiry_date' => !empty($item['expiry_date']) ? $item['expiry_date'] : null,
                    'expiry_warning' => !empty($item['expiry_warning']) ? $item['expiry_warning'] : null,
                    'convert_status_expire' => !empty($item['convert_status_expire']) ? $item['convert_status_expire'] : null,
                    'exchange_rate' => !empty($supplier->exchange_rate) ? $this->num_uf($supplier->exchange_rate) : null,
                    'fill_type' => $item['fill_type'] ?? null,
                    'fill_quantity' => !empty($this->num_uf($item['fill_quantity']))  ?? null,
                ];
                $stock_line = AddStockLine::create($add_stock_data);

                $this->updateProductQuantityStore($item['product']['id'],$item['variation_id'], $transaction->store_id, $item['quantity']);
                // add product Prices
                if(!empty($item['prices'])){
                    foreach ($item['prices'] as $price){
                        $price_data = [
                            'product_id' => $item['product']['id'],
                            'price_type' => $price['price_type'],
                            'price_category' => $price['price_category'],
                            'price' => $this->num_uf($price['price']),
                            'dinar_price' => $this->num_uf($price['dinar_price']),
                            'quantity' => $this->num_uf($price['discount_quantity']),
                            'bonus_quantity' => $this->num_uf($price['bonus_quantity']),
                            'price_customers'=>!empty($price['price_after_desc']) ? $this->num_uf( $price['price_after_desc'] ) : null,
                            'dinar_price_customers'=>!empty($price['dinar_price_after_desc']) ? $this->num_uf( $price['dinar_price_after_desc']) : null,
                            'price_customer_types' => $price['price_customer_types'],
                            'created_by' => Auth::user()->id,
                            'stock_line_id ' => $stock_line->id,
                            'dinar_total_price' => !empty($item['selling_price']) ? $this->num_uf( $price['total_price'] ) : null,
                            'total_price' => !empty($item['dollar_selling_price']) ? $this->num_uf( $price['total_price'] ) : null,
                            'dinar_piece_price' => !empty($item['selling_price']) ? $this->num_uf( $price['piece_price'] ) : null,
                            'piece_price' => !empty($item['dollar_selling_price']) ? $this->num_uf( $price['piece_price'] ) : null,
                            'stock_line_id' => $stock_line->id,
                        ];
                        ProductPrice::create($price_data);

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
        return redirect('/add-stock/create');
    }

    public function add_product($id, $add_via = null, $index = null,$new_unit_raw=0){
        if(!empty($this->searchProduct)){
            $this->searchProduct = '';

        }
        if(!empty($this->search_by_product_symbol)){
            $this->search_by_product_symbol = '';

        }
        $product = Product::find($id);
        $variations = $product->variations;
        if($add_via == 'unit'){
            $show_product_data = false;
            $this->addNewProduct($variations,$product,$show_product_data, $index);
        }
        else{
            if(!empty($this->items) && $new_unit_raw==0){
                $newArr = array_filter($this->items, function ($item) use ($product) {
                    return $item['product']['id'] == $product->id;
                });
                if (count($newArr) > 0) {
                    // dd($newArr);
                    $key = array_keys($newArr)[0];
                    ++$this->items[$key]['quantity'];
                    // push index to top
                    $item = $this->items[$key];
                    array_splice($this->items, $key, 1);
                    array_unshift($this->items, $item);
                }
                else{
                    // dd(7);
                    $show_product_data = true;
                    $this->addNewProduct($variations,$product,$show_product_data);
                }
            }
            else{
                $show_product_data = true;
                $this->addNewProduct($variations,$product,$show_product_data,$index);
            }
        }

    }

//    public function getCurrentStock($product_id){
    public function addNewProduct($variations,$product,$show_product_data, $index = null){
//        $current_stock = $this->getCurrentStock($product->id);
          $new_item = [
            'show_product_data' => $show_product_data,
            'variations' => $variations,
            'variation_id' => $variations->first()->id ?? null,
            'product' => $product,
            'purchase_price' => null,
            'dollar_purchase_price' => null,
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
            'fill_quantity' => null,
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
        if(!empty($index)){
            array_splice($this->items, $index + 1, 0, [$new_item]);
        }else{
            array_unshift($this->items, $new_item);
        }
    }

    public function add_by_po(){
        if(!empty($this->items)){
            foreach ($this->items as $key => $item){
                unset($this->items[$key]);
            }
        }
        $transaction_purchase_order = PurchaseOrderTransaction::find($this->po_id);
        $this->store_id = $transaction_purchase_order->store_id;
        $this->supplier = $transaction_purchase_order->supplier_id;
        $orderLines = $transaction_purchase_order->transaction_purchase_order_lines;
        foreach ($orderLines as $orderLine){
            $product = $orderLine->product;
            $variations = Variation::where('product_id',$product->id)->get();
            $new_item = [
            'variations' => $variations,
            'variation_id' => $variations->first()->id ?? null,
            'product' => $product,
            'purchase_price' => $orderLine->purchase_price ?? null,
            'dollar_purchase_price' => $orderLine->purchase_price_dollar ?? null ,
            'quantity' => number_format($orderLine->quantity,2),
            'unit' => null,
            'base_unit_multiplier' => null,
            'fill_type' => 'fixed',
            'sub_total' => $orderLine->purchase_price ? number_format($orderLine->sub_total,2) : 0,
            'dollar_sub_total' => $orderLine->purchase_price_dollar ? number_format($orderLine->sub_total,2) : 0,
            'size' => !empty($product->size) ? $product->size : 0,
            'total_size' => !empty($product->size) ? $product->size * 1 : 0,
            'weight' => !empty($product->weight) ? $product->weight : 0,
            'total_weight' => !empty($product->weight) ? $product->weight * 1 : 0,
            'dollar_cost' => 0,
            'cost' => 0,
            'dollar_total_cost' => 0,
            'total_cost' => 0,
            'current_stock' =>0,
            'total_stock' => 0 + number_format($orderLine->quantity,2),
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
              'dinar_total_price' => null,
              'total_price' => null,
              'piece_price' => null,
              'dinar_piece_price' => null,
          ];
        array_unshift($this->items[$index]['prices'], $new_price);
    }

    public function delete_price_raw($index,$key)
  {
      unset($this->items[$index]['prices'][$key]);
  }

    public function changePrice($index,$key)
    {
        $this->discount_from_original_price = System::getProperty('discount_from_original_price');
        if(!empty($this->items[$index]['selling_price']) || !empty($this->items[$index]['dollar_selling_price'])){
            $sell_price = !empty($this->items[$index]['selling_price']) ? $this->items[$index]['selling_price'] : $this->items[$index]['dollar_selling_price'];
            $total_quantity = (float)$this->items[$index]['prices'][$key]['discount_quantity'] +(float)$this->items[$index]['prices'][$key]['bonus_quantity'];
            if(!empty($this->items[$index]['prices'][$key]['price'])){
                if (empty($this->discount_from_original_price) && !empty($this->items[$index]['prices'][$key]['discount_quantity'])){
                    $total_sell_price = $sell_price * $this->items[$index]['prices'][$key]['discount_quantity'];
                    $sell_price = $total_sell_price / $total_quantity ;
                }
                if($this->items[$index]['prices'][$key]['price_type'] == 'fixed'){
                    $this->items[$index]['prices'][$key]['price_after_desc'] = number_format((float)$sell_price-  (float)$this->items[$index]['prices'][$key]['price'],3) ;
                }
                elseif($this->items[$index]['prices'][$key]['price_type'] == 'percentage'){
                    $percent = $sell_price * $this->items[$index]['prices'][$key]['price'] / 100;
                    $this->items[$index]['prices'][$key]['price_after_desc'] = number_format((float)($sell_price - $percent ),3) ;
                }
            }
            $price = !empty($this->items[$index]['prices'][$key]['price_after_desc']) ? (float)$this->items[$index]['prices'][$key]['price_after_desc'] : $sell_price;
            if(empty($this->discount_from_original_price)){
                $this->items[$index]['prices'][$key]['total_price'] = number_format((float)$price * (!empty($this->items[$index]['prices'][$key]['discount_quantity']) ? $this->items[$index]['prices'][$key]['discount_quantity'] : 1),3) ;
                $this->items[$index]['prices'][$key]['piece_price'] = number_format($this->items[$index]['prices'][$key]['price_after_desc'],3) ;
            }
            else{
                $this->items[$index]['prices'][$key]['total_price'] = number_format((float)$price * (!empty($this->items[$index]['prices'][$key]['discount_quantity']) ? (float)$this->items[$index]['prices'][$key]['discount_quantity'] : 1),3) ;
                $this->items[$index]['prices'][$key]['piece_price'] = number_format((float)$this->items[$index]['prices'][$key]['total_price'] / (!empty($total_quantity) ? $total_quantity : 1),3) ;
            }
        }
    }

    public function getVariationData($index){
       $variant = Variation::find($this->items[$index]['variation_id']);
       $this->items[$index]['unit'] = $variant->unit->name;
       $this->items[$index]['base_unit_multiplier'] = $variant->equal;
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

    public function dollar_sub_total($index)
    {
        $this->changeFilling($index);
        if(isset($this->items[$index]['quantity']) && isset($this->items[$index]['dollar_purchase_price']) || isset($this->items[$index]['purchase_price'])){
            // convert purchase price from Dinar To Dollar
            $purchase_price = $this->convertDinarPrice($index);

            $this->items[$index]['dollar_sub_total'] = (int)$this->items[$index]['quantity'] * (float)$purchase_price;

            return number_format($this->items[$index]['dollar_sub_total'], 3);
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
        return number_format($this->num_uf($this->items[$index]['cost']),3);
    }

    public function total_cost($index){
        $this->items[$index]['total_cost'] = (float)$this->items[$index]['cost'] * $this->items[$index]['quantity'];
        return number_format($this->items[$index]['total_cost'],3) ;
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
        return number_format($this->items[$index]['dollar_cost'],3);
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
        $this->changeAmount(number_format($totalCost,3));
        return round_250($this->num_uf($totalCost));
    }

    public function sum_dollar_total_cost(){
        $totalDollarCost = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item) {
//                dd($item['dollar_total_cost']);
                $totalDollarCost += $item['dollar_total_cost'];
            }
        }
        $this->changeAmount(number_format($totalDollarCost,2));
//        dd($totalDollarCost);
        return number_format($this->num_uf($totalDollarCost),2);
    }

    public function changeAmount($value){
        $this->amount = round_250($this->num_uf($value));
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
            $purchase_price = $this->items[$index]['purchase_price'] ?? '';
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
            $purchase_price = $this->items[$index]['dollar_purchase_price'] ?? '';
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
                return $this->exchangeRate = number_format(str_replace(',', '', $supplier->exchange_rate),3);
            } else
                return $this->exchangeRate = number_format(System::getProperty('dollar_exchange'),3);
        } else {
            return $this->exchangeRate = number_format(System::getProperty('dollar_exchange'),3);
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

    public function updateProductQuantityStore($product_id,$variation_id, $store_id, $new_quantity)
    {
        $product_store = ProductStore::where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->first();
        $product_variations = Variation::where('product_id',$product_id)->get();
        $unit = Variation::where('id',$variation_id)->first();
        $qty_difference = 0;
        $qtyByUnit = 1 ;
        if(!empty($product_store) && !empty($product_store->variation_id)){
            $store_variation = Variation::find($product_store->variation_id);
            if($store_variation->unit_id == $unit->unit_id){
                $qty_difference = $new_quantity;
            }
            elseif($store_variation->basic_unit_id == $unit->unit_id){
                $qtyByUnit = 1 / $store_variation->equal;
                $qty_difference = $qtyByUnit * $new_quantity;
            }
            else{
                foreach ($product_variations as $key => $product_variation){
                    if (!empty($product_variations[$key+1])) {
                        if ($store_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                            if ($product_variations[$key + 1]->basic_unit_id == $unit->unit_id) {
                                $qtyByUnit = $store_variation->equal * $product_variations[$key + 1]->equal;
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            } else {
                                $qtyByUnit = $product_variation->equal;
                            }
                        }
                        else{
                            if ($product_variation->basic_unit_id == $product_variations[$key+1]->unit_id){
                                $qtyByUnit *= $product_variation->equal;
                            }
                            if ($product_variation->basic_unit_id == $variation_id || $product_variation->unit_id == $variation_id){
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            }
                        }
                    }
                    else{
                        if ($product_variation->basic_unit_id == $variation_id){
                            $qtyByUnit *= $product_variation->equal;
                            $qty_difference = $new_quantity / $qtyByUnit;
                            break;
                        }
                    }
                }
            }
        }
        else{
            $qty_difference = $new_quantity;
        }
        if ($qty_difference != 0) {
            if (empty($product_store)) {
                $product_store = new ProductStore();
                $product_store->product_id = $product_id;
                $product_store->store_id = $store_id;
                $product_store->quantity_available = 0;
            }
            if(empty($product_store->variation_id) && !empty($variation_id)){
                $product_store->variation_id = $variation_id;
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
    //    $otherExpenses = is_numeric($this->other_expenses) ? (float)$this->other_expenses : 0;
       $discountAmount = is_numeric($this->discount_amount) ? (float)$this->discount_amount : 0;
    //    $otherPayments = is_numeric($this->other_payments) ? (float)$this->other_payments : 0;
       return ( $discountAmount );
    }
    public function addRaw($index){

    }
}
