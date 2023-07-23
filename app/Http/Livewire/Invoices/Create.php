<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Create extends Component
{
    public $products = [], $department_id = null, $items = [];
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
        if ( $product->quantity < 1) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'الكمية غير كافية']);
        } else {
            return 'hello';
        }
    }
}
