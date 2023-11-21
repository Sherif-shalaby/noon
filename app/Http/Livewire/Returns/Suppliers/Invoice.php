<?php

namespace App\Http\Livewire\Returns\Suppliers;

use App\Models\AddStockLine;
use App\Models\Brand;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Invoice extends Component
{
    public $stocks, $brand_id, $supplier_id, $po_no, $product_name, $product_sku, $product_symbol, $created_by, $from, $to;

    protected $listeners = ['listenerReferenceHere'];

    public function listenerReferenceHere($data)
    {
        if (isset($data['var1'])) {
            if ($data['var1'] == 'supplier_id' || $data['var1'] == 'created_by') {
                $this->{$data['var1']} = (int)$data['var2'];
            }
            else {
                $this->{$data['var1']} = $data['var2'];
            }
        }
    }
    public function mount(){
        $this->to = Carbon::now()->toDateString();
        $this->dispatchBrowserEvent('initialize-select2');

    }

    public function render()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->pluck('name','id');
        $users = User::orderBy('created_at', 'desc')->pluck('name','id');
        $brands = Brand::pluck('name','id');

        $this->stocks =  StockTransaction::
            when($this->po_no, function ($query) {
                $query->where('po_no','like', '%' . $this->po_no . '%');
            })
            ->when($this->supplier_id != null, function ($query) {
                $query->where('supplier_id',$this->supplier_id);
            })
            ->when($this->created_by != null, function ($query) {
                $query->where('created_by',$this->created_by);
            })
            ->when($this->brand_id != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('id', $this->brand_id);
                });
            })
            ->when($this->product_name != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('name', 'like', '%' . $this->product_name . '%');
                });
            })
            ->when($this->product_sku != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('sku', 'like', '%' . $this->product_sku . '%');
                });
            })
            ->when($this->product_symbol != null, function ($query) {
                $query->whereHas('add_stock_lines.product', function ($subquery) {
                    $subquery->where('product_symbol', 'like', '%' . $this->product_symbol . '%');
                });
            })
            ->when($this->from != null, function ($query){
                $query->where('created_at', '>=', $this->from);
            })
            ->when($this->to, function ($query){
                return $query->where('created_at', '<=', $this->to);
            })
            ->orderBy('created_at', 'desc')->get();

        $this->dispatchBrowserEvent('initialize-select2');

        return view('livewire.returns.suppliers.invoice',compact('suppliers','users', 'brands'));
    }

    public function clear_filters(){
        $this->brand_id = null;
        $this->supplier_id = null;
        $this->po_no = null;
        $this->product_sku = null;
        $this->product_name = null;
        $this->product_symbol = null;
        $this->created_by = null;
        $this->from = null;
        $this->to = Carbon::now()->toDateString();
        $this->stocks =  StockTransaction::orderBy('created_at', 'desc')->get();
    }

    public function submit($via = 'invoice', $id){
        if($via == 'all_invoice'){
            dd($id);
        }
    }
}
