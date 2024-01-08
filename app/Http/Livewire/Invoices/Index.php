<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Brand;
use App\Models\Invoice;
use App\Models\JobType;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Variation;
use App\Models\CustomerType;
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
        // $sell_lines = TransactionSellLine::OrderBy('created_at','desc')->paginate(10);
        $sell_lines = TransactionSellLine::with('transaction_sell_lines.product', 'transaction_payments', 'customer')
        // start_date filter
        ->when(request()->start_date != null, function ($query) {
            $query->whereDate('transaction_date', '>=', request()->start_date);
        })
        // end_date filter
        ->when(request()->end_date != null, function ($query) {
            $query->whereDate('transaction_date', '<=', request()->end_date);
        })
        // start_time filter
        ->when(request()->start_time != null, function ($query) {
            $query->whereTime('transaction_date', '>=', request()->start_time);
        })
        // end_time filter
        ->when(request()->end_time != null, function ($query) {
            $query->whereTime('transaction_date', '<=', request()->end_time);
        })
        // customers filter
        ->when(request()->customer_id != null, function ($query) {
            $query->where('customer_id', request()->customer_id);
        })
        // customer_types filter
        ->when(request()->customer_type_id != null, function ($query) {
            $query->whereHas('customer', function ($query) {
                $query->where('customer_type_id', request()->customer_type_id);
            });
        })
        // customer phone filter
        ->when(request()->phone_number != null, function ($query) {
            $query->whereHas('customer', function ($query) {
                $query->where('phone', 'like', '%' . request()->phone_number . '%');
            });
        })
        // payment_status filter
        ->when(request()->payment_status != null, function ($query) {
            $query->where('payment_status', request()->payment_status);
        })
        // sale_status filter
        ->when(request()->sale_status != null, function ($query) {
            $query->where('status', request()->sale_status);
        })
        // deliveryman filter
        ->when(request()->deliveryman_id != null, function ($query) {
            $query->whereHas('delivery', function ($query) {
                $query->where('deliveryman_id', request()->deliveryman_id);
            });
        })
        // brands filter
        ->when(request()->brand_id, function ($query, $brand_id) {
            $query->whereHas('transaction_sell_lines.product.brand', function ($query) use ($brand_id) {
                $query->where('brand_id', $brand_id);
            });
        })
        // products filter
        ->when(request()->product_id != null, function ($query) {
            // Conditionally apply a filter only when product_id is not null
            $query->whereHas('transaction_sell_lines.product', function ($query) {
                // Check for the existence of related records where product_id matches the provided product_id
                $query->where('product_id', request()->product_id);
            });
        })
        // categories filter
        ->when(request()->category_id, function ($query, $category_id) {
            $query->whereHas('transaction_sell_lines.product.category', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        })
        // subcategories1 filter
        ->when(request()->subcategory_id1, function ($query, $subcategory_id1) {
            $query->whereHas('transaction_sell_lines.product.subCategory1', function ($query) use ($subcategory_id1) {
                $query->where('subcategory_id1', $subcategory_id1);
            });
        })
        // subcategories2 filter
        ->when(request()->subcategory_id2, function ($query, $subcategory_id2) {
            $query->whereHas('transaction_sell_lines.product.subCategory2', function ($query) use ($subcategory_id2) {
                $query->where('subcategory_id2', $subcategory_id2);
            });
        })
        // subcategories3 filter
        ->when(request()->subcategory_id3, function ($query, $subcategory_id3) {
            $query->whereHas('transaction_sell_lines.product.subCategory3', function ($query) use ($subcategory_id3) {
                $query->where('subcategory_id3', $subcategory_id3);
            });
        })
        ->latest()->get();
        // dd($sell_lines);
        $categories1    = Category::orderBy('name', 'asc')->where('parent_id',1)->pluck('name', 'id')->toArray();
        $categories2    = Category::orderBy('name', 'asc')->where('parent_id',2)->pluck('name', 'id')->toArray();
        $categories3    = Category::orderBy('name', 'asc')->where('parent_id',3)->pluck('name', 'id')->toArray();
        $categories4    = Category::orderBy('name', 'asc')->where('parent_id',4)->pluck('name', 'id')->toArray();
        $customers      = Customer::orderBy('name', 'asc')->pluck('name', 'id');
        $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id');
        $payment_status_array =  [
                'partial' => __('lang.partially_paid'),
                'paid' => __('lang.paid'),
                'pending' => __('lang.pay_later'),
            ];
        $sale_status =  [
                'final' => __('lang.final'),
                'draft' => __('lang.draft'),
                'ordered' => __('lang.ordered'),
                'pending' => __('lang.pending'),
                'received' => __('lang.received'),
            ];
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name','id');
        $products = Product::orderBy('name', 'asc')->pluck('name', 'id');
        $delivery_type_ids = JobType::where('title', 'Deliveryman')->pluck('id')->toArray();
        $delivery_men = Employee::whereIn('job_type_id', $delivery_type_ids)->pluck('employee_name', 'id')->toArray();

        return view('livewire.invoices.index',
                    compact('sell_lines','categories1','categories2',
                                'categories3','categories4',
                                'customers','customer_types',
                                'payment_status_array','brands',
                                'products','sale_status','delivery_men')
                    );
    }
}
