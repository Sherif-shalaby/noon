<?php

namespace App\Http\Livewire\InitialBalance;

use App\Models\AddStockLine;
use App\Models\Brand;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Currency;
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
use App\Models\Unit;
use App\Models\User;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Create1 extends Component
{
    use WithPagination;
    public $item=[['id','name' => '',
    'store_id' => '',
    'supplier_id' => '',
    'category_id'=>'',
    'subcategory_id1'=>'',
    'subcategory_id2'=>'',
    'subcategory_id3'=>'',
    'weight' => 0,
    'width' => 0,
    'height' =>0,
    'length'=>0,
    'size' => 0,
    'isExist'=>0,'status'=>'',
    'divide_costs'=>'','change_current_stock'=>0,'exchange_rate'=>0,'divide_costs'=>'']
    ];
    public $subcategories1=[],$subcategories2=[],$subcategories3=[];
    public $selectedProducts = [], $selectedProductData = [],$quantity = [], $purchase_price =[], $selling_price = [],
        $base_unit = [], $divide_costs , $other_expenses = 0, $other_payments = 0, $total_size = [], $total_weight =[],
        $cost = [], $total_cost = [], $sub_total = [], $change_price_stock =[], $store_id, $status, $order_date,
        $purchase_type, $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $exchange_rate,$exchangeRate,
        $amount, $method, $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date,
        $dollar_purchase_price = [], $dollar_selling_price =[], $dollar_sub_total = [], $dollar_cost = [], $dollar_total_cost = [],
        $showColumn = true, $transaction_currency, $current_stock,$searchProduct,$totalQuantity=0,$edit_product=[] ;

    public $rows = [];
    protected $rules = [
        'item.*.name' => 'required|unique:products,sku',
        'item.*.store_id' => 'required',
        'item.*.supplier_id' => 'required',
        'item.*.category_id' => 'required',
        'item.*.subcategory_id' => 'nullable',
        'item.*.subcategory_id2' => 'nullable',
        'item.*.subcategory_id3' => 'nullable',
        'item.*.weight' => 'numeric',
        'item.*.width' => 'numeric',
        'item.*.height' => 'numeric',
        'item.*.length' => 'numeric',
        'item.*.size' => 'numeric',
        'item.*.divide_costs' => 'required',
        'item.*.status' => 'required',
        'item.*.change_current_stock' => 'boolean',
        'item.*.exchange_rate' => 'numeric',
        'rows.*.sku' => 'required|unique:variations,sku',
    ];
    public function changeSize(){
        $this->item[0]['size']=$this->item[0]['height'] * $this->item[0]['length'] * $this->item[0]['width'];
    }
    protected $listeners = ['listenerReferenceHere','create','cancelCreateProduct'];

    public function listenerReferenceHere($data)
    {
        if(isset($data['var1'])){
            if(($data['var1']=="unit_id" || $data['var1']=="basic_unit_id") && $data['var3']!==''){
                $this->rows[$data['var3']][$data['var1']]=$data['var2'];
            }else{
                $this->item[0][$data['var1']]=$data['var2'];
                if($data['var1']=='category_id'){
                    $this->subcategories1 = Category::where('parent_id',$this->item[0]['category_id'])->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if($data['var1']=='subcategory_id1'){
                    $this->subcategories2 = Category::where('parent_id',$this->item[0]['subcategory_id1'])->orderBy('name', 'asc')->pluck('name', 'id');
                }
                if($data['var1']=='subcategory_id2'){
                    $this->subcategories3 = Category::where('parent_id',$this->item[0]['subcategory_id2'])->orderBy('name', 'asc')->pluck('name', 'id');
                }
            }
        }
    }
    public function render()
    {
        $status_array = $this->getPurchaseOrderStatusArray();
        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $product_id = request()->get('product_id');
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $categories = Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        $products = Product::all();
        $stores = Store::getDropdown();
        $search_result = '';
        if(!empty($this->searchProduct)){
            $search_result = Product::when($this->searchProduct,function ($query){
                return $query->where('name','like','%'.$this->searchProduct.'%');
            });
            $search_result = $search_result->paginate();
            if(count($search_result) === 1){
                $this->fetchProduct($search_result->first()->id);
                $search_result = '';
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

        // $this->changeExchangeRate();
        $units=Unit::orderBy('created_at', 'desc')->get();
        $basic_units=Unit::orderBy('created_at', 'desc')->pluck('name', 'id');
        // $this->unit_name=Unit::find($this->item[0]['unit_id'])->name??'';
        $this->dispatchBrowserEvent('initialize-select2');

        return view('livewire.initial-balance.create',
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
                'search_result',
                'users','units','basic_units','categories')
        );
    }
    public function mount()
    {
        $this->exchange_rate=$this->changeExchangeRate();
        $this->dispatchBrowserEvent('initialize-select2');
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function calculateTotalQuantity()
    {
        $this->totalQuantity=0;
        foreach ($this->rows as $index=>$row) {
            $this->totalQuantity += (int)$this->rows[$index]['quantity'];
        }
    }
    // public function checkSku($index){

    //     $variation=Variation::where('sku',$this->rows[$index]['sku'])->first();
    //     if(!empty($variation)){
    //         $this->rows[$index]['skuExist']=1;
    //         $this->dispatchBrowserEvent('swal:modal', ['type' => 'warning','message' => __('lang.this_product_exists_before')]);
    //     }
    // }
    public function addRaw(){
    $newRow = ['id'=>'','sku' => '','quantity' => '',
    'fill_quantity' => '',
    'fill_type' => 'fixed',
    'purchase_price'=>'',
    'selling_price'=>'',
    'dollar_purchase_price'=>'',
    'dollar_selling_price'=>'',
    'unit_id'=>'',
    'basic_unit_id'=>'',
    'change_price_stock'=>'',
    // 'skuExist'=>0,
    'equal'=>'',
    ];
    array_unshift($this->rows, $newRow);
    }
    public function changeUnit($index){
        $unit=$this->rows[$index]['unit_id'];
        $unit_index='';
        foreach ($this->rows as $i => $item) {
            if ($item['basic_unit_id'] === $unit) {
                $unit_index=$i;
                break; 
            }
        }
        if($unit_index!==''){
            $this->rows[$index]['equal']=1;
            $this->rows[$index]['fill_type']=$this->rows[$unit_index]['fill_type'];
            $this->rows[$index]['purchase_price']=(float)$this->rows[$unit_index]['purchase_price']/(float)$this->rows[$unit_index]['equal'];
            $this->rows[$index]['selling_price']=(float)$this->rows[$unit_index]['selling_price']/(float)$this->rows[$unit_index]['equal'];
            $this->rows[$index]['dollar_purchase_price']=(float)$this->rows[$unit_index]['dollar_purchase_price']/(float)$this->rows[$unit_index]['equal'];
            $this->rows[$index]['dollar_selling_price']=(float)$this->rows[$unit_index]['dollar_selling_price']/(float)$this->rows[$unit_index]['equal'];
        }
    }
    public function store() 
    // : Redirector|Application|RedirectResponse
    {
        // dd($this->sub_total[0]);
    //    dd($this->rows);
        // if (!empty($this->other_expenses) || !empty($this->other_payments)){
        //     $this->rules = [
        //         'item.*.store_id' => 'required',
        //         'item.*.supplier' => 'required',
        //         'item.*.status' => 'required',
        //         // 'paying_currency' => 'required',
        //         // 'purchase_type' => 'required',
        //         'item.*.divide_costs' => 'required',
        //         // 'payment_status' => 'required',
        //         // 'method' => 'required',
        //         // 'amount' => 'required',
        //     ];
        // }
        $this->validate();

        // try {
         if(empty($this->rows)){
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => __('lang.add_sku_with_sku_for_product'),]);
        }else{
            // Add stock transaction
            $transaction = new StockTransaction();
            $transaction->store_id = $this->item[0]['store_id'];
            $transaction->status = !empty($this->item[0]['status']) ? $this->item[0]['status'] : 'received';
            $transaction->order_date = Carbon::now();
            $transaction->transaction_date =  Carbon::now();
            $transaction->purchase_type = 'local';
            $transaction->type ='initial_balance' ;
            $transaction->supplier_id = !empty($this->item[0]['supplier_id']) ? $this->item[0]['supplier_id'] : null;
            $transaction->grand_total = array_sum($this->total_cost);
            $transaction->final_total = isset($this->discount_amount) ? (array_sum($this->total_cost) - $this->discount_amount) : array_sum($this->total_cost);
            // $transaction->dollar_grand_total = $this->sum_dollar_total_cost();
            // $transaction->dollar_final_total = $this->dollar_final_total();
            $transaction->created_by = Auth::user()->id;
            $transaction->divide_costs = !empty($this->divide_costs) ? $this->divide_costs : null;
            $transaction->save();
            //Add Product 
            $product=[];  
            if($this->item[0]['isExist']==1){
                $product=Product::find($this->item[0]['id']);
                $product->sku="Default";
                $product->category_id=$this->item[0]['category_id'];
                $product->subcategory_id1=$this->item[0]['subcategory_id1'];
                $product->subcategory_id2=$this->item[0]['subcategory_id2'];
                $product->subcategory_id3=$this->item[0]['subcategory_id3'];
                $product->height=$this->item[0]['height'];
                $product->length=$this->item[0]['length'];
                $product->width=$this->item[0]['width'];
                $product->weight=$this->item[0]['weight'];
                $product->size=$this->item[0]['size'];
                $product->save();
                $product->variations()->delete();
            }else{
                $product=new Product();
                $product->name=$this->item[0]['name'];
                $product->sku="Default";
                $product->category_id=$this->item[0]['category_id'];
                $product->subcategory_id1=$this->item[0]['subcategory_id1'];
                $product->subcategory_id2=$this->item[0]['subcategory_id2'];
                $product->subcategory_id3=$this->item[0]['subcategory_id3'];
                $product->height=$this->item[0]['height'];
                $product->length=$this->item[0]['length'];
                $product->width=$this->item[0]['width'];
                $product->weight=$this->item[0]['weight'];
                $product->size=$this->item[0]['size'];
                $product->save();
            }
            // add  products to stock lines
            foreach ($this->rows as $index => $row){
                
                // if($this->rows[$index]['skuExist']!==1){
                    $Variation=new Variation();

                    $Variation->sku=!empty($this->rows[$index]['sku'])?$this->rows[$index]['sku']:$this->generateSku($product->name);
                    $Variation->equal=$this->rows[$index]['equal'];
                    $Variation->product_id=$product->id;
                    $Variation->unit_id=$this->rows[$index]['unit_id']!==""?$this->rows[$index]['unit_id']:null;
                    $Variation->basic_unit_id=$this->rows[$index]['basic_unit_id']!==""?$this->rows[$index]['basic_unit_id']:null;
                    $Variation->created_by=Auth::user()->id;
                    $Variation->save();
                // }else{
                //     $product=Variation::where('sku',$this->rows[$index]['sku'])->first();
                // }
                ////////////////

                $add_stock_data = [
                    'product_id' => $product->id,
                    'stock_transaction_id' =>$transaction->id ,
                    'quantity' => $this->rows[$index]['quantity'],
                    'purchase_price' => !empty($this->rows[$index]['purchase_price']) ? $this->rows[$index]['purchase_price'] : null ,
                    // 'final_cost' => !empty($this->total_cost[$index]) ? $this->total_cost[$index] : null,
                    'sub_total' => !empty($this->sub_total[$index]) ? (float)$this->sub_total[$index] : null,
                    'sell_price' => !empty($this->rows[$index]['selling_price']) ? $this->rows[$index]['selling_price'] : null,
                    'dollar_purchase_price' => !empty($this->rows[$index]['dollar_purchase_price']) ? $this->rows[$index]['dollar_purchase_price'] : null,
                    // 'dollar_final_cost' => !empty($this->dollar_total_cost[$index]) ? $this->dollar_total_cost[$index] : null,
                    'dollar_sub_total' => !empty($this->dollar_sub_total($index)) ? (float)$this->dollar_sub_total($index) : null,
                    'dollar_sell_price' => !empty($this->rows[$index]['dollar_selling_price']) ? $this->rows[$index]['dollar_selling_price'] : null,
                    // 'cost' => !empty($this->rows[$index]['cost']) ?  $this->rows[$index]['cost'] : null,
                    // 'dollar_cost' => !empty($this->rows[$index]['dollar_cost']) ? $this->rows[$index]['dollar_cost'] : null,
                    'exchange_rate' => !empty($this->exchange_rate) ? $this->exchange_rate : null,
                ];
                AddStockLine::create($add_stock_data);
                if (isset($this->rows[$index]['change_price_stock']) && $this->rows[$index]['change_price_stock']!=='') {
                    $stockLine=AddStockLine::find($product->id);
                    if(!empty($stockLine)){
                        $stockLine->update([
                        'purchase_price' => !empty($this->rows[$index]['purchase_price']) ? $this->rows[$index]['purchase_price'] : null,
                        'sell_price' => !empty($this->rows[$index]['selling_price']) ? $this->rows[$index]['selling_price'] : null,
                        'dollar_purchase_price' => empty($this->rows[$index]['dollar_purchase_price']) ? $this->rows[$index]['dollar_purchase_price'] : null,
                        'dollar_sell_price' => !empty($this->rows[$index]['dollar_selling_price']) ? $this->rows[$index]['dollar_selling_price'] : null
                        ]);
                    }
                }
                $this->updateProductQuantityStore($product->id, $transaction->store_id,  $this->rows[$index]['quantity'], 0);

            }

            // DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => __('lang.success'),]);
            return redirect('/initial-balance');
        
        }
        // }
        // catch (\Exception $e){
        //     $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => __('lang.something_went_wrongs'),]);
        //     dd($e);
        // }
    }
    public function generateSku($name, $number = 1)
    {
        $name_array = explode(" ", $name);
        $sku = '';
        foreach ($name_array as $w) {
            if (!empty($w)) {
                if (!preg_match('/[^A-Za-z0-9]/', $w)) {
                    $sku .= $w[0];
                }
            }
        }
        $sku = $sku . $number;
        $sku_exist = Product::where('sku', $sku)->exists();
  
        if ($sku_exist) {
            return $this->generateSku($name, $number + 1);
        } else {
            return $sku;
        }
    }
    public function confirmCreateProduct()
    {
        $product_exist=Product::where('name',$this->item[0]['name'])->exists();
        $this->edit_product=Product::where('name',$this->item[0]['name'])->first();
        if($product_exist){
            $this->dispatchBrowserEvent('showCreateProductConfirmation');
        }
    }
    public function create()
    {
        $this->subcategories1 = Category::where('parent_id',$this->edit_product['category_id'])->orderBy('name', 'asc')->pluck('name', 'id');
        $this->subcategories2 = Category::where('parent_id',$this->edit_product['subcategory_id1'])->orderBy('name', 'asc')->pluck('name', 'id');
        $this->subcategories3 = Category::where('parent_id',$this->edit_product['subcategory_id2'])->orderBy('name', 'asc')->pluck('name', 'id');
        $this->item[0]=
        [
        'isExist'=>1,
        'id'=>$this->edit_product['id'],
        'name' => $this->edit_product['name'],
        'category_id'=>$this->edit_product['category_id'],
        'subcategory_id1'=>$this->edit_product['subcategory_id1'],
        'subcategory_id2'=>$this->edit_product['subcategory_id2'],
        'subcategory_id3'=>$this->edit_product['subcategory_id3'],
        'weight' => $this->edit_product['weight'],
        'width' => $this->edit_product['width'],
        'height' =>$this->edit_product['height'],
        'length'=>$this->edit_product['length'],
        'size' => $this->edit_product['size'],
        'divide_costs'=>'',
        'status'=>'',
        'change_current_stock'=>0,
        'exchange_rate'=>$this->exchange_rate];
        $variations=Variation::where('product_id',$this->edit_product['id'])->get();
        foreach($variations as $variation){
            $newRow = [
            'id'=>$variation->id,
            'sku' => $variation->sku,
            'quantity' => '',
            'fill_quantity' => '',
            'fill_type' => 'fixed',
            'purchase_price'=>'',
            'selling_price'=>'',
            'dollar_purchase_price'=>'',
            'dollar_selling_price'=>'',
            'unit_id'=>$variation->unit_id,
            'basic_unit_id'=>$variation->basic_unit_id,
            'change_price_stock'=>'',
            // 'skuExist'=>0,
            'equal'=>$variation->equal,
            ];
            $this->rows[] = $newRow;
        }
    }
    public function cancelCreateProduct(){
        $this->item[0]['name']='';
    }
    public function fetchSelectedProducts()
    {
        $this->emit('closeModal');
        $this->selectedProductData = Product::whereIn('id', $this->selectedProducts)->get();

    }
    public function fetchProduct($id) {
        $product = Product::find($id);
        if(!empty($this->selectedProductData)){
            $this->selectedProductData[count($this->selectedProductData)] =  $product;
        }
        else{
            $this->selectedProductData[0] = $product;
        }

        $this->searchProduct ='';
    }

    public function get_product($index){
//        dd($this->selectedProductData[$index]['id']);
        return Unit::where('id' ,$this->rows[$index]['unit_id'])->first();
    }

    public function sub_total($index)
    {
        if(isset($this->rows[$index]['quantity']) && (isset($this->rows[$index]['purchase_price']) ||isset($this->dollar_purchase_price[$index]) )){
            // convert purchase price from Dollar To Dinar
            $purchase_price = $this->convertDollarPrice($index);

            if(isset($this->get_product($index)->base_unit_multiplier)){
                $this->base_unit[$index] = $this->get_product($index)->base_unit_multiplier;
            }
            else{
                $this->base_unit[$index] = 1;
            }
            $this->sub_total[$index] = (int)$this->rows[$index]['quantity'] * (float)$purchase_price * (float)$this->rows[$index]['equal'];

            return number_format($this->sub_total[$index], num_of_digital_numbers());
        }
    }

    public function dollar_sub_total($index)
    {
        if(isset($this->rows[$index]['quantity']) && (isset($this->rows[$index]['dollar_purchase_price']) || isset($this->rows[$index]['purchase_price']))){
            // convert purchase price from Dinar To Dollar
            $purchase_price = $this->convertDinarPrice($index);
            // if(isset($this->get_product($index)->base_unit_multiplier)){
            //     $this->base_unit[$index]  = $this->get_product($index)->base_unit_multiplier;
            // }
            // else{
            //     $this->base_unit[$index] = 1;
            // }
            $this->dollar_sub_total[$index] = (int)$this->rows[$index]['quantity'] * (float)$purchase_price * (float)$this->rows[$index]['equal'] ;

            return number_format($this->dollar_sub_total[$index], num_of_digital_numbers());
        }
        else{
            $this->quantity[$index] = 0;
            $this->dollar_purchase_price[$index] = 0;
        }
    }

    public function total_quantity($index){
        if (isset($this->rows[$index]['equal'])){
            return  (float)$this->rows[$index]['equal'] * (int)$this->rows[$index]['quantity'];
        }
        else{
            return  (int)$this->rows[$index]['quantity'];
        }

    }

    public function total_size($index){
        $this->total_size[$index] =  $this->total_quantity($index) * (float)$this->rows[$index]['size'];
        return $this->total_size[$index];
    }

    public function total_weight($index){
        $this->total_weight[$index] = $this->total_quantity($index) * (float)$this->rows[$index]['weight'] ;
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
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => __('lang.sum_sizes_less_equal_zero')]);
                    unset($this->divide_costs);
                }
                else{
                    (float)$this->cost[$index] = ( ( $cost / $this->sum_size() ) * $product->size ) + (float)$purchase_price;
                }
            }
            elseif ($this->divide_costs == 'weight'){
                if($this->sum_weight() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => __('lang.sum_weights_less_equal_zero')]);
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

        return number_format($this->cost[$index],num_of_digital_numbers());
    }

    public function total_cost($index){
        $this->total_cost[$index] = (float)$this->rows[$index]['cost'] * $this->total_quantity($index);
        return number_format($this->total_cost[$index],num_of_digital_numbers()) ;
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
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => __('lang.sum_sizes_less_equal_zero')]);
                    unset($this->divide_costs);
                }
                else{
                    (float)$this->cost[$index] = ( ( $dollar_cost / $this->sum_size() ) * $product->size ) + (float)$purchase_price;
                }
            }
            elseif ($this->divide_costs == 'weight'){
                if($this->sum_weight() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => __('lang.sum_weights_less_equal_zero')]);
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
        return number_format($this->dollar_cost[$index],num_of_digital_numbers());
    }

    public function dollar_total_cost($index){
        $this->dollar_total_cost[$index] = (float)$this->rows[$index]['dollar_cost']* (float)$this->total_quantity($index);
        return number_format($this->dollar_total_cost[$index], num_of_digital_numbers());

    }

    public function sum_total_cost(){
        return number_format(array_sum($this->total_cost),num_of_digital_numbers());
    }

    public function sum_dollar_total_cost(){
        return number_format(array_sum($this->dollar_total_cost),num_of_digital_numbers());
    }

    public function sum_sub_total(){
        return number_format(array_sum($this->sub_total),num_of_digital_numbers());
    }

    public function sum_dollar_tsub_total(){
        return number_format(array_sum($this->dollar_sub_total),num_of_digital_numbers());
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
        unset($this->rows[$index]);
    //     unset($this->selectedProducts[$index]);
    //     unset($this->selectedProductData[$index]);
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
        if(empty($this->rows[$index]['purchase_price']) && !empty($this->rows[$index]['dollar_purchase_price'])){
            (float)$purchase_price = (float)$this->rows[$index]['dollar_purchase_price'] * $this->exchange_rate;
        }
        else{
            $purchase_price = $this->rows[$index]['purchase_price'];
        }
        return $purchase_price;
    }

    public function convertDinarPrice($index)
    {
//        dd($this->purchase_price[$index]);
        if (!empty($this->rows[$index]['purchase_price']) && empty($this->rows[$index]['dollar_purchase_price'])) {
            $purchase_price = $this->rows[$index]['purchase_price'] / $this->exchange_rate;
        }
        else {
            $purchase_price = $this->rows[$index]['dollar_purchase_price'];
        }
        return $purchase_price;

    }
    public function changeExchangeRate(){
        if (isset($this->supplier)){
            $supplier = Supplier::find($this->supplier);
            if(isset($supplier->exchange_rate)){
                return $this->exchangeRate =  str_replace(',' ,'',$supplier->exchange_rate);
            }
            else
            return $this->exchangeRate =System::getProperty('dollar_exchange');
        }
        else{
            return $this->exchangeRate =System::getProperty('dollar_exchange');
        }
        
    }
    public function ShowDollarCol(){
        $this->showColumn= !$this->showColumn;
            dd($this->selectedProductData);
    }
    public function changePurchasePrice($index){
        $this->rows[$index]['purchase_price']=$this->rows[$index]['dollar_purchase_price']*$this->exchange_rate;
        $this->changeFilling($index);
    }
    public function changeExchangeRateBasedPrices(){
        // dd(55);
        foreach ($this->rows as $index=>$row) {
            if($this->rows[$index]['purchase_price']!=""){
                $this->changePurchasePrice($index);
                $this->sub_total($index);
                $this->dollar_sub_total($index);
            }
        }
    }
    public function changeFilling($index){
        if($this->rows[$index]['purchase_price']!=""){
            if($this->rows[$index]['fill_type']=='fixed'){
                $this->rows[$index]['dollar_selling_price']=($this->rows[$index]['dollar_purchase_price']+(float)$this->rows[$index]['fill_quantity']);
                $this->rows[$index]['selling_price']=($this->rows[$index]['dollar_purchase_price']+(float)$this->rows[$index]['fill_quantity'])*$this->exchange_rate;
            }else{
                $percent=((float)$this->rows[$index]['dollar_purchase_price']*(float)$this->rows[$index]['fill_quantity'])/100;
                $this->rows[$index]['dollar_selling_price']=($this->rows[$index]['dollar_purchase_price']+$percent);
                $this->rows[$index]['selling_price']=($this->rows[$index]['dollar_purchase_price']+$percent)*$this->exchange_rate;
            }
        }
    }
    public function changeSellingPrice($index){
        $this->rows[$index]['selling_price']=(float)$this->rows[$index]['dollar_selling_price']* (float)$this->exchange_rate;
    }
    public function changeCost($index){
        $this->rows[$index]['cost']=$this->rows[$index]['dollar_cost']*$this->exchange_rate;
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
