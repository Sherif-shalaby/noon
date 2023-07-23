<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Create extends Component
{
    use LivewireAlert;
    public $products = [], $department_id = null, $items = [], $price  ,$total = 0;
    public function render()
    {
        $allproducts = Product::get();
        $departments = Category::get();
        return view('livewire.invoices.create',compact('departments','allproducts'));
    }
    public function updatedDepartmentId($department_id)
    {
        $this->products = Product::where('category_id', $department_id)->get();
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
        // $this->mount();
    }
}
