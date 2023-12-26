<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Invoice;
use App\Models\Product;
use Livewire\Component;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionSellLine;
use Illuminate\Support\Facades\Log;

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
    // ++++++++++++++++++++++ multiDeleteRow ++++++++++++++++++++++
    public function multiDeleteRow(Request $request)
    {
        try
        {
            DB::beginTransaction();
            foreach ($request->ids as $id)
            {
                $invoice = Invoice::find($id);
                $invoice->forceDelete();
            }
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
            DB::commit();
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return $output;
    }

    public function render()
    {
        $sell_lines = TransactionSellLine::OrderBy('created_at','desc')->paginate(10);

        return view('livewire.invoices.index', compact('sell_lines'));
    }
}
