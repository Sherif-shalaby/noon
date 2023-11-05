<?php

namespace App\Http\Livewire\Transfer;

use Livewire\Component;

class Create extends Component
{
    public $sell_car_id;
    public function mount($id){
        $this->sell_car_id = $id;
    }
    public function render()
    {
        return view('livewire.transfer.create');
    }
}
