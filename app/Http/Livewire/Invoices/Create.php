<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Create extends Component
{
    public $products = [], $department_id = null;
    public function render()
    {
        $departments=Category::get();
        return view('livewire.invoices.create',compact('departments'));
    }
    public function updatedDepartmentId($department_id)
    {
        $this->products = Product::where('category_id', $department_id)->get();
    }
    public function add_product(Product $product){

    }
}
