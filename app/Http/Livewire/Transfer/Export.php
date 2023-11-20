<?php

namespace App\Http\Livewire\Transfer;

use App\Models\AddStockLine;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\SellCar;
use App\Models\Store;
use App\Models\System;
use App\Models\TransferLine;
use App\Models\TransferTransaction;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class Export extends Component
{
    public $sell_car_id, $store_id, $receiver_store_id, $sender_store_id, $stores, $products , $items = [], $searchProduct,
        $search_by_product_symbol, $notes, $files, $sender_store_name;


    public function mount($id){
        $this->sell_car_id = $id;
        $sell_car = SellCar::find($this->sell_car_id);
        $this->sender_store_id = $sell_car->branch->stores->first()->id;
//        dd($this->sender_store_id);
        $this->sender_store_name = $sell_car->car_name;
        $this->stores = Store::pluck('name', 'id');
        $this->receiver_store_id =  key(reset($this->stores));
        if (!empty($this->sender_store_id)) {
//            $products_store = ProductStore::where('store_id', $this->sender_store_id)->pluck('product_id');
            $this->products = $sell_car->branch->stores->first()->products;
        }
//        dd($this->products);
        $this->dispatchBrowserEvent('initialize-select2');

    }

    public function updating($propertyName, $value)
    {
        if (Str::startsWith($propertyName, 'items.')) {
            $index = explode('.', $propertyName)[1];
            $name = explode('.', $propertyName)[2];
            if($name == 'quantity'){
                $originalValue = $this->num_uf($this->items[$index]['quantity']);
                if($this->num_uf($value) <= $this->num_uf($this->items[$index]['quantity_available'])){
                    $this->items[$index]['quantity'] = $this->num_uf($value);
                }
                else{
                    $this->items[$index]['quantity'] = $this->num_uf($originalValue);
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'الكمية غير كافية']);

                }
            }
            $this->sub_total($index);
            $this->dollar_sub_total($index);
            $this->changeCurrentStock($index);
        }
        return true;
    }

    protected $listeners = ['listenerReferenceHere'];

    public function listenerReferenceHere($data)
    {
        if(isset($data['var1'])) {
            $this->{$data['var1']} = (int)$data['var2'];
        }
        if (isset($data['var1']) && $data['var1'] == "sender_store_id") {
            $this->changeAllProducts();
        }
    }

    public function render()
    {
        $departments = Category::get();
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
        $this->dispatchBrowserEvent('initialize-select2');

        return view('livewire.transfer.export',compact('departments','search_result'));
    }

    public function store(){

        try {
            $transaction_data = [
                'sender_store_id' => $this->sender_store_id,
                'receiver_store_id' => $this->receiver_store_id,
                'type' => 'transfer',
                'status' => 'final',
                'transaction_date' => Carbon::now(),
                'final_total' => $this->num_uf($this->sum_sub_total()),
                'dollar_final_total' => $this->num_uf($this->sum_dollar_sub_total()),
                'notes' => !empty($this->notes) ? $this->notes : null,
//            'details' => !empty($data['details']) ? $data['details'] : null,
                'invoice_no' => $this->getNumberByType(),
                'created_by' => Auth::user()->id,
            ];
            DB::beginTransaction();
            if ($this->files) {
                $transaction_data['file'] = store_file($this->files, 'transfer');
            }
            $transaction = TransferTransaction::create($transaction_data);

            foreach ($this->items as $key => $item) {
                $transfer_line_data = [
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']['id'],
                    'variation_id' => $item['variation_id'],
                    'quantity' => $this->num_uf($item['quantity']),
                    'purchase_price' => $this->num_uf($item['purchase_price']) ?? null,
                    'sell_price' => $this->num_uf($item['selling_price']) ?? null,
                    'dollar_purchase_price' => $this->num_uf($item['dollar_purchase_price']) ?? null,
                    'dollar_sell_price' => $this->num_uf($item['dollar_selling_price']) ?? null,
                    'exchange_rate' => $this->num_uf($item['exchange_rate']) ?? null,
                    'sub_total' => $this->num_uf($item['sub_total']),
                    'dollar_sub_total' => $this->num_uf($item['dollar_sub_total']),
                    'created_by' => Auth::user()->id,
                ];
                $transfer_line = TransferLine::create($transfer_line_data);

                $this->decreaseProductQuantity($transfer_line->product_id , $transfer_line->variation_id, $transaction->sender_store_id, $transfer_line->quantity);
                $this->updateProductQuantityStore($transfer_line->product_id, $transfer_line->variation_id, $transaction->receiver_store_id,  $transfer_line->quantity);
            }


            DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'lang.success',]);

        }
        catch (\Exception $e) {
//            dd($e);
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);

        }
        return redirect('/sell-car');
    }

    public function add_product($id)
    {

        if (!empty($this->searchProduct)) {
            $this->searchProduct = '';
        }
        if (!empty($this->search_by_product_symbol)) {
            $this->search_by_product_symbol = '';
        }
        $product = Product::where('id', $id)->first();
        $quantity_available = $this->quantityAvailable($product);
        if ($quantity_available < 1) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'الكمية غير كافية',]);
        }
        else {
            $current_stock = $this->getCurrentStock($product);
            $product_stores = $this->getProductStores($product);
            $exchange_rate =  !empty($current_stock->exchange_rate) ? $current_stock->exchange_rate : System::getProperty('dollar_exchange');
            if (isset($discount)) {
                $discounts = $discount;
            } else
                $discounts = 0;

            $newArr = array_filter($this->items, function ($item) use ($product) {
                return $item['product']['id'] == $product->id;
            });
            if (count($newArr) > 0) {
                $key = array_keys($newArr)[0];
                ++$this->items[$key]['quantity'];

                if ($quantity_available  < $this->items[$key]['quantity']) {
                    --$this->items[$key]['quantity'];
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'الكمية غير كافية',]);
                } else {
                    $this->sub_total($key);
                    $this->dollar_sub_total($key);
                }
            } else {
                $purchase_price = !empty($current_stock->purchase_price) ? number_format($current_stock->purchase_price, 2) : 0;
                $dollar_purchase_price = !empty($current_stock->dollar_purchase_price) ? number_format($current_stock->dollar_purchase_price, 2) : 0;
                $selling_price = !empty($current_stock->sell_price) ? number_format($current_stock->sell_price, 2) : 0;
                $dollar_selling_price = !empty($current_stock->dollar_sell_price) ? number_format($current_stock->dollar_sell_price, 2) : 0;
                $new_item = [
                    'variations' => $product->variations,
                    'product' => $product,
                    'quantity' => 1,
                    'exchange_rate' => $exchange_rate,
                    'purchase_price' => $this->num_uf($purchase_price),
                    'dollar_purchase_price' => $this->num_uf($dollar_purchase_price),
                    'selling_price' => $this->num_uf($selling_price),
                    'dollar_selling_price' => $this->num_uf($dollar_selling_price),
                    'quantity_available' => $quantity_available,
                    'sub_total' =>  (float) 1 * $this->num_uf($purchase_price),
                    'dollar_sub_total' => (float) 1 * $this->num_uf($dollar_purchase_price),
                    'current_stock' => $current_stock,
                    'total_stock' => 1,
                    'unit_name' => !empty($product->unit) ? $product->unit->name : '',
                    'base_unit_multiplier' => !empty($product->unit) ? $product->unit->base_unit_multiplier : 1,
                    'total_quantity' => !empty($product->unit) ?  1 * $product->unit->base_unit_multiplier : 1,
                    'stores' => $product_stores,
                    'sender_store_id' => $this->sender_store_id,
                    'variation_id' => ProductStore::where('product_id', $product->id)->where('store_id', $this->sender_store_id)->first()->variation_id ?? '',
                ];
                array_unshift($this->items, $new_item);
            }
        }
    }

    public function quantityAvailable($product)
    {
        $quantity_available = ProductStore::where('product_id', $product->id)->where('store_id', $this->sender_store_id)
            ->first()->quantity_available ?? 0;

        return $quantity_available;
    }

    public function getCurrentStock($product)
    {
        $product_stocklines = $product->stock_lines;
        foreach ($product_stocklines as $stockline) {
            $quantity_available =  $stockline->quantity - $stockline->quantity_sold  + $stockline->quantity_returned;
            if ($quantity_available > 0) {
                return $stockline;
            }
        }
        return null;
    }

    public function getProductStores($product)
    {
        $stores = ProductStore::where('product_id', $product->id)->get();
        return $stores;
    }

    public function sub_total($index)
    {
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
        if (!empty($this->items[$index]['purchase_price']) && empty($this->items[$index]['dollar_purchase_price'])) {
            $purchase_price = $this->items[$index]['purchase_price'] / $this->num_uf($this->exchange_rate);
        }
        else {
            $purchase_price = $this->items[$index]['dollar_purchase_price'] ?? '';
        }
        return $purchase_price;

    }

    public function changeCurrentStock($index){
        $this->items[$index]['total_stock'] = $this->items[$index]['quantity'] ;
    }

    public function changeAllProducts()
    {
        $products_store = ProductStore::where('store_id', $this->sender_store_id)->pluck('product_id');
        $this->products = Product::whereIn('id', $products_store)->get();
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

    public function total_quantity(){
        $totalQuantity = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item){
                $totalQuantity += (int)$item['quantity'];
            }
        }
        return $totalQuantity;
    }

    public function delete_product($key)
    {
        unset($this->items[$key]);
    }

    public function changeUnit($key)
    {
        if (!empty($this->items[$key]['variation_id'])) {
            $variation_id = $this->items[$key]['variation_id'];
            $stock_line = AddStockLine::where('variation_id', $variation_id)->first();
            if (empty($stock_line->sell_price) && empty($stock_line->dollar_sell_price)) {
                $stock_variation = Variation::find($this->items[$key]['current_stock']['variation_id']);
                $product_variations = Variation::where('product_id', $this->items[$key]['product']['id'])->get();
                $unit = Variation::where('id', $variation_id)->first();
                $qtyByUnit = $this->getNewSellPrice($stock_variation, $product_variations, $unit, $variation_id);
                $this->items[$key]['price'] = number_format($this->items[$key]['current_stock']['sell_price'] * $qtyByUnit ?? 0, 2);
                $this->items[$key]['dollar_price'] = number_format($this->items[$key]['current_stock']['dollar_sell_price'] * $qtyByUnit ?? 0, 2);
            } else {
                $this->items[$key]['price'] = number_format($stock_line->sell_price ?? 0, 2);
                $this->items[$key]['dollar_price'] = number_format($stock_line->dollar_sell_price ?? 0, 2);
                $this->items[$key]['current_stock'] = $stock_line;
                $this->items[$key]['discount_categories'] = $stock_line->prices()->get();
            }
            $this->items[$key]['sub_total'] = number_format($this->num_uf($this->items[$key]['purchase_price']) * $this->items[$key]['quantity'], 2);
            $this->items[$key]['dollar_sub_total'] = number_format($this->items[$key]['dollar_purchase_price'] * $this->items[$key]['quantity'], 2);
            $qty = $this->items[$key]['quantity_available'];
            $variations = Variation::where('product_id', $this->items[$key]['product']['id'])->get();
            $product_store = ProductStore::where('product_id', $this->items[$key]['product']['id'])->where('store_id', $this->sender_store_id)->first();
            $amount = 1;
            $var_id = Variation::find($variation_id)->unit_id;
            if (!empty($product_store->variations)) {
                if ($var_id == $product_store->variations->unit_id) {
                    $this->items[$key]['quantity_available'] = $product_store->quantity_available;
                } else if ($var_id == $product_store->variations->basic_unit_id) {
                    $this->items[$key]['quantity_available'] = $product_store->quantity_available * $product_store->variations->equal;
                } else {
                    $amount = 1;
                    foreach ($variations as $var) {
                        if ($var->id !== $product_store->variation_id) {
                            if (isset($var->equal)) {
                                $amount *= $var->equal;
                            }
                            if ($var->unit_id == $var_id) {
                                break;
                            }
                        }
                    }
                    $this->items[$key]['quantity_available'] = number_format($product_store->quantity_available / $amount, 3);
                }
            } else {
                $this->items[$key]['quantity_available'] = $qty;
            }
        }
    }

    public function check_items_store(){
        if(!empty($this->items)){
            foreach ($this->items  as $key => $item){
                if($item['sender_store_id'] != $this->sender_store_id){
                    unset($this->items[$key]);
                }
            }
        }
        if (!empty($this->sender_store_id)) {
            $products_store = ProductStore::where('store_id', $this->sender_store_id)->pluck('product_id');
            $this->products = Product::whereIn('id', $products_store)->get();
        } else {
            $this->products = Product::get();
        }
    }

    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }

    public function getNumberByType($i = 1)
    {
        $number = '';
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $count = TransferTransaction::whereMonth('transaction_date', $month)->count() + $i;
        $number = 'trans' . $year . $month . $count;


        return $number;
    }

    public function decreaseProductQuantity($product_id, $variation_id = null, $store_id, $new_quantity)
    {
        $product_store = ProductStore::where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->first();
        $product_variations = Variation::where('product_id', $product_id)->get();
        $unit = Variation::where('id', $variation_id)->first();
        $qty_difference = 0;
        $qtyByUnit = 1;
        if (!empty($product_store) && !empty($product_store->variation_id)) {
            $store_variation = Variation::find($product_store->variation_id);
            if ($store_variation->unit_id == $unit->unit_id) {
                $qty_difference = $new_quantity;
            } elseif ($store_variation->basic_unit_id == $unit->unit_id) {
                $qtyByUnit = 1 / $store_variation->equal;
                $qty_difference = $qtyByUnit * $new_quantity;
            } else {
                foreach ($product_variations as $key => $product_variation) {
                    if (!empty($product_variations[$key + 1])) {
                        if ($store_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                            if ($product_variations[$key + 1]->basic_unit_id == $unit->unit_id) {
                                $qtyByUnit = $store_variation->equal * $product_variations[$key + 1]->equal;
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            } else {
                                $qtyByUnit = $product_variation->equal;
                            }
                        } else {
                            if ($product_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                                $qtyByUnit *= $product_variation->equal;
                            }
                            if ($product_variation->basic_unit_id == $variation_id || $product_variation->unit_id == $variation_id) {
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            }
                        }
                    } else {
                        if ($product_variation->basic_unit_id == $variation_id) {
                            $qtyByUnit *= $product_variation->equal;
                            $qty_difference = $new_quantity / $qtyByUnit;
                            break;
                        }
                    }
                }
            }
        } else {
            $qty_difference = $new_quantity;
        }
        if ($qty_difference != 0) {
            if (empty($product_store)) {
                $product_store = new ProductStore();
                $product_store->product_id = $product_id;
                $product_store->store_id = $store_id;
                $product_store->quantity_available = 0;
            }
            if (empty($product_store->variation_id) && !empty($variation_id)) {
                $product_store->variation_id = $variation_id;
            }
            $product_store->decrement('quantity_available', $qty_difference);
        }

        return true;
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
}
