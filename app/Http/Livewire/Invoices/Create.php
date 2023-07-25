<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Create extends Component
{
    use LivewireAlert;
    public $products = [], $department_id = null, $items = [], $price  ,$total = 0,
           $client_phone, $client_id, $client,$not_paid,$cash = 0, $rest,
           $invoice,$invoice_id, $date, $payment_method;
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
        return view('livewire.invoices.create',compact('departments','allproducts','customers'));
    }
    public function updatedDepartmentId($department_id)
    {
        $this->products = $department_id > 0? Product::where('category_id', $department_id)->get() : Product::get();
    }


    public function add_product(Product $product){
        // dd($product);
        if ( $product->productdetails->quantity_available < 1) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
        } else {
            // $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'تمام',]);
            $newArr = array_filter($this->items, function ($item) use ($product) {
                return $item['product_id'] == $product->id;
            });
            if (count($newArr) > 0) {
                $key = array_keys($newArr)[0];
                ++$this->items[$key]['quantity'];

                if ($product->productdetails->quantity_available  < $this->items[$key]['quantity']) {
                    --$this->items[$key]['quantity'];
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
                }else {
                    // $this->items[$key]['price'] = 10 * $this->items[$key]['quantity'];
                    $this->items[$key]['total'] = $this->items[$key]['price'] ;
                }
            } else {
                $total = 10;
                $this->items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => 10,
                    'category_id' => $product->category?->id,
                    'department_name' => $product->category?->name,
                    'client_id' => $product->customer?->id,
                    'total' => $total,
                ];
            }
        }
        $this->computeForAll();
    }
    public function computeForAll()
    {
        $this->price = array_reduce($this->items, function ($carry, $item) {
            $carry += $item['price'] * $item['quantity'];
            return $carry;
        });
        $this->total = $this->price;
        $this->rest  = 0;
    }
    public function increment($key){
        $product = Product::whereId($this->items[$key]['product_id'])->first();
        $productLimit = $product->productdetails->quantity_available; // Set the product limit to 10
        if ($this->items[$key]['quantity'] < $productLimit) {
            $this->items[$key]['quantity']++;
        }else{
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'الكمية غير كافية',]);
        }
        $this->computeForAll();
    }
    public function decrement($key){
        $this->items[$key]['quantity']--;
        if ($this->items[$key]['quantity'] == 0) {
            $this->items[$key]['quantity']++;
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
            // $this->resetAll();
            return redirect()->route('invoices.show', $invoice->id);
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
}
