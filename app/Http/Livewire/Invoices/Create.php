<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\System;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
class Create extends Component
{
    public $products = [], $department_id = null, $items = [], $price  ,$total = 0,
           $client_phone, $client_id, $client,$not_paid,$cash = 0, $rest,
           $invoice,$invoice_id, $date, $payment_method, $discounts = [];

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

    public function render()
    {
        $allproducts = Product::get();
        $departments = Category::get();
        $customers   = Customer::get();
        $store_pos = StorePos::where('user_id', Auth::user()->id)->first();
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
            'stores'
            ));
    }

    public function updatedDepartmentId($department_id)
    {
        $this->products = $department_id > 0? Product::where('category_id', $department_id)->get() : Product::get();
    }

    public function add_product(Product $product){
        $current_stock = $this->getCurrentStock($product);
        $product_price = $this->getProductPrice($current_stock);
        $exchange_rate = $this->getProductExchangeRate($current_stock);
        $quantity_available = $this->quantityAvailable($product);
        $discount = $this->getProductDiscount($product->id);
        if ( $quantity_available < 1) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
        }
        else {
            if(isset($discount)){
                $this->discounts = $discount;
            }
            else
                $this->discounts = 0;

            $newArr = array_filter($this->items, function ($item) use ($product) {
                return $item['product_id'] == $product->id;
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
                $this->items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => 10,
                    'category_id' => $product->category?->id,
                    'department_name' => $product->category?->name,
                    'client_id' => $product->customer?->id,
                    'discount' => null,
                    'exchange_rate' => $exchange_rate,
                    'current_stock' => $quantity_available,
                    'sub_total' => 10 * 1,
                ];
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
        $this->cash= $this->total;
        $this->rest  = 0;
    }

    public function increment($key){
        $product = Product::whereId($this->items[$key]['product_id'])->first();
        $productLimit = $this->quantityAvailable($product); // Set the product limit to 10
        if ($this->items[$key]['quantity'] < $productLimit) {
            $this->items[$key]['quantity']++;
            $this->items[$key]['sub_total'] = ( $this->items[$key]['price'] * $this->items[$key]['quantity'] ) -
                ( $this->items[$key]['quantity'] * $this->items[$key]['discount']);

        }
        else{
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
        }
        $this->computeForAll();
    }

    public function decrement($key){
        $this->items[$key]['quantity']--;
        $this->items[$key]['sub_total'] = ( $this->items[$key]['price'] * $this->items[$key]['quantity'] ) -
            ( $this->items[$key]['quantity'] * $this->items[$key]['discount']);
        if ($this->items[$key]['quantity'] == 0) {
            $this->items[$key]['quantity']++;
            $this->items[$key]['sub_total'] = ( $this->items[$key]['price'] * $this->items[$key]['quantity'] ) -
                ( $this->items[$key]['quantity'] * $this->items[$key]['discount']);

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

    public function mount()
    {
        $this->department_id = null;
    }

    public function ValidationAttributes(){
        return [
            'client_id' => __('اسم العميل'),
            'cash' => __('الدفع نقدا'),
        ];
    }

    public function submit($status = null){
        $data = $this->validate([
            'items' => 'min:1',
            'price' => 'required',
            'total' => 'required',
            // 'cash' => 'required|numeric|max:'.(($this->total)+2)',
            'cash' => 'required|numeric|lt:total',
            'rest' => 'nullable|numeric',
            'client_id' => 'required',
        ]);
        if ($this->cash >= 0 ) {
            $status = is_null($status) ? 'paid' : 'unpaid';
            if ($this->rest > 0) {
                $status = 'partially_paid';
            }
            $data = [
                'user_id'        => auth()->user()->id,
                'customer_id'    => $this->client_id,
                'date'           => now(),
                'payment_method' => 'cash',
                'price'          => $this->price,
                'total'          => $this->total,
                'cash'           => $this->cash,
                'rest'           => $this->rest,
                'status'         => $status,

            ];
            $invoice = Invoice::create($data);
            $invoice->items()->createMany($this->items);
            // foreach ($this->items as $id => $quantity) {
            //     $product = Product::findOrFail($quantity['product_id']);
            //     if ($product->quantity > 0) {
            //         $product->update([
            //             'quantity' => $product->quantity - $quantity['quantity']
            //         ]);
            //     }
            // } //end of foreach

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'تم إضافة الفاتورة بنجاح']);
            $this->reset();
            $this->mount();
            $this->resetAll();
            // return redirect()->route('invoices.show', $invoice->id);
        }else {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'يوجد مشكلة في المبلغ المدفوع']);
        }
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
//            dd($product->get());
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
        $exchange_rate = $current_stock->transaction->transaction_payments->last()->exchange_rate;
        return $exchange_rate;
    }

    public function subtotal($key){
         $this->items[$key]['sub_total'] = ( $this->items[$key]['price'] * $this->items[$key]['quantity'] ) -
                ( $this->items[$key]['quantity'] * $this->items[$key]['discount']);
        $this->computeForAll();
    }

    public function getProductPrice($stock){

//        dd($stock);

    }

}
