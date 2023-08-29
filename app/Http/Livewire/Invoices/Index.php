<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class Index extends Component
{
    public $filter_status, $from, $to, $searchemployee, $searchinvoiveno, $refund, $refund_status;
    public $total,$totalcash,$totalcard;
    public function mount(){
        $this->total     = Invoice::sum('total');
        $this->totalcash = Invoice::sum('cash');
    }
    public function between($query)
    {
        if ($this->from && $this->to) {
            $query->whereBetween('created_at', [$this->from, $this->to]);
        } elseif ($this->from) {
            $query->where('created_at', '>=', $this->from);
        } elseif ($this->to) {
            $query->where('created_at', '<=', $this->to);
        } else {
            $query;
        }
    }
    public function delete(Invoice $invoice)
    {
        $invoice->delete();
        $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'تم حذف الفاتورة بنجاح']);
    }
    public function render()
    {
        $invoices = Invoice::with(['user','customer'])->where(function ($q) {
            $this->between($q);
            if ($this->filter_status) {
                $q->where('status', $this->filter_status);
            }
            if ($this->searchinvoiveno) {
                $q->where('id', 'like', '%' . $this->searchinvoiveno . '%');
            }
            if ($this->searchemployee) {
                $q->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->searchemployee . '%');
                });
            }
        })->latest('id')->paginate(10);
        return view('livewire.invoices.index', compact('invoices'));
    }
}
