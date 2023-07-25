<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Create extends Component
{
    use LivewireAlert;
    public $products = [], $department_id = null, $items = [], $price  ,$total = 0;
    public $client_phone, $client_id, $client;
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
        $customers = Customer::get();
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
                    $this->items[$key]['price'] = 5 * $this->items[$key]['quantity'];
                    $this->items[$key]['total'] = $this->items[$key]['price'] ;
                }
            } else {
                $this->items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => 10,
                    'department_id' => $product->category->id,
                    'department_name' => $product->category->name,
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
}
