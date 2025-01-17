<?php

namespace App\Http\Controllers;

use App\Utils\Util;
use App\Models\Brand;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Supplier;
use App\Utils\ProductUtil;
use App\Models\AddStockLine;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\PurchaseOrderLine;
use Illuminate\Support\Facades\DB;
use App\Utils\StockTransactionUtil;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseOrderTransaction;
use Carbon\Carbon;

class PurchaseOrderLineController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;
    protected $transactionUtil;
    protected $productUtil;
    protected $notificationUtil;


    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, StockTransactionUtil $transactionUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
    }

    /* +++++++++++++++ index() +++++++++++++++ */
    public function index(Request $request)
    {
        // ---------- filters ------------------
        $stores = Store::pluck('name', 'id')->toArray();
        $categories = Category::where('parent_id',1)->orderBy('created_at', 'desc')->pluck('name', 'id');
        $subcategories1 = Category::where('parent_id',2)->orderBy('created_at', 'desc')->pluck('name', 'id');
        $subcategories2 = Category::where('parent_id',3)->orderBy('created_at', 'desc')->pluck('name', 'id');
        $subcategories3 = Category::where('parent_id',4)->orderBy('created_at', 'desc')->pluck('name', 'id');
        $products = Product::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        // ++++++++++++++++++++++++++++ start: for "employee's products" Filters +++++++++++++++++++++++++++++
        $purchaseOrders = PurchaseOrderTransaction::query();

        if ($request->ajax())
        {
            // category_id
            $purchaseOrders = $purchaseOrders->when($request->category_id, function ($query) use ($request) {
                $products = Product::where('category_id', $request->category_id)->get();
                $productIds = $products->pluck('id');
                $purchaseOrderLines = PurchaseOrderLine::whereIn('product_id', $productIds)->pluck('purchase_order_transaction_id');
                $query->whereIn('id', $purchaseOrderLines);
            })
            // subcategory_id1
            ->when($request->subcategory_id1, function ($query) use ($request) {
                $products = Product::where('subcategory_id1', $request->subcategory_id1)->get();
                $productIds = $products->pluck('id');
                $purchaseOrderLines = PurchaseOrderLine::whereIn('product_id', $productIds)->pluck('purchase_order_transaction_id');
                $query->whereIn('id', $purchaseOrderLines);
            })
            // subcategory_id2
            ->when($request->subcategory_id2, function ($query) use ($request) {
                $products = Product::where('subcategory_id2', $request->subcategory_id2)->get();
                $productIds = $products->pluck('id');
                $purchaseOrderLines = PurchaseOrderLine::whereIn('product_id', $productIds)->pluck('purchase_order_transaction_id');
                $query->whereIn('id', $purchaseOrderLines);
            })
            // subcategory_id3
            ->when($request->subcategory_id3, function ($query) use ($request) {
                $products = Product::where('subcategory_id3', $request->subcategory_id3)->get();
                $productIds = $products->pluck('id');
                $purchaseOrderLines = PurchaseOrderLine::whereIn('product_id', $productIds)->pluck('purchase_order_transaction_id');
                $query->whereIn('id', $purchaseOrderLines);
            })
            // product_id
            ->when( $request->product_id != null, function ($query) use ( $request ) {
                $products = Product::where('id', $request->product_id)->get();
                $productIds = $products->pluck('id');
                $purchaseOrderLines = PurchaseOrderLine::whereIn('product_id', $productIds)->pluck('purchase_order_transaction_id');
                $query->whereIn('id', $purchaseOrderLines);
            })
            // +++++++++ purchase_type +++++++++
            ->when($request->purchase_type_id != null, function ($query) use ($request) {
                // Get "All Stock_Transactions" that have "purchase_type" filter value
                $stock_transactions = StockTransaction::where('purchase_type', $request->purchase_type_id)->get();
                // Assuming $stock_transactions is a collection, so we need to loop through it
                foreach ($stock_transactions as $stock_transaction)
                {
                    // Get "All products_id of Stock_lines" of "stock_transaction"
                    $products = AddStockLine::where('stock_transaction_id', $stock_transaction->id)->pluck('product_id');
                    $productIds = $products->toArray(); // Convert to array
                    // Check if $productIds is not empty before proceeding
                    if (!empty($productIds)) {
                        $purchaseOrderLines = PurchaseOrderLine::whereIn('product_id', $productIds)->pluck('purchase_order_transaction_id');
                        $query->whereIn('id', $purchaseOrderLines);
                        return  $purchaseOrderLines ;
                    }
                }
            })
            ->when($request->purchase_type_id != null, function ($query) use ($request) {
                $query->whereHas('add_stock_lines', function ($subquery) use ($request) {
                    $subquery->whereHas('product', function ($productSubquery) use ($request) {
                        $productSubquery->where('purchase_type', $request->purchase_type_id);
                    });
                });
            })

            ->orderBy("created_at", "asc")->get();
            // +++++++++++ sum of "final_total" column ++++++++++++++
            $final_total_sum = $purchaseOrders->sum('final_total');
            // Get the total number of rows
            $totalRows = count($purchaseOrders);
            return $purchaseOrders;
        }
        else
        {
            $purchaseOrders = $purchaseOrders->orderBy("created_at", "asc")->get();
        }
        // +++++++++++ sum of "final_total" column ++++++++++++++
        $final_total_sum = $purchaseOrders->sum('final_total');

        return view('purchase_order.index',
                    compact('purchaseOrders', 'stores', 'categories',
                         'subcategories1','subcategories2','subcategories3', 'products', 'final_total_sum'));
    }

    /* +++++++++++++++ create() +++++++++++++++ */
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $stores = Store::getDropdown();
        $po_no = $this->productUtil->getNumberByType('purchase_order');
        $branch_id = Employee::select('branch_id')->where('id', auth()->user()->id)->latest()->first();
        $brands = Brand::orderby('created_at', 'desc')->pluck('name', 'id');
        return view('purchase_order.create')->with(compact(
            'suppliers',
            'stores',
            'po_no',
            'products',
            'brands','branch_id'
        ));
    }
    /* +++++++++++++++ deleteAll() +++++++++++++++ */
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $products = Product::with('stock_lines')->whereIn('id', $ids)->get();
        return $products;
    }

    /* ++++++++++++++++++++++++++++++ store() ++++++++++++++++++++++++++ */
    public function store(Request $request)
    {
        // return $request;
        try
        {
            DB::beginTransaction();
            // Create a new PurchaseOrderTransaction instance and populate it with data from the request
            $purchaseOrderTransaction = new PurchaseOrderTransaction();
            $purchaseOrderTransaction->store_id = $request['store_id'];
            $purchaseOrderTransaction->supplier_id = $request['supplier_id'];
            $purchaseOrderTransaction->grand_total = 0; // You'll update this after saving the transaction
            $purchaseOrderTransaction->final_total = $request['total_subtotal'];
            $purchaseOrderTransaction->po_no = $request['po_no'];
            // $purchaseOrderTransaction->created_by = auth()->user()->id;
            $purchaseOrderTransaction->order_date = now();
            $purchaseOrderTransaction->transaction_date = now();
            // Save the purchase order transaction to the database
            $purchaseOrderTransaction->save();
            // Retrieve the ID of the saved PurchaseOrderTransaction
            $transactionId = $purchaseOrderTransaction->id;
            // Loop through each product and create a new PurchaseOrderLine instance for each
            for ($i = 0; $i < count($request['product_id']); $i++)
            {
                $purchaseOrderLine = new PurchaseOrderLine();
                $purchaseOrderLine->product_id = $request['product_id'][$i];
                $purchaseOrderLine->quantity = $request['quantity'][$i];
                $purchaseOrderLine->purchase_price = $request['purchase_price'][$i];
                $purchaseOrderLine->purchase_price_dollar = $request['purchase_price_dollar'][$i];
                $purchaseOrderLine->sub_total = $request['sub_total'][$i];
                // Set the purchase_transaction_id to the retrieved transaction ID
                $purchaseOrderLine->purchase_order_transaction_id = $transactionId;
                $purchaseOrderLine->save();
                // Push the purchase order line to the array
            }
            // Now, you can update the grand_total and details of the PurchaseOrderTransaction
            $purchaseOrderTransaction->grand_total = $request['total_subtotal'];
            $purchaseOrderTransaction->details = $request['details'];
            // Save the updated PurchaseOrderTransaction
            $purchaseOrderTransaction->save();
            DB::commit();
            // You can return a success response or redirect to a success page here
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        }
        catch (\Exception $e)
        {
            dd($e);
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }
    /* ++++++++++++++++++++++++++++++ show() ++++++++++++++++++++++++++ */
    public function show($id)
    {
        $purchase_order = PurchaseOrderTransaction::with('transaction_purchase_order_lines')->findOrFail($id);
        $supplier = Supplier::find($purchase_order->supplier_id);
        // dd($purchase_order);
        return view('purchase_order.show',compact('purchase_order'));
    }
    /* ++++++++++++++++++++++++++++++ edit() ++++++++++++++++++++++++++ */
    public function edit($id)
    {
        $purchase_order = PurchaseOrderTransaction::find($id);
        $products = Product::all();
        // dd($purchase_order->status);
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $stores = Store::getDropdown();
        // $status_array = $this->commonUtil->getPurchaseOrderStatusArray();
        $status_array = ['received', 'pending'];
        // dd($status_array);
        return view('purchase_order.edit')->with(compact(
            'purchase_order',
            'status_array',
            'suppliers',
            'stores',
            'id',
            'products'
        ));
    }
    /* ++++++++++++++++++++++++++++++ edit() ++++++++++++++++++++++++++ */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrderLine  $purchaseOrderLine
     * @return \Illuminate\Http\Response
     */
    /* ============================= destroy() ============================= */
    public function destroy($id)
    {
        try
        {
            $purchase_order = PurchaseOrderTransaction::find($id);
            // Set the 'deleted_by' column to the name of the user who is deleting the record
            $purchase_order->deleted_by = Auth::user()->id;
            $purchase_order->save();
            // Soft delete the record
            $purchase_order->delete();

            $output = [
                'success' => true,
                'msg' => __('lang.job_deleted')
            ];
        }

        catch (\Exception $e)
        {
            // Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            // $output = [
            //     'success' => false,
            //     'msg' => __('messages.something_went_wrong')
            // ];
        }
        return redirect()->back()->with('status', $output);
    }
    // ============================= show softDeletedRecords ========================
    public function softDeletedRecords()
    {
        $softDeletedRecords = PurchaseOrderTransaction::onlyTrashed()->get();
        // dd($softDeletedRecords);
        return view('purchase_order.soft_deleted_records', compact('softDeletedRecords'));
    }
    // ============================= restore softDeletedRecords ========================
    public function restore($id)
    {
        // dd($id);
        try
        {
            $record = PurchaseOrderTransaction::withTrashed()->findOrFail($id);
            // Restore the soft-deleted record
            $record->restore();
            $output = [
                'success' => true,
                'msg' => __('lang.restored_success'),
            ];
            return redirect()->back()->with('status', $output);
        }
        catch (\Exception $e)
        {
            dd($e);
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
    }
    // ============================= forceDelete softDeletedRecords ========================
    public function forceDelete($id)
    {
        // dd($id);
        try
        {
            $record = PurchaseOrderTransaction::withTrashed()->findOrFail($id);
            // Restore the soft-deleted record
            $record->forceDelete();
            $output = [
                'success' => true,
                'msg' => __('lang.forceDelete'),
            ];
            return redirect()->back()->with('status', $output);
        }
        catch (\Exception $e)
        {
            dd($e);
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
    }
}
