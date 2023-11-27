<?php

namespace App\Http\Livewire\Returns\Suppliers;

use Livewire\Component;

class Product extends Component
{
    public function render()
    {
        $products = Product::where('created_at','desc')->get();
        return view('livewire.returns.suppliers.product',compact('products'));
    }
}
