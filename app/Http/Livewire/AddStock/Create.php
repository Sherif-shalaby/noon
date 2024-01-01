<?php

namespace App\Http\Livewire\AddStock;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\User;
use App\Models\Store;
use App\Models\Branch;
use App\Models\System;
use App\Models\JobType;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\MoneySafe;
use App\Models\Variation;
use App\Models\Transaction;
use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CustomerType;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use Livewire\WithPagination;
use App\Models\VariationPrice;
use App\Models\StockTransaction;
use App\Models\VariationStockline;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Models\MoneySafeTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Models\CashRegisterTransaction;
use App\Models\StockTransactionPayment;
use App\Models\PurchaseOrderTransaction;
use function Symfony\Component\String\s;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;

use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    protected $rules = [
        // 'store_id' => 'required',
        'supplier' => 'required',
        // 'paying_currency' => 'required',
        'purchase_type' => 'required',
        'payment_status' => 'required',
        'method' => 'required',
        'amount' => 'required',
        // 'transaction_currency' => 'required',
        'items.*.dollar_purchase_price' => 'nullable|numeric',
        'items.*.purchase_price' => 'required_if:items.*.dollar_purchase_price,==,null,0,|nullable|numeric',
        'items.*.dollar_selling_price' => 'required_if:items.*.purchase_price,!=,null,0,|nullable|numeric',
        'items.*.selling_price' => 'required_if:items.*.dollar_purchase_price,!=,null,0,|nullable|numeric',
        'source_type' => 'required',
        'source_id' => 'required',
        'items.*.store_id' => 'required',
        'items.*.used_currency' => 'required',
    ];

    use WithPagination;

    public $show_payment=0,$divide_costs ,$allproducts = [], $other_expenses = 0, $department_id1 = null, $department_id2 = null, $department_id3 = null, $department_id4 = null, $other_payments = 0, $store_id, $order_date, $purchase_type,
        $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $exchange_rate, $amount, $method,
        $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false,
        $transaction_currency,$expenses_currency ,$current_stock, $clear_all_input_stock_form, $searchProduct, $items = [], $department_id,
        $files, $upload_documents, $ref_number, $bank_deposit_date, $bank_name,$total_amount = 0, $change_exchange_rate_to_supplier,
        $end_date, $exchangeRate , $dinar_price_after_desc, $search_by_product_symbol, $discount_from_original_price, $po_id,
        $variationSums = [],$expenses = [], $customer_types,$total_amount_dollar,$dollar_remaining,$dinar_remaining,$units ,
        $toggle_customers_dropdown , $customer_id ,$total_expenses=0,$market_exchange_rate=1,$dinar_expenses=0,$dollar_expenses=0;
      public $supplier_data=[
          'dollar_debit'=>'',
          'dinar_debit'=>'',
          'email'=>'',
          'mobile'=>'',
          'state'=>'',
          'city'=>'','address'=>'','notes'=>'',
      ];





    public function mount()
    {
        $this->market_exchange_rate=System::getProperty('dollar_exchange');
        $this->customer_id = 1 ;
        if(isset($_GET['product_id'])){
            $productId = $_GET['product_id'];
            $this->add_product($productId);
        }
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
            if(!empty($recent_stock))
            {
                $transaction_payment = $recent_stock->transaction_payments->first();
                $this->store_id =$recent_stock->store_id ?? null ;
                $this->supplier = $recent_stock->supplier_id?? null;
                $this->changeSupplier();
                $this->transaction_currency = $recent_stock->transaction_currency ?? null;
                $this->purchase_type = $recent_stock->purchase_type ?? null;
                $this->divide_costs = $recent_stock->divide_costs ?? null;
                $this->payment_status = $recent_stock->payment_status ?? null;
                $this->invoice_no = $recent_stock->invoice_no ?? null;
                // $this->other_expenses = !empty((int)$recent_stock->other_expenses) ? $recent_stock->other_expenses : null;
                // $this->discount_amount = !empty((int)$recent_stock->discount_amount) ? $recent_stock->discount_amount: null;
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
        $this->customer_types = CustomerType::orderBy('name', 'asc')->get();

        $this->dispatchBrowserEvent('initialize-select2');
        $this->department_id1 = null;
        $this->department_id2 = null;
        $this->department_id3 = null;
        $this->department_id4 = null;
        $this->source_id=Employee::where('user_id',Auth::user()->id)->first()->id;
    }
    public function changesupplier(){
        if($this->supplier!=null){
            $s_data=Supplier::find($this->supplier);
            // dd(StockTransaction::where('supplier_id',$s_data)->where('type','add_stock')->where('payment_status','partial')->get());
            $dollar_debit=StockTransaction::where('supplier_id',$s_data->id)->where('type','add_stock')->where('payment_status','partial')->sum('dollar_remaining');
            $dollar_debit+=StockTransaction::where('supplier_id',$s_data->id)->where('type','add_stock')->where('payment_status','pending')->sum('dollar_final_total');
            $dinar_debit=StockTransaction::where('supplier_id',$s_data->id)->where('type','add_stock')->where('payment_status','partial')->sum('dinar_remaining');
            $dinar_debit+=StockTransaction::where('supplier_id',$s_data->id)->where('type','add_stock')->where('payment_status','pending')->sum('final_total');
            $this->supplier_data =[
                'dollar_debit'=>$dollar_debit??0,
                'dinar_debit'=>$dinar_debit??0,
                'email'=>json_decode($s_data->email,true),
                'mobile'=>json_decode($s_data->mobile_number,true),
                'state'=>!empty($s_data->state)?$s_data->state->name:'',
                'city'=>!empty($s_data->city)?$s_data->city->name:'',
                'address'=>$s_data->address??'',
                'notes'=>$s_data->notes??'',
            ];
            // dd($this->supplier_data );
        }
    }
    protected $listeners = ['listenerReferenceHere','changeExchangerateForSupplier'];

    public function listenerReferenceHere($data)
    {
        if(isset($data['var1'])) {
            $this->{$data['var1']} = $data['var2'];
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
                $this->changesupplier();
            }
            if($data['var1'] == ('paying_currency' || 'divide_costs')){
                $this->changeTotalAmount();
            }
            if($data['var1'] == 'payment_status'){
                if($this->payment_status=='pending'){
                    $this->show_payment=1;
                }else{
                    $this->show_payment=0;
                }
            }
            
            if($data['var1'] == 'expense_currency'){
                $this->expenses[$data['var3']]["expense_currency"]=$data['var2'];
            }
            
            // if (isset($data['var1']) && $data['var1'] == "department_id1") {
            //     $this->updatedDepartmentId($data['var2'], 'department_id1');
            // }
            // if (isset($data['var1']) && $data['var1'] == "department_id2") {
            //     $this->updatedDepartmentId($data['var2'], 'department_id2');
            // }
            // if (isset($data['var1']) && $data['var1'] == "department_id3") {
            //     $this->updatedDepartmentId($data['var2'], 'department_id3');
            // }
            // if (isset($data['var1']) && $data['var1'] == "department_id4") {
            //     $this->updatedDepartmentId($data['var2'], 'department_id4');
            // }
        }


    }
    public function changeExchangerateForSupplier($status=''){
        try{
            if($status=='ok'){
                $supplier = Supplier::find($this->supplier);
                $supplier->exchange_rate =$this->exchange_rate;
                $supplier->save();
                $this->changeExchangeRateBasedPrices();
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم بنجاح']);
            }else{
                $this->changeExchangeRateBasedPrices();
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs',]);
            dd($e);
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
        $customers = Customer::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        $stores = Store::whereHas('branch', function ($query) {
            $query->where('type', 'branch');
        })->pluck('name','id');
        $departments = Category::where('parent_id', '!=', null)->get();
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
        // if(!empty($this->department_id)){
        //     $products = Product::where('category_id' , $this->department_id)->get();
        // }
        // else{
            // $allproducts = Product::paginate();
        // }
        $this->dispatchBrowserEvent('initialize-select2');
        $this->allproducts = Product::when($this->department_id1 != null, function ($query) {
            $query->where('category_id', $this->department_id1);
            })->when($this->department_id2, function ($query) {
                $query->where('subcategory_id1', $this->department_id2);
            })

            ->when($this->department_id3, function ($query) {
                $query->where('subcategory_id2', $this->department_id3);
            })
            ->when($this->department_id4, function ($query) {
                $query->where('subcategory_id3', $this->department_id4);
            })
            ->get();
        $branches = Branch::where('type', 'branch')->orderBy('created_by','desc')->pluck('name','id');
        $quick_add = 1;
        return view('livewire.add-stock.create',
            compact('status_array',
            'payment_status_array',
            'payment_type_array',
            'stores',
            'product_id',
            'payment_types',
            'payment_status_array',
            'suppliers',
            'customers',
            'selected_currencies',
            'preparers' ,
            'customer_types',
            'departments',
            'po_nos',
            'search_result',
            'users',
        'branches','quick_add'));
    }

    public function changeAllProducts()
    {
        // dd($this->store_id);
        $products_store = ProductStore::where('store_id', $this->store_id)->pluck('product_id');
        $this->allproducts = Product::whereIn('id', $products_store)->get();
        foreach ($this->items as $key => $item) {
            if (!(ProductStore::where('product_id', $this->items[$key]['product']['id'])->where('store_id', $this->store_id)->exists())) {
                $this->delete_item($key);
            }
        }
    }

    public function updatedDepartmentId($value, $name)
    {
        // if ($name == 'department_id1' && !is_null($this->department_id1)) {
        //     // dd($this->department_id1);
        //     $this->allproducts = Product::where('category_id', $this->department_id1)->get();
        //     dd($this->allproducts);
        // }
        // if ($name == 'department_id2' && !is_null($this->department_id2)) {
        //     $this->allproducts = Product::where('subcategory_id1', $this->department_id2)->get();
        // }
        if($name != 'all'){
            $this->allproducts = Product::when($name == 'department_id1', function ($query) {
                $query->where('category_id', $this->department_id1);
            })->when($name == 'department_id2', function ($query) {
                $query->where('subcategory_id1', $this->department_id2);
            })

                ->when($name == 'department_id3', function ($query) {
                    $query->where('subcategory_id2', $this->department_id3);
                })
                ->when($name == 'department_id4', function ($query) {
                    $query->where('subcategory_id3', $this->department_id4);
                })
                ->get();
        }else{
            // $products_store = ProductStore::pluck('product_id');
            $this->allproducts = Product::get();
        }

    }

    public function addExpense()
    {
        $this->expenses[] = ['details' => '', 'amount' => 0,'expense_currency'=>''];
    }
    public function getTotalExpenses(){
        $this->total_expenses=0;
        // $this->total_dinar_expenses=0;
        $this->dinar_expenses=0;
        $this->dollar_expenses=0;
        foreach($this->expenses as $expense){
            if($expense['expense_currency']=='2'){
                $this->total_expenses +=$this->num_uf($expense['amount']);
                $this->dollar_expenses +=$this->num_uf($expense['amount']);
            }else{
                $this->total_expenses +=$this->num_uf($expense['amount']) / $this->num_uf($this->exchange_rate);
                $this->dinar_expenses +=$this->num_uf($expense['amount']);
            }
        }
        $this->dinar_expenses=number_format($this->num_uf($this->dinar_expenses),3);
        $this->dollar_expenses=number_format($this->num_uf($this->dollar_expenses),3);
        // return number_format($this->total_expenses,3);
    }
    public function removeExpense($index)
    {
        if($this->expenses[$index]['expense_currency']=2){
            $this->dollar_expenses-=$this->expenses[$index]['amount'];
        }else{
            $this->dinar_expenses-=$this->expenses[$index]['amount'];
        }
        unset($this->expenses[$index]);
        $this->expenses = array_values($this->expenses);
    }
    public function reset_change(){
        // dd('test');
        $this->dinar_remaining = 0;
        $this->dollar_remaining = 0;
    }
    public function convertRemainingDollar(){
        $this->total_amount = $this->num_uf( $this->total_amount) +($this->num_uf($this->dollar_remaining )*$this->num_uf( $this->exchange_rate)) ;
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function store(): Redirector|Application|RedirectResponse
    {
        if (!empty($this->expenses)){
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

//        $this->validate();

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
            // customers dropdown
            $transaction->customer_id = $this->customer_id ;

            // $transaction->transaction_currency = $this->transaction_currency;
            $transaction->payment_status = $this->payment_status;
            $transaction->expenses = json_encode($this->expenses);
            // $transaction->other_payments = !empty($this->other_payments) ? $this->other_payments : 0;
            // $transaction->other_expenses = !empty($this->other_expenses) ? $this->other_expenses : 0;
            $transaction->grand_total = $this->num_uf($this->sum_total_cost());
            $transaction->final_total = isset($this->discount_amount) ? ($this->num_uf($this->sum_total_cost()) - $this->discount_amount) : $this->num_uf($this->sum_total_cost());
            $transaction->dollar_grand_total = $this->num_uf($this->sum_dollar_total_cost());
            $transaction->dollar_final_total = $this->num_uf($this->dollar_final_total());
            $transaction->dinar_remaining = $this->num_uf($this->dinar_remaining);
            $transaction->dollar_remaining = $this->num_uf($this->dollar_remaining);
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
//            dd($transaction->save());


            DB::beginTransaction();

            if ($this->files) {
                $transaction->file = store_file($this->files, 'stock_transaction');
            }

            $transaction->save();

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
//                dd($item['fill_quantity']);
                $add_stock_data = [
                    'variation_id' => $item['variation_id'] ?? null,
                    'product_id' => $item['product']['id'],
                    'stock_transaction_id' => $transaction->id ,
                    'quantity' => $this->num_uf($item['quantity']),
                    'purchase_price' => !empty($item['purchase_price']) ? $this->num_uf($item['purchase_price'])  : null ,
                    'final_cost' => !empty($item['total_cost']) ? $this->num_uf($item['total_cost'])  : 0,
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
                    'fill_quantity' => !empty($item['fill_quantity']) ? $this->num_uf($item['fill_quantity']): null,
                    'store_id'=> !empty($item['store_id']) ? ($item['store_id']): null,
                    'bonus_quantity' =>!empty($item['bonus_quantity']) ? ($item['bonus_quantity']): null,
                    'discount_percent' =>!empty($item['discount_percent']) ? ($item['discount_percent']): null,
                    'discount' =>!empty($item['discount']) ? ($item['discount']): null,
                    'cash_discount' =>!empty($item['cash_discount']) ? ($item['cash_discount']): null,
                    'seasonal_discount' =>!empty($item['seasonal_discount']) ? ($item['seasonal_discount']): null,
                    'annual_discount' =>!empty($item['annual_discount']) ? ($item['annual_discount']): null,
                    'discount_on_bonus_quantity' =>!empty($item['discount_on_bonus_quantity']) ? 1 : 0,
                    'discount_dependency' => !empty($item['discount_dependency']) ? 1 : 0,
//                    'bonus_quantity' =>!empty($item['bonus_quantity']) ? ($item['bonus_quantity']): null,
                    'notes' =>!empty($item['notes']) ? ($item['notes']): null,
                    'used_currency ' => !empty($item['used_currency']) ? $item['used_currency'] :null,

                ];
//                dd($add_stock_data);
                $stock_line = AddStockLine::create($add_stock_data);
                foreach ($item['customer_prices'] as $key => $price) {
                    if (!empty($price['dollar_sell_price']) || !empty($price['dinar_sell_price'])) {
                        $Variation_price = new VariationPrice();
                        $Variation_price->variation_id = $item['variation_id'];
                        $Variation_price->customer_type_id = $price['customer_type_id'] ?? null;
                        $Variation_price->dinar_sell_price = $this->num_uf($price['dinar_sell_price']) ?? null;
                        $Variation_price->dollar_sell_price = $this->num_uf($price['dollar_sell_price']) ?? null;
                        $Variation_price->percent = $price['percent'] ?? null;
                        $Variation_price->save();
                        $add_variation_stock_data = [
                            'variation_price_id' => $Variation_price->id,
                            'stock_line_id' => $stock_line->id,
                            'purchase_price' => ($item['used_currency'] != 2) ? $this->num_uf($item['purchase_price']) : null,
                            'sell_price' => ($item['used_currency'] != 2) ? $this->num_uf($price['dinar_sell_price'])  : 0,
                            'sub_total' => !empty($item['sub_total']) ? $this->num_uf((float)$item['sub_total']) : null,
                            'dollar_purchase_price' => ($item['used_currency'] == 2) ? $this->num_uf($item['purchase_price'])  : null,
                            'dollar_sell_price' => ($item['used_currency'] == 2) ? ($this->num_uf($price['dollar_sell_price']))  : 0,
                            'dollar_sub_total' => !empty($item['dollar_sub_total']) ? $this->num_uf($item['dollar_sub_total'])  : null,
                            // 'exchange_rate' => !empty($this->exchange_rate) ? $this->num_uf($this->exchange_rate)  : null,
                        ];
                         VariationStockline::create($add_variation_stock_data);
                    }
                }
//                dd($this->items[$index]);
                $this->updateProductQuantityStore($item['product']['id'],$item['variation_id'], $item['store_id'], $item['quantity']);
                if(!empty($item['stores'])){
                    foreach ($item['stores'] as $key => $item_store){
                        $this->addStockData($item_store,$transaction->id,$stock_line->used_currency,$index,$key);
                    }
                }
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
            DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'lang.success',]);
        }
        catch (\Exception $e){
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
        return redirect('/add-stock/create');
    }

    public function addStockData($item, $parent_transaction, $used_currency,$index,$i){
         $transaction = $this->addChildTransaction($parent_transaction,$this->items[$index]['stores'.$i]['store_id']);
        $add_stock_data = [
            'variation_id' => $item['variation_id'] ?? null,
            'product_id' => $item['product']['id'],
            'stock_transaction_id' => $transaction->id ,
            'quantity' => $this->num_uf($item['quantity']),
            'purchase_price' => !empty($item['purchase_price']) ? $this->num_uf($item['purchase_price'])  : 0 ,
            'final_cost' => !empty($item['total_cost']) ? $this->num_uf($item['total_cost'])  : 0,
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
            'fill_quantity' => !empty($item['fill_quantity']) ? $this->num_uf($item['fill_quantity']): null,
            'store_id'=> !empty($item['store_id']) ? ($item['store_id']): null,
            'bonus_quantity' =>!empty($item['bonus_quantity']) ? ($item['bonus_quantity']): null,
            'discount_percent' =>!empty($item['discount_percent']) ? ($item['discount_percent']): null,
            'discount' =>!empty($item['discount']) ? ($item['discount']): null,
            'cash_discount' =>!empty($item['cash_discount']) ? ($item['cash_discount']): null,
            'seasonal_discount' =>!empty($item['seasonal_discount']) ? ($item['seasonal_discount']): null,
            'annual_discount' =>!empty($item['annual_discount']) ? ($item['annual_discount']): null,
            'discount_on_bonus_quantity' =>!empty($item['discount_on_bonus_quantity']) ? ($item['discount_on_bonus_quantity']): null,
            'discount_dependency' =>!empty($item['discount_dependency']) ? ($item['discount_dependency']): null,
//            'bonus_quantity' =>!empty($item['bonus_quantity']) ? ($item['bonus_quantity']): null,
            'notes' =>!empty($item['notes']) ? ($item['notes']): null,
            'used_currency ' => !empty($used_currency) ? $used_currency : null,
        ];
        $stock_line = AddStockLine::create($add_stock_data);

        foreach ($item['customer_prices'] as $key => $price) {
            if (!empty($price['dollar_sell_price']) || !empty($price['dinar_sell_price'])) {
                $Variation_price = new VariationPrice();
                $Variation_price->variation_id = $item['variation_id'];
                $Variation_price->customer_type_id = $price['customer_type_id'] ?? null;
                $Variation_price->dinar_sell_price = $this->num_uf($price['dinar_sell_price']) ?? null;
                $Variation_price->dollar_sell_price = $this->num_uf($price['dollar_sell_price']) ?? null;
                $Variation_price->percent = $price['percent'] ?? null;
                $Variation_price->save();
                $add_variation_stock_data = [
                    'variation_price_id' => $Variation_price->id,
                    'stock_line_id' => $stock_line->id,
                    'purchase_price' => ($used_currency != 2) ? $this->num_uf($item['purchase_price']) : null,
                    'sell_price' => ($used_currency != 2) ? $this->num_uf($price['dinar_sell_price'])  : 0,
                    'sub_total' => !empty($item['sub_total']) ? $this->num_uf((float)$item['sub_total']) : null,
                    'dollar_purchase_price' => ($used_currency == 2) ? $this->num_uf($item['purchase_price'])  : null,
                    'dollar_sell_price' => ($used_currency == 2) ? ($this->num_uf($price['dollar_sell_price']))  : 0,
                    'dollar_sub_total' => !empty($item['dollar_sub_total']) ? $this->num_uf($item['dollar_sub_total'])  : null,
                    // 'exchange_rate' => !empty($this->exchange_rate) ? $this->num_uf($this->exchange_rate)  : null,
                ];
                VariationStockline::create($add_variation_stock_data);
            }
        }
        $this->updateProductQuantityStore($item['product']['id'],$item['variation_id'], $this->items[$index]['stores'.$i]['store_id'], $item['quantity']);

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
    public function addChildTransaction($parent,$store_id){
        $transaction = new StockTransaction();
        $transaction->store_id = $store_id;
        $transaction->status = 'received';
        $transaction->order_date = !empty($ref_transaction_po) ? $ref_transaction_po->transaction_date : Carbon::now();
        $transaction->transaction_date = !empty($this->transaction_date) ? $this->transaction_date : Carbon::now();
        $transaction->purchase_type = $this->purchase_type;
        $transaction->type = 'add_stock';
        $transaction->invoice_no = !empty($this->invoice_no) ? $this->invoice_no : null;
        $transaction->discount_amount = !empty($this->discount_amount) ? $this->discount_amount : 0;
        $transaction->supplier_id = $this->supplier;
        // $transaction->transaction_currency = $this->transaction_currency;
        $transaction->payment_status = $this->payment_status;
        $transaction->expenses = json_encode($this->expenses);
        // $transaction->other_payments = !empty($this->other_payments) ? $this->other_payments : 0;
        // $transaction->other_expenses = !empty($this->other_expenses) ? $this->other_expenses : 0;
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
        $transaction->parent_transction = $parent;
        $transaction->save();
        return $transaction;
    }

    public function add_product($id, $add_via = null, $index = null,$new_unit_raw=0){
        if(!empty($this->searchProduct)){
            $this->searchProduct = '';

        }
        if(!empty($this->search_by_product_symbol)){
            $this->search_by_product_symbol = '';

        }

        $product = Product::find($id);
        $stock = $product->stock_lines->last();
        $variations = $product->variations;
        if($add_via == 'unit'){
            $show_product_data = false;
            $this->addNewProduct($variations,$product,$show_product_data, $index, $stock);
        }
        else{
            if(!empty($this->items) && $new_unit_raw == 0){
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
                    $show_product_data = true;
                    $this->addNewProduct($variations,$product,$show_product_data,$index, $stock);
                }
            }
            else{
                $show_product_data = true;
                $this->addNewProduct($variations,$product,$show_product_data,$index, $stock);
            }
        }

    }

    public function addNewProduct($variations,$product,$show_product_data, $index = null, $stock){
        $current_stock = $product->stock_lines->sum('quantity', '-','quantity_sold');
        if(!empty($variations)){
            $variant = !empty($stock) ? Variation::find($stock->variation_id) : Variation::find($variations->first()->id??0);
        }
        $customer_prices = $this->addCustomersPrice();
          $new_item = [
            'show_product_data' => $show_product_data,
            'variations' => $variations,
            'variation_id' => !empty($stock) ? $stock->variation_id : ($variations->first()->id ?? null) ,
            'product' => $product,
            'purchase_price' =>  null,
            'dollar_purchase_price' =>  null,
            'purchase_price_span' => !empty($stock) ? $stock->purchase_price : null,
            'dollar_purchase_price_span' => !empty($stock) ? $stock->dollar_purchase_price : null,
            'dollar_selling_price' =>  null,
            'selling_price' =>  null,
            'selling_price_span' => !empty($stock) ? $stock->sell_price : null,
            'dollar_selling_price_span' => !empty($stock) ? $stock->dollar_sell_price : null,
            'quantity' => 1,
            'unit' => !empty($variant) ? $variant->unit->name : '',
            'base_unit_multiplier' => !empty($variant) ? $variant->equal : 0,
            'fill_type' => !empty($stock) ? $stock->fill_type : 'fixed',
            'sub_total' => 0,
            'dollar_sub_total' => 0,
            'size' => isset($variations->first()->id)?(!empty(!empty($product->product_dimensions->size) && $variations->first()->id===$product->product_dimensions->variation_id) ? $product->product_dimensions->size :0):0,
            'total_size' => isset($variations->first()->id)?(!empty(!empty($product->product_dimensions->size) && $variations->first()->id==$product->product_dimensions->variation_id) ? $product->product_dimensions->size * 1 :0):0,
            'weight' => isset($variations->first()->id)?(!empty(!empty($product->product_dimensions->weight) && $variations->first()->id==$product->product_dimensions->variation_id) ? $product->product_dimensions->weight :0):0,
            'total_weight' => isset($variations->first()->id)?(!empty(!empty($product->product_dimensions->weight) && $variations->first()->id==$product->product_dimensions->variation_id) ? $product->product_dimensions->weight * 1 :0):0,
            'dollar_cost' => 0,
            'cost' => 0,
            'dollar_total_cost' => 0,
            'total_cost' => 0,
            'current_stock' => $current_stock,
            'total_stock' => $current_stock + 1,
            'fill_quantity' => !empty($stock) ? $stock->fill_quantity : null,
            'used_currency' => null,
            'stores' => [],
            'store_id'=>null,
            'customer_prices' => $customer_prices,
            'units' => [],
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
                    'discount_from_original_price' => true,
                ],

            ],
        ];
        if(!empty($index)){
            array_splice($this->items, $index + 1, 0, [$new_item]);
        }else{
            $this->items[]= $new_item;
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
            'show_product_data' => 'false',
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
              'discount_from_original_price' => true,
          ];
        array_unshift($this->items[$index]['prices'], $new_price);
    }

    public function addCustomersPrice(){
        $customer_prices = [];

        foreach ($this->customer_types as $customer_type) {
            $new_price = [
                'customer_type_id' => $customer_type->id,
                'customer_name' => $customer_type->name,
                'percent' => null,
                'dollar_increase' => null,
                'dinar_increase' => null,
                'dollar_sell_price' => null,
                'dinar_sell_price' => null,
                'quantity' => null,
            ];
            array_unshift($customer_prices, $new_price);
        }
        return $customer_prices;
    }

    public function addStoreRow($index){
        $customer_prices = $this->addCustomersPrice();
        $new_store = [
            'variations' => $this->items[$index]['variations'],
            'variation_id' => null ,
            'product' => $this->items[$index]['product'],
            'purchase_price' =>  null,
            'dollar_purchase_price' =>  null,
            'purchase_price_span' => null,
            'dollar_purchase_price_span' =>  null,
            'dollar_selling_price' =>  null,
            'selling_price' =>  null,
            'selling_price_span' =>  null,
            'dollar_selling_price_span' =>  null,
            'quantity' => 1,
            'unit' =>  '',
            'base_unit_multiplier' =>  0,
            'fill_type' => 'fixed',
            'sub_total' => 0,
            'dollar_sub_total' => 0,
            'size' => 0,
            'total_size' => 0,
            'weight' => 0,
            'total_weight' => 0,
            'dollar_cost' => 0,
            'cost' => 0,
            'dollar_total_cost' => 0,
            'total_cost' => 0,
            'current_stock' => $this->items[$index]['current_stock'],
            'total_stock' => $this->items[$index]['current_stock'] + 1,
            'fill_quantity' =>  null,
            'used_currency' => null,
            'store_id' => null,
            'customer_prices' => $customer_prices,
            'units' => [],
        ];
//        dd($new_store);
        array_unshift($this->items[$index]['stores'], $new_store);
    }
    public function changePercent($index, $key, $via = null, $i = null)
    {
        if (!empty($this->items[$index]['used_currency'])) {
            if($via == 'stores'){
                $purchase_price = $this->final_purchase_for_piece($index,'stores',$i);
                $dollar_purchase_price =  $this->dollar_final_purchase_for_piece($index,'stores',$i);
                $percent = $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['percent']);
                if ($this->items[$index]['used_currency'] != 2) {
                    $this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase'] = ($purchase_price * $percent) / 100;
                    $this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase'])  / $this->num_uf($this->exchange_rate), 3);
                    $this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_sell_price'] = number_format($purchase_price + $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase']), 3);
                    $this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_sell_price'] = number_format(($purchase_price / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase']), 3);
                } else {
                    $this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase'] = ($dollar_purchase_price * $percent) / 100;
                    $this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase'])  * $this->num_uf($this->exchange_rate), 3);
                    $this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_sell_price'] = number_format(($dollar_purchase_price * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase']), 3);
                    $this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_sell_price'] = number_format($dollar_purchase_price + $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase']), 3);
                }
            }
            else{
                $purchase_price = $this->final_purchase_for_piece($index);
                $dollar_purchase_price =  $this->dollar_final_purchase_for_piece($index);
                $percent = $this->num_uf($this->items[$index]['customer_prices'][$key]['percent']);
                if ($this->items[$index]['used_currency'] != 2) {
                    $this->items[$index]['customer_prices'][$key]['dinar_increase'] = ($this->num_uf($purchase_price) * $this->num_uf($percent)) / 100;
                    $this->items[$index]['customer_prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->items[$index]['customer_prices'][$key]['dinar_increase'])  / $this->num_uf($this->exchange_rate), 3);
                    $this->items[$index]['customer_prices'][$key]['dinar_sell_price'] = number_format($this->num_uf($purchase_price) + $this->num_uf($this->items[$index]['customer_prices'][$key]['dinar_increase']), 3);
                    $this->items[$index]['customer_prices'][$key]['dollar_sell_price'] = number_format(($this->num_uf($purchase_price) / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->items[$index]['customer_prices'][$key]['dollar_increase']), 3);
                } else {
                    $this->items[$index]['customer_prices'][$key]['dollar_increase'] = ($this->num_uf($dollar_purchase_price) * $this->num_uf($percent)) / 100;
                    $this->items[$index]['customer_prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->items[$index]['customer_prices'][$key]['dollar_increase'])  * $this->num_uf($this->exchange_rate), 3);
                    $this->items[$index]['customer_prices'][$key]['dinar_sell_price'] = number_format(($this->num_uf($dollar_purchase_price) * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->items[$index]['customer_prices'][$key]['dinar_increase']), 3);
                    $this->items[$index]['customer_prices'][$key]['dollar_sell_price'] = number_format($this->num_uf($this->num_uf($dollar_purchase_price)) + $this->num_uf($this->items[$index]['customer_prices'][$key]['dollar_increase']), 3);
                }
            }
        }
    }
    public function changeIncrease($index, $key,$via = null,$i = null)
    {
        if($via == 'stores'){
            $purchase_price =  $this->final_purchase_for_piece($index,'stores',$i);
            $dollar_purchase_price =  $this->dollar_final_purchase_for_piece($index,'stores',$i);
            $percent = $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['percent']);
            if (!empty($this->items[$index]['used_currency'])) {
                if ($this->items[$index]['used_currency'] != 2) {
                    if ($percent == 0 || $percent == null) {
                        $this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase']) / $this->num_uf($this->exchange_rate), 3);
                        $this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_sell_price'] = number_format($purchase_price + $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase']), 3);
                        $this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_sell_price'] = number_format(($purchase_price / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase']), 3);
                    }
                } else {
                    if ($percent == 0 || $percent == null) {
                        $this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase']));
                        $this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase']) * $this->num_uf($this->exchange_rate));
                        $this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_sell_price'] = number_format(($dollar_purchase_price * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dinar_increase']), 3);
                        $this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_sell_price'] = number_format($dollar_purchase_price + $this->num_uf($this->items[$index]['stores'][$i]['customer_prices'][$key]['dollar_increase']), 3);
                    }
                }
            }
        }
        else{
            $purchase_price =  $this->final_purchase_for_piece($index);
            $dollar_purchase_price =  $this->dollar_final_purchase_for_piece($index);
            $percent = $this->num_uf($this->items[$index]['customer_prices'][$key]['percent']);
            if (!empty($this->items[$index]['used_currency'])) {
                if ($this->items[$index]['used_currency'] != 2) {
                    if ($percent == 0 || $percent == null) {
                        $this->items[$index]['customer_prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->items[$index]['customer_prices'][$key]['dinar_increase']) / $this->num_uf($this->exchange_rate), 3);
                        $this->items[$index]['customer_prices'][$key]['dinar_sell_price'] = number_format($purchase_price + $this->num_uf($this->items[$index]['customer_prices'][$key]['dinar_increase']), 3);
                        $this->items[$index]['customer_prices'][$key]['dollar_sell_price'] = number_format(($purchase_price / $this->num_uf($this->exchange_rate)) + $this->num_uf($this->items[$index]['customer_prices'][$key]['dollar_increase']), 3);
                    }
                } else {
                    if ($percent == 0 || $percent == null) {
                        $this->items[$index]['customer_prices'][$key]['dollar_increase'] = number_format($this->num_uf($this->items[$index]['customer_prices'][$key]['dinar_increase']));
                        $this->items[$index]['customer_prices'][$key]['dinar_increase'] = number_format($this->num_uf($this->items[$index]['customer_prices'][$key]['dinar_increase']) * $this->num_uf($this->exchange_rate));
                        $this->items[$index]['customer_prices'][$key]['dinar_sell_price'] = number_format(($dollar_purchase_price * $this->num_uf($this->exchange_rate)) + $this->num_uf($this->items[$index]['customer_prices'][$key]['dinar_increase']), 3);
                        $this->items[$index]['customer_prices'][$key]['dollar_sell_price'] = number_format($dollar_purchase_price + $this->num_uf($this->items[$index]['customer_prices'][$key]['dollar_increase']), 3);
                    }
                }
            }
        }

    }
    public function delete_price_raw($index,$key)
  {
      unset($this->items[$index]['prices'][$key]);
  }
    public function change_discount_from_original_price($index,$key)
    {
        if($this->items[$index]['prices'][$key]['discount_from_original_price']){
            $this->items[$index]['prices'][$key]['discount_from_original_price'] = !$this->items[$index]['prices'][$key]['discount_from_original_price'];
        }
//        $this->changePrice($index,$key);
    }
    public function changePrice($index,$key)
    {
        $discount_from_original_price = $this->items[$index]['prices'][$key]['discount_from_original_price'];
       $customer_type = $this->items[$index]['prices'][$key]['price_customer_types'];
       $customers_price = [];
        if(!empty($customer_type)){
            if($this->items[$index]['prices'][$key]['fill_id'] == $this->items[$index]['variation_id']){
                $customers_price = $this->items[$index]['customer_prices'];
            }
            else{
                if(!empty($this->items[$index]['stores'])){
                    foreach ($this->items[$index]['stores'] as $store){
                        if($store['variation_id'] == $this->items[$index]['prices'][$key]['fill_id'] ){
                            $customers_price = $store['customer_prices'];
                        }
                    }
                }
            }
            if(!empty($customers_price)){
                foreach( $customers_price  as $type){
                    if($type['customer_type_id'] == $customer_type ){
                        $sell_price = ($this->items[$index]['used_currency'] == 2) ? $type['dollar_sell_price'] : $type['dinar_sell_price'];
                    }
                }
                if(!empty($sell_price)){
                    $total_quantity = (float)$this->items[$index]['prices'][$key]['discount_quantity'] +(float)$this->items[$index]['prices'][$key]['bonus_quantity'];
                    if(!empty($this->items[$index]['prices'][$key]['price'])){
                        if (empty($discount_from_original_price) && !empty($this->items[$index]['prices'][$key]['discount_quantity'])){
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
                    if(empty($discount_from_original_price)){
                        $this->items[$index]['prices'][$key]['total_price'] = number_format((float)$price * (!empty($this->items[$index]['prices'][$key]['discount_quantity']) ? $this->items[$index]['prices'][$key]['discount_quantity'] : 1),3) ;
                        $this->items[$index]['prices'][$key]['piece_price'] = number_format($this->num_uf($this->items[$index]['prices'][$key]['total_price'])/(!empty($total_quantity) ? $total_quantity : 1),3) ;
                    }
                    else{
                        $this->items[$index]['prices'][$key]['total_price'] = number_format((float)$price * (!empty($this->items[$index]['prices'][$key]['discount_quantity']) ? (float)$this->items[$index]['prices'][$key]['discount_quantity'] : 1),3) ;
                        $this->items[$index]['prices'][$key]['piece_price'] = number_format((float)$this->items[$index]['prices'][$key]['total_price'] / (!empty($total_quantity) ? $total_quantity : 1),3) ;
                    }
                }
            }
        }
    }

    public function getVariationData($index,$via = null, $i = null){
        if($via == 'stores'){
            $variant = Variation::find($this->items[$index]['stores'][$i]['variation_id']);
            $product_data = Product::find($variant->product_id);
            $product = $this->items[$index]['stores'][$i]['product'];
            if(!empty($product_data->product_dimensions->variation_id) && $product_data->product_dimensions->variation_id==$variant->id){
                $this->items[$index]['stores'][$i]['size'] = !empty($product_data->product_dimensions->size) ? $product_data->product_dimensions->size : 0;
                $this->items[$index]['stores'][$i]['total_size'] = !empty($product_data->product_dimensions->size) ? $product_data->product_dimensions->size * 1 : 0;
                $this->items[$index]['stores'][$i]['weight'] = !empty($product_data->product_dimensions->weight) ? $product_data->product_dimensions->weight : 0;
                $this->items[$index]['stores'][$i]['total_weight'] =!empty($product_data->product_dimensions->weight) ? $product_data->product_dimensions->weight * 1 : 0;
            }else{
                $this->items[$index]['stores'][$i]['size'] = 0;
                $this->items[$index]['stores'][$i]['total_size'] = 0;
                $this->items[$index]['stores'][$i]['weight'] =0;
                $this->items[$index]['stores'][$i]['total_weight'] =0;
            }
            $this->items[$index]['unit'] = $variant->unit->name??'';
            $this->items[$index]['stores'][$i]['base_unit_multiplier'] = $variant->equal??0;

            $this->getSubUnits($index,'stores',$i);
        }
        else{
            $variant = Variation::find($this->items[$index]['variation_id']);
            $product_data = Product::find($variant->product_id);
            $product=$this->items[$index]['product'];
            if(!empty($product_data->product_dimensions->variation_id) && $product_data->product_dimensions->variation_id==$variant->id){
                $this->items[$index]['size'] = !empty($product_data->product_dimensions->size) ? $product_data->product_dimensions->size : 0;
                $this->items[$index]['total_size'] = !empty($product_data->product_dimensions->size) ? $product_data->product_dimensions->size * 1 : 0;
                $this->items[$index]['weight'] = !empty($product_data->product_dimensions->weight) ? $product_data->product_dimensions->weight : 0;
                $this->items[$index]['total_weight'] =!empty($product_data->product_dimensions->weight) ? $product_data->product_dimensions->weight * 1 : 0;
            }else{
                $this->items[$index]['size'] = 0;
                $this->items[$index]['total_size'] = 0;
                $this->items[$index]['weight'] =0;
                $this->items[$index]['total_weight'] =0;
            }
            $this->items[$index]['unit'] = $variant->unit->name??'';
            $this->items[$index]['base_unit_multiplier'] = $variant->equal??0;

            $this->getSubUnits($index);
        }

    //    dd($product_data->product_dimensions);
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

    public function sub_total($index, $via = null, $i = null)
    {
        if($via == 'stores'){
            // dd($via);
            // $this->convertPurchasePrice($index,$via,$i);
            if(isset($this->items[$index]['stores'][$i]['quantity']) && (isset($this->items[$index]['stores'][$i]['purchase_price']) ||isset($this->items[$index]['stores'][$i]['dollar_purchase_price']) )){
                // convert purchase price from Dollar To Dinar
                $purchase_price = $this->convertDollarPrice($index, $via ,$i);

                $this->items[$index]['stores'][$i]['sub_total'] = (int)$this->items[$index]['stores'][$i]['quantity'] * $this->num_uf($this->items[$index]['stores'][$i]['purchase_price'])  ;
                return number_format($this->items[$index]['stores'][$i]['sub_total'], 3);
            }
            else{
                $this->items[$index]['stores'][$i]['purchase_price'] = null;
            }
        }
        else {
            if(isset($this->items[$index]['quantity']) && (isset($this->items[$index]['purchase_price']) ||isset($this->items[$index]['dollar_purchase_price']) )){
                // convert purchase price from Dollar To Dinar
                // $purchase_price = $this->convertDollarPrice($index);

                $this->items[$index]['sub_total'] = (int)$this->items[$index]['quantity'] * $this->num_uf($this->items[$index]['purchase_price']) ;

                return number_format($this->items[$index]['sub_total'], 3);
            }
            else{
                $this->items[$index]['purchase_price'] = null;
            }
        }
        // $this->sum_total_cost();
//        $this->changeFilling($index);
        // $this->changeTotalAmount();

    }


    public function dollar_sub_total($index, $via = null, $i = null)
    {
        if($via == 'stores') {
            if(isset($this->items[$index]['stores'][$i]['quantity']) && isset($this->items[$index]['stores'][$i]['dollar_purchase_price']) || isset($this->items[$index]['stores'][$i]['purchase_price'])){
                // convert purchase price from Dinar To Dollar
                // $purchase_price = $this->convertDinarPrice($index, $via, $i);

                $this->items[$index]['stores'][$i]['dollar_sub_total'] = (int)$this->items[$index]['stores'][$i]['quantity'] * $this->num_uf( $this->items[$index]['stores'][$i]['dollar_purchase_price']);

                return number_format($this->items[$index]['stores'][$i]['dollar_sub_total'], 3);
            }
            else{
                $this->items[$index]['stores'][$i]['dollar_purchase_price'] = null;
            }
        }
        else{
            if(isset($this->items[$index]['quantity']) && isset($this->items[$index]['dollar_purchase_price']) || isset($this->items[$index]['purchase_price'])){
                // convert purchase price from Dinar To Dollar
                // $purchase_price = $this->convertDinarPrice($index);

                $this->items[$index]['dollar_sub_total'] = (int)$this->items[$index]['quantity'] * $this->num_uf( $this->items[$index]['dollar_purchase_price']);

                return number_format($this->items[$index]['dollar_sub_total'], 3);
            }
            else{
                $this->items[$index]['dollar_purchase_price'] = null;
            }
        }
//        $this->changeFilling($index);


    }
    // public function final_total(){

    // }

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
        $totalExpenses = 0;
        foreach ($this->expenses as $expense) {
            $totalExpenses += (float)$expense['amount'];
        }
        if($this->expenses_currency == 2){
            (float)$cost = ( (float)$totalExpenses ) * $this->num_uf($this->exchange_rate);
        }
        else{
            (float)$cost = (float)$totalExpenses ;
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

        $totalExpenses = 0;
        foreach ($this->expenses as $expense) {
            $totalExpenses += (float)$expense['amount'];
        }
        if($this->expenses_currency == 2){
            $dollar_cost = ( (float)$totalExpenses  ) * $this->num_uf($this->exchange_rate);
        }
        else{
            $dollar_cost = (float)$totalExpenses ;
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
        // dd('test');
        $totalCost = 0;
        if(!empty($this->items)) {

            foreach ($this->items as $item) {
                // dd($item['stores']);
                // dd($item['total_cost']);
                $totalCost += (float)$item['total_cost'];
                if(isset($item['stores']) && is_array($item['stores'])){
                    foreach ($item['stores'] as $store) {
                        // dd($store);
                        // Assuming 'total_cost' is the key for the total cost in each store
                        if(isset($store['total_cost'])){
                            // dd($store['total_cost']);
                            $totalCost += (float)$store['total_cost'];
                        }
                    }
                }

            }

            // foreach($this->items[] as $item){

            // }
        }
        $this->changeAmount(number_format($totalCost,3));
        // dd($this->num_uf($totalCost));
        return round_250($this->num_uf($totalCost));
    }

    public function sum_dollar_total_cost(){
        // dd('test');
        $totalDollarCost = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item) {
//                dd($item['dollar_total_cost']);
                $totalDollarCost += $item['dollar_total_cost'];
                if(isset($item['stores']) && is_array($item['stores'])){
                    foreach ($item['stores'] as $store) {
                        // Assuming 'total_cost' is the key for the total cost in each store
                        if(isset($store['dollar_total_cost'])){
                            // dd($store['dollar_total_cost']);
                            $totalDollarCost += (float)$store['dollar_total_cost'];
                            // dd($totalDollarCost );
                        }
                    }
                }
            }
        }
        $this->changeAmount(number_format($totalDollarCost,2));
    //    dd($totalDollarCost);
        return number_format($this->num_uf($totalDollarCost),2);
    }

    public function changeAmount($value){
        $this->amount = round_250($this->num_uf($value));
    }
    public function changeTotalAmount(){
        // if($this->paying_currency == 2){
            $totalExpenses=$this->num_uf($this->getTotalExpenses());
            $this->total_amount_dollar =$this->num_uf($this->sum_dollar_total_cost()) ;
            // $this->total_amount_dollar =$this->num_uf($this->sum_dollar_total_cost()) -$this->calcPayment();
        // }else{
            // $this->total_amount =$this->sum_total_cost() -$this->calcPayment();
            $this->total_amount =$this->sum_total_cost();
        // }
    }
    public function changeReceivedDollar()
    {
        if ($this->total_amount_dollar !== null && $this->total_amount_dollar !== 0) {
            if ($this->sum_total_cost() == 0 && $this->sum_dollar_total_cost() !== 0 && $this->total_amount_dollar !== 0 && $this->total_amount != 0) {
                // $diff_dollar = $this->total_amount_dollar -  $this->dollar_final_total;
                // $this->dinar_remaining = round_250($this->dinar_remaining - ( $diff_dollar * System::getProperty('dollar_exchange')));
                $this->dollar_remaining = $this->num_uf($this->sum_dollar_total_cost()) - ($this->num_uf($this->total_amount_dollar) + ($this->num_uf($this->total_amount) / System::getProperty('dollar_exchange')));
            } elseif ($this->sum_dollar_total_cost() == 0 && $this->sum_total_cost() !== 0 && $this->total_amount_dollar !== 0 && $this->total_amount != 0) {
                // $diff_dollar = $this->total_amount_dollar -  $this->dollar_final_total;
                // $this->dinar_remaining = round_250($this->dinar_remaining - ( $diff_dollar * System::getProperty('dollar_exchange')));
                $this->dinar_remaining = $this->num_uf($this->sum_total_cost()) - ($this->num_uf($this->total_amount) + ($this->num_uf($this->total_amount_dollar) * System::getProperty('dollar_exchange')));
            } elseif ($this->dinar_remaining > 0 && $this->sum_dollar_total_cost() !== null && $this->sum_dollar_total_cost() !== 0 && $this->total_amount_dollar > $this->sum_dollar_total_cost()) {
                $diff_dollar = $this->num_uf($this->total_amount_dollar) -  $this->num_uf($this->sum_dollar_total_cost());
                $this->dinar_remaining = round_250($this->num_uf($this->dinar_remaining) - ($this->num_uf($diff_dollar) * System::getProperty('dollar_exchange')));
                $this->dollar_remaining = 0;
            } else {
                // Check if total is in dinar and both dollar and dinar amounts are 0
                if ($this->sum_total_cost() != 0 && $this->sum_dollar_total_cost() == 0 && $this->num_uf($this->total_amount) == 0) {
                    // Round to the nearest 250 value
                    $rounded_final_total = round_250($this->num_uf($this->sum_total_cost()));
                    // Convert remaining dollar to dinar
                    $this->dinar_remaining = round_250($this->num_uf($rounded_final_total) - ($this->num_uf($this->total_amount_dollar) * System::getProperty('dollar_exchange')));
                }
                // Handle the case where total is in dollar and both dollar and dinar amounts are 0
                elseif ($this->sum_dollar_total_cost() != 0) {
                    // Calculate remaining dollar amount directly
                    $this->dollar_remaining = $this->num_uf($this->sum_dollar_total_cost()) - $this->num_uf($this->total_amount_dollar);
                    if ($this->sum_total_cost() != 0) {
                        $this->dinar_remaining = round_250($this->num_uf($this->sum_total_cost()) - $this->num_uf($this->total_amount));
                        if ($this->dinar_remaining < 0 &&  $this->dollar_remaining > 0) {
                            $diff_dinar = $this->num_uf($this->total_amount) -  $this->num_uf($this->sum_total_cost());
                            $this->dollar_remaining = $this->num_uf($this->dollar_remaining) - ($this->num_uf($diff_dinar) / System::getProperty('dollar_exchange'));
                            $this->dinar_remaining = 0;
                            // dd( $this->dollar_remaining);
                        }
                    }
                }
            }

        }
        // dd( $this->dollar_remaining);
    }

    public function changeReceivedDinar()
    {
        if ($this->total_amount !== null && $this->total_amount !== 0) {
            if ($this->sum_total_cost() == 0 && $this->sum_dollar_total_cost() !== 0 && $this->total_amount_dollar !== 0 && $this->total_amount != 0) {
                $this->dollar_remaining = $this->num_uf($this->sum_dollar_total_cost()) - ($this->num_uf($this->total_amount_dollar) + ($this->num_uf($this->total_amount) / System::getProperty('dollar_exchange')));
            } elseif ($this->sum_dollar_total_cost() == 0 && $this->sum_total_cost() !== 0 && $this->total_amount_dollar !== 0 && $this->total_amount != 0) {

                $this->dinar_remaining = $this->num_uf($this->sum_total_cost()) - ($this->num_uf($this->total_amount) + ($this->num_uf($this->total_amount_dollar) * System::getProperty('dollar_exchange')));
            } elseif ($this->dollar_remaining > 0 && $this->sum_total_cost() !== null && $this->sum_total_cost() !== 0 && $this->total_amount > $this->sum_total_cost()) {
                $diff_dinar = $this->num_uf($this->total_amount) -  $this->num_uf($this->sum_total_cost());
                $this->dollar_remaining = $this->num_uf($this->dollar_remaining) - ($this->num_uf($diff_dinar) / System::getProperty('dollar_exchange'));
                $this->dinar_remaining = 0;
            } else {
                // Check if total is in dollars and both dollar and dinar amounts are 0
                if ($this->sum_dollar_total_cost() != 0 && $this->sum_total_cost() == 0 && $this->total_amount_dollar == 0) {
                    // Calculate remaining dollar amount directly
                    $this->dollar_remaining = $this->num_uf($this->sum_dollar_total_cost()) - ($this->num_uf($this->total_amount) / System::getProperty('dollar_exchange'));
                }
                // Check if total is in dinars and both dollar and dinar amounts are 0
                elseif ($this->sum_total_cost() != 0) {
                    // Calculate remaining dinar amount
                    $this->dinar_remaining = round_250($this->num_uf($this->sum_total_cost())) - $this->num_uf($this->total_amount);

                    if ($this->sum_dollar_total_cost() != 0) {
                        $this->dollar_remaining = $this->num_uf($this->sum_dollar_total_cost()) - $this->num_uf($this->total_amount_dollar);
                        if ($this->dollar_remaining < 0 &&  $this->dinar_remaining > 0) {
                            $diff_dollar = $this->num_uf($this->total_amount_dollar) -  $this->num_uf($this->sum_dollar_total_cost());
                            $this->dinar_remaining = round_250($this->num_uf($this->dinar_remaining) - ($this->num_uf($diff_dollar) * System::getProperty('dollar_exchange')));
                            $this->dollar_remaining = 0;
                        }
                    }
                    // else{
                    //     $this->dollar_remaining = $this->dollar_final_total - ($this->total_amount_dollar + ($this->amount / System::getProperty('dollar_exchange')));
                    //     $this->dinar_remaining = $this->final_total - ($this->amount + ($this->total_amount_dollar * System::getProperty('dollar_exchange')));
                    // }
                    // Convert remaining dinar to dollars using the exchange rate
                    // $this->dollar_remaining = $this->dinar_remaining * System::getProperty('dollar_exchange');
                }
            }
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
    public function changeCurrentStock($index,$var = null, $i =null){
        if($var == 'stores'){
            $this->items[$index]['stores'][$i]['total_stock'] = $this->items[$index]['stores'][$i]['quantity'] + $this->items[$index]['stores'][$i]['current_stock'];
            // dd($this->items[$index]['total_stock']);
            $this->purchase_final($index ,$var, $i);
            if( $this->purchase_final($index,$var, $i) > 0){
                $this->final_purchase_for_piece($index,$var, $i);
            }
        }else{
            $this->items[$index]['total_stock'] = $this->items[$index]['quantity'] + $this->items[$index]['current_stock'];
            // dd($this->items[$index]['total_stock']);
            $this->purchase_final($index);
            if( $this->purchase_final($index) > 0){
                $this->final_purchase_for_piece($index);
            }
        }

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
    public function purchase_final($index ,$var = null, $i = null){
        if($var == 'stores'){
            $final_purchase = $this->num_uf($this->items[$index]['stores'][$i]['purchase_price']) ;
            // dd($this->items[$index]['stores'][$i]['bonus_quantity']);
            if(isset($this->items[$index]['stores'][$i]['bonus_quantity'])&&isset($this->items[$index]['stores'][$i]['discount_on_bonus_quantity']) && $this->items[$index]['stores'][$i]['discount_on_bonus_quantity'] == true){
                // dd($this->items[$index]['bonus_quantity']);
                $final_purchase =  $final_purchase * ($this->num_uf($this->items[$index]['quantity']) + $this->num_uf($this->items[$index]['bonus_quantity']));
                // dd($final_purchase);
            }else{
                $final_purchase =  $final_purchase * ($this->num_uf($this->items[$index]['stores'][$i]['quantity'] ));
            }
            if(isset($this->items[$index]['stores'][$i]['discount_dependency'])&& $this->items[$index]['stores'][$i]['discount_dependency'] == true){

                if(isset($this->items[$index]['stores'][$i]['discount_percent'])){
                    $final_purchase = round($final_purchase * (1 - $this->num_uf($this->items[$index]['stores'][$i]['discount_percent']) / 100), 2);
                }

                if(isset($this->items[$index]['stores'][$i]['discount'])){
                    $final_purchase -= $this->num_uf($this->items[$index]['discount']);
                }

                if(isset($this->items[$index]['stores'][$i]['cash_discount'])){
                    $final_purchase -= $this->num_uf($this->items[$index]['stores'][$i]['cash_discount']);
                }
                if($this->items[$index]['used_currency'] != 2){
                    $this->items[$index]['stores'][$i]['total_cost'] = $this->num_uf( $final_purchase);
                    $this->items[$index]['stores'][$i]['dollar_total_cost'] = 0;
                }else{
                    $this->items[$index]['stores'][$i]['dollar_total_cost'] =  $this->num_uf($final_purchase )/ $this->num_uf($this->exchange_rate);
                    $this->items[$index]['stores'][$i]['total_cost'] = 0;
                }

                if(isset($this->items[$index]['stores'][$i]['seasonal_discount'])){
                    $final_purchase = round($final_purchase * (1 - $this->num_uf($this->items[$index]['stores'][$i]['seasonal_discount'] )/ 100), 2);
                }

                if(isset($this->items[$index]['annual_discount'])){
                    $final_purchase = round($final_purchase * (1 - $this->num_uf($this->items[$index]['stores'][$i]['annual_discount']) / 100), 2);
                }
            }else{
                $original =$this->num_uf( $this->items[$index]['stores'][$i]['purchase_price']);
                // dd( $original);
                if(isset($this->items[$index]['stores'][$i]['bonus_quantity']) && isset($this->items[$index]['stores'][$i]['discount_on_bonus_quantity']) && $this->items[$index]['stores'][$i]['discount_on_bonus_quantity'] == true){
                    $original =  $original * ($this->num_uf($this->items[$index]['stores'][$i]['quantity']) + $this->num_uf($this->items[$index]['stores'][$i]['bonus_quantity']));
                }else{
                    $original =  $original * ($this->num_uf($this->items[$index]['stores'][$i]['quantity'] ));
                }
                $discount_percent = 0;
                $annual_discount = 0;
                $discount = 0;
                $cash_discount =0;
                $seasonal_discount = 0 ;
                if(isset($this->items[$index]['stores'][$i]['discount_percent'])){
                    $discount_percent = round($original * ( $this->num_uf($this->items[$index]['stores'][$i]['discount_percent']) / 100), 2);
                }

                if(isset($this->items[$index]['stores'][$i]['discount'])){
                    $discount =$this->num_uf( $this->items[$index]['stores'][$i]['discount']);
                }

                if(isset($this->items[$index]['stores'][$i]['cash_discount'])){
                    $cash_discount =  $this->num_uf($this->items[$index]['stores'][$i]['cash_discount']);
                }
                if($this->items[$index]['used_currency'] != 2){
                    $this->items[$index]['stores'][$i]['total_cost'] = $this->num_uf( $final_purchase);
                    $this->items[$index]['stores'][$i]['dollar_total_cost'] = 0;
                }else{
                    $this->items[$index]['stores'][$i]['total_cost'] = 0;
                    $this->items[$index]['stores'][$i]['dollar_total_cost'] =  $this->num_uf($final_purchase )/ $this->num_uf($this->exchange_rate);
                }

                if(isset($this->items[$index]['stores'][$i]['seasonal_discount'])){
                    $seasonal_discount =$this->num_uf( round($original * ($this->num_uf($this->items[$index]['stores'][$i]['seasonal_discount'] )/ 100), 2));
                }

                if(isset($this->items[$index]['stores'][$i]['annual_discount'])){
                    $annual_discount = round($original * ( $this->num_uf($this->items[$index]['stores'][$i]['annual_discount'] )/ 100), 2);
                }

                $final_purchase = $original - ( $discount_percent + $discount + $cash_discount + $seasonal_discount + $annual_discount );
                // dd( $final_purchase);
            }
            // dd( $final_purchase);
            if(isset($this->items[$index]['stores'][$i]['discount_on_bonus_quantity']) && $this->items[$index]['stores'][$i]['discount_on_bonus_quantity'] == false && isset($this->items[$index]['stores'][$i]['bonus_quantity']) ){
                $final_purchase = $final_purchase + ($this->num_uf($this->items[$index]['stores'][$i]['bonus_quantity'])* $this->num_uf($this->items[$index]['stores'][$i]['purchase_price']));
            }
            return $final_purchase;
            if( $this->purchase_final($index,$var,$i) > 0){
                $this->final_purchase_for_piece($index,$var,$i);
            }
        }else{
            $final_purchase = $this->num_uf($this->items[$index]['purchase_price']) ;
            // dd($this->items[$index]['bonus_quantity']);
            if(isset($this->items[$index]['discount_on_bonus_quantity']) && $this->items[$index]['discount_on_bonus_quantity'] == true && isset($this->items[$index]['bonus_quantity'])){
                // dd($this->items[$index]['bonus_quantity']);
                $final_purchase =  $final_purchase * ($this->num_uf($this->items[$index]['quantity']) + $this->num_uf($this->items[$index]['bonus_quantity']));
                // dd($final_purchase);
            }else{
                $final_purchase =  $final_purchase * ($this->num_uf($this->items[$index]['quantity'] ));
            }
            if(isset($this->items[$index]['discount_dependency'])&& $this->items[$index]['discount_dependency'] == true){

                if(isset($this->items[$index]['discount_percent'])){
                    $final_purchase = round($final_purchase * (1 - $this->num_uf($this->items[$index]['discount_percent']) / 100), 2);
                }

                if(isset($this->items[$index]['discount'])){
                    $final_purchase -= $this->num_uf($this->items[$index]['discount']);
                }

                if(isset($this->items[$index]['cash_discount'])){
                    $final_purchase -= $this->num_uf($this->items[$index]['cash_discount']);
                }
                if($this->items[$index]['used_currency'] != 2){
                    $this->items[$index]['total_cost'] = $this->num_uf( $final_purchase);
                    $this->items[$index]['dollar_total_cost'] = 0;
                    // dd($this->items[$index]['total_cost']);
                }else{
                    $this->items[$index]['total_cost'] =0;
                    $this->items[$index]['dollar_total_cost'] =  $this->num_uf($final_purchase )/ $this->num_uf($this->exchange_rate);
                }
                if(isset($this->items[$index]['seasonal_discount'])){
                    $final_purchase = round($final_purchase * (1 - $this->num_uf($this->items[$index]['seasonal_discount'] )/ 100), 2);
                }

                if(isset($this->items[$index]['annual_discount'])){
                    $final_purchase = round($final_purchase * (1 - $this->num_uf($this->items[$index]['annual_discount']) / 100), 2);
                }
            }else{
                $original =$this->num_uf( $this->items[$index]['purchase_price']);
                // dd( $original);
                if(isset($this->items[$index]['bonus_quantity']) && isset($this->items[$index]['discount_on_bonus_quantity']) && $this->items[$index]['discount_on_bonus_quantity'] == true){
                    $original =  $original * ($this->num_uf($this->items[$index]['quantity']) + $this->num_uf($this->items[$index]['bonus_quantity']));
                }else{
                    $original =  $original * ($this->num_uf($this->items[$index]['quantity'] ));
                }
                $discount_percent = 0;
                $annual_discount = 0;
                $discount = 0;
                $cash_discount =0;
                $seasonal_discount = 0 ;
                if(isset($this->items[$index]['discount_percent'])){
                    $discount_percent = round($original * ( $this->num_uf($this->items[$index]['discount_percent']) / 100), 2);
                }

                if(isset($this->items[$index]['discount'])){
                    $discount =$this->num_uf( $this->items[$index]['discount']);
                    if($this->items[$index]['used_currency']==2){
                        $discount=$this->num_uf($discount) * $this->num_uf($this->exchange_rate);
                    }
                }

                if(isset($this->items[$index]['cash_discount'])){
                    $cash_discount =  $this->num_uf($this->items[$index]['cash_discount']);
                }
                if($this->items[$index]['used_currency'] != 2){
                    $this->items[$index]['total_cost'] = $this->num_uf( $final_purchase);
                    $this->items[$index]['dollar_total_cost'] = 0 ;
                    // dd($this->items[$index]['total_cost']);
                }else{
                    $this->items[$index]['total_cost'] = 0;
                    $this->items[$index]['dollar_total_cost'] =  $this->num_uf($final_purchase )/ $this->num_uf($this->exchange_rate);
                }
                if(isset($this->items[$index]['seasonal_discount'])){
                    $seasonal_discount =$this->num_uf( number_format($original * ($this->num_uf($this->items[$index]['seasonal_discount'] )/ 100), 2));
                }

                if(isset($this->items[$index]['annual_discount'])){
                    $annual_discount = number_format($original * ( $this->num_uf($this->items[$index]['annual_discount'] )/ 100), 2);
                }
                // dd($discount );
                $final_purchase = $original - $this->num_uf($this->items[$index]['quantity'])*( $discount_percent + $discount + $cash_discount + $seasonal_discount + $annual_discount );
                // dd( $final_purchase);
            }
            // dd( $final_purchase);
            if(isset($this->items[$index]['discount_on_bonus_quantity']) && $this->items[$index]['discount_on_bonus_quantity'] == false && isset($this->items[$index]['bonus_quantity']) ){
                $final_purchase = $final_purchase + ($this->num_uf($this->items[$index]['bonus_quantity'])* $this->num_uf($this->items[$index]['purchase_price']));
            }
            return number_format($final_purchase,3);
            if( $this->purchase_final($index) > 0){
                $this->final_purchase_for_piece($index);
            }
        }


    }
    public function purchase_final_dollar($index,$var=null,$i=null){
        if($var == 'stores'){
            $dollar =number_format($this->num_uf($this->purchase_final($index,$var,$i)) / $this->num_uf($this->exchange_rate),3);
            return $dollar;
        }else{
            $dollar = number_format($this->num_uf($this->purchase_final($index)) / $this->num_uf($this->exchange_rate)  ,3);
            return $dollar;
        }

    }

    public function final_purchase_for_piece($index,$var=null,$i=null){
        if($var=='stores'){
            if( $this->purchase_final($index,$var,$i) > 0){
                if(isset($this->items[$index]['stores'][$i]['bonus_quantity'])){
                    $final_purchase_for_piece =   $this->purchase_final($index,$var,$i) / ($this->num_uf($this->items[$index]['stores'][$i]['bonus_quantity']) + $this->num_uf($this->items[$index]['quantity']));
                 }else{
                     $final_purchase_for_piece =   $this->purchase_final($index,$var,$i) / $this->num_uf($this->items[$index]['stores'][$i]['quantity']);
                 }
                 return   number_format($final_purchase_for_piece,3);
            }
        }else{
            if( $this->purchase_final($index) > 0){
                if(isset($this->items[$index]['bonus_quantity'])){
                    $final_purchase_for_piece =   $this->purchase_final($index) / ($this->num_uf($this->items[$index]['bonus_quantity']) + $this->num_uf($this->items[$index]['quantity']));
                 }else{
                     $final_purchase_for_piece =   $this->num_uf($this->purchase_final($index)) / $this->num_uf($this->items[$index]['quantity']);
                 }
                 return   number_format($final_purchase_for_piece,3);
            }
        }


    }

    public function dollar_final_purchase_for_piece($index,$var=null,$i=null){
        if($var=='stores'){
            $dollar =  $this->num_uf($this->final_purchase_for_piece($index,$var,$i))  / $this->num_uf($this->exchange_rate);
            return number_format($dollar,3);
        }else{
            $dollar =  $this->num_uf($this->final_purchase_for_piece($index))  / $this->num_uf($this->exchange_rate);
            return number_format($dollar,3);
        }


    }

    public function delete_product($index, $via = null, $i = null){
        if($via == 'stores'){
            unset($this->items[$index]['stores'][$i]);
        }
        else{
            unset($this->items[$index]);
        }
    }

    public function countItems(){
        $count = 0;
        if (!empty($this->items)){
            $collection = collect($this->items);
            // Filter out elements where show_product_data is false
            $filteredCollection = $collection->filter(function ($item) {
                return $item['show_product_data'] !== false;
            });
            $count = $filteredCollection->count();
        }
        return $count;
    }

    public function countUnitsItems(){
        $count = 0;
        if (!empty($this->items)){
            $collection = collect($this->items);
            // Filter out elements where show_product_data is false
            $filteredCollection = $collection->filter(function ($item) {
                return $item['show_product_data'] == false;
            });
            $count = $filteredCollection->count();
        }
        return $count;
    }

    public function count_total_by_variations(){
        $this->variationSums = [];
        foreach ($this->items as $item) {
            $variation_name = $item['unit'];

            if (isset($this->variationSums[$variation_name])) {
                // If the variation_id already exists in the sums array, add the quantity
                $this->variationSums[$variation_name] += (float)$item['quantity'];
            } else {
                // If the variation_id doesn't exist, create a new entry
                $this->variationSums[$variation_name] = (float)$item['quantity'];
            }
        }
//        dd($this->variationSums);
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

    public function convertDollarPrice($index, $via = null, $i = null ){
        if($via == 'stores'){
            if(empty($this->items[$index]['stores'][$i]['purchase_price']) && !empty($this->items[$index]['stores'][$i]['dollar_purchase_price'])){
                $purchase_price = (float)$this->items[$index]['stores'][$i]['dollar_purchase_price'] * $this->num_uf($this->exchange_rate);
            }
            else{
                $purchase_price = $this->items[$index]['stores'][$i]['purchase_price'] ?? '';
            }
        }
        else{
            if(empty($this->items[$index]['purchase_price']) && !empty($this->items[$index]['dollar_purchase_price'])){
                $purchase_price = (float)$this->items[$index]['dollar_purchase_price'] * $this->num_uf($this->exchange_rate);
            }
            else{
                $purchase_price = $this->items[$index]['purchase_price'] ?? '';
            }
        }

        return $purchase_price;
    }

    public function convertDinarPrice($index, $via = null, $i = null)
    {
        if($via == 'stores'){
            if (!empty($this->items[$index]['stores'][$i]['purchase_price']) && empty($this->items[$index]['stores'][$i]['dollar_purchase_price'])) {
                $purchase_price = $this->items[$index]['stores'][$i]['purchase_price'] / $this->num_uf($this->exchange_rate);
            }
            else {
                $purchase_price = $this->items[$index]['stores'][$i]['dollar_purchase_price'] ?? '';
            }
        }
        else{
            if (!empty($this->items[$index]['purchase_price']) && empty($this->items[$index]['dollar_purchase_price'])) {
                $purchase_price = $this->items[$index]['purchase_price'] / $this->num_uf($this->exchange_rate);
            }
            else {
                $purchase_price = $this->items[$index]['dollar_purchase_price'] ?? '';
            }
        }

        return $purchase_price;

    }

    public function convertPurchasePrice($index,$var=null,$i=null){
        // dd($i);
        if($var == 'stores'){
            $actual_purchase_price =$this->num_uf( $this->items[$index]['stores'][$i]['purchase_price']);
            // dd($actual_purchase_price);
            if(!empty($this->items[$index]['used_currency'])){
                $currency = $this->num_uf( $this->items[$index]['used_currency']);
                if( $currency == 2 ){
                    $this->items[$index]['stores'][$i]['dollar_purchase_price'] = $this->num_uf( $actual_purchase_price );
                    $this->items[$index]['stores'][$i]['purchase_price'] = $this->num_uf( $actual_purchase_price )*$this->num_uf( $this->exchange_rate) ?? 0;
                    // dd($actual_purchase_price);

                }else{
                    $this->items[$index]['stores'][$i]['dollar_purchase_price']=$this->num_uf(  $actual_purchase_price )/  $this->num_uf( $this->exchange_rate);
                    $this->items[$index]['stores'][$i]['purchase_price']= $this->num_uf( $actual_purchase_price) ?? 0;
                }
                // dd($this->items[$index]['purchase_price']);
                // $this->items[$index]['dollar_purchase_price']);
            }

            $this->purchase_final($index,$var,$i);
            if( $this->purchase_final($index,$var,$i) > 0){
                $this->final_purchase_for_piece($index,$var,$i);
            }
        }else{
            $actual_purchase_price =$this->num_uf(  $this->items[$index]['purchase_price']);
            if(!empty($this->items[$index]['used_currency'])){
                $currency = $this->num_uf( $this->items[$index]['used_currency']);
                if( $currency == 2 ){
                    $this->items[$index]['dollar_purchase_price'] = $this->num_uf( $actual_purchase_price );
                    $this->items[$index]['purchase_price'] = $this->num_uf( $actual_purchase_price )*$this->num_uf( $this->exchange_rate) ?? 0;

                }else{
                    $this->items[$index]['dollar_purchase_price']=$this->num_uf(  $actual_purchase_price )/  $this->num_uf( $this->exchange_rate);
                    $this->items[$index]['purchase_price']= $this->num_uf( $actual_purchase_price) ?? 0;
                }
                // dd($this->items[$index]['purchase_price'],
                // $this->items[$index]['dollar_purchase_price']);
            }

            $this->purchase_final($index);
            if( $this->purchase_final($index) > 0){
                $this->final_purchase_for_piece($index);
            }
        }
        $this->changeTotalAmount();


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
//        dd($store_id);
        $product_store = ProductStore::where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->first();
        $product_variations = Variation::where('product_id',$product_id)->get();
        $unit = Variation::where('id',$variation_id)->first();
        $qty_difference = 0;
        $qtyByUnit = 1 ;
        if(!empty($product_store) && !empty($product_store->variation_id)){
            $store_variation = Variation::find($product_store->variation_id);
            if(isset($unit->unit_id) && $store_variation->unit_id == $unit->unit_id){
                $qty_difference = $new_quantity;
            }
            elseif(isset($unit->unit_id) && $store_variation->basic_unit_id == $unit->unit_id){
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
        $totalExpenses = 0;
        foreach ($this->expenses as $expense) {
            $totalExpenses += (float)$expense['amount'];
        }
        if($this->expenses_currency == 2){
            (float)$cost = ( (float)$totalExpenses ) * $this->num_uf($this->exchange_rate);
        }
        else{
            (float)$cost = (float)$totalExpenses ;
        }
    //    $otherExpenses = is_numeric($this->other_expenses) ? (float)$this->other_expenses : 0;
       $discountAmount = is_numeric($this->discount_amount) ? (float)$this->discount_amount : 0;
    //    $otherPayments = is_numeric($this->other_payments) ? (float)$this->other_payments : 0;
       return ( $discountAmount + $totalExpenses );
    }
    public function getSubUnits($index, $via = null, $i = null){
        $units = [];
        $qtyByUnit = 1;
        $qty=1;
        if($via == 'stores'){
            $product_variations = Variation::where('product_id',$this->items[$index]['stores'][$i]['product']['id'])->get();
            $variation = Variation::find($this->items[$index]['stores'][$i]['variation_id']);
        }
        else {
            $product_variations = Variation::where('product_id', $this->items[$index]['product']['id'])->get();
            $variation = Variation::find($this->items[$index]['variation_id']);
        }
        foreach ($product_variations as $key => $product_variation) {
            if (!empty($product_variation['unit_id'])) {
                if( $variation->id == $product_variation->id  ){
                    $unitName =  $variation->basic_unit->name ?? '';
                    $units[$unitName] =  $product_variation['equal'];
                }
                else if(!empty($product_variation->basic_unit_id) && $variation->basic_unit_id == $product_variation['unit_id'] ){
                    $unitName =   $product_variation['basic_unit']['name'] ?? '';
                    if($product_variation->basic_unit_id != $variation->unit_id ){
                        $units[$unitName] =  $product_variation['equal'] * $variation->equal;
                        $qtyByUnit = $product_variation['equal'] * $variation->equal;
                    }
                }
                else if (isset($product_variations[$key + 1]) && $product_variation->basic_unit_id  == $product_variations[$key + 1]['unit_id'] ){
                    $unitName =   $product_variation->basic_unit->name  ?? '';
                    if($product_variation->basic_unit_id != $variation->unit_id ) {
                        $units[$unitName] = $product_variation['equal'] * $qtyByUnit;
                    }
                }
                if (!empty($product_variations[$key-1])){
                    if($variation->unit_id == $product_variations[$key-1]->basic_unit_id){
                        $qty = 1 / $product_variations[$key-1]->equal;
                        $units[$product_variations[$key-1]->unit->name] = $qty;
                    }
                    if(!empty($product_variations[$key-2])){
                        $i = $key-2;
                        do{
                            if($product_variations[$i]->basic_unit_id == $product_variations[$i+1]->unit_id){
                                if($variation->unit_id != $product_variations[$i]->unit_id && !isset($units[$product_variations[$i]->unit->name])){
                                    $qty *= 1/$product_variations[$i]->equal;
                                    $units[$product_variations[$i]->unit->name] = $qty ;
                                }
                            }
                            $i--;
                        }while ($i >= 0);
                    }
                }
            }
        }
        if($via == 'stores'){
            $this->items[$index]['stores'][$i]['units'] = $units;
        }
        else{
            $this->items[$index]['units'] = $units;
        }
    }
}
