<?php

namespace App\Http\Livewire\AddStock;

use App\Models\AddStockLine;
use App\Models\StockTransaction;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $stocks =  StockTransaction::all();
        return view('livewire.add-stock.index')->with(compact('stocks'));
    }
}
