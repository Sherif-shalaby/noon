<?php

namespace App\Http\Controllers;

use App\Utils\ProductUtil;
use Illuminate\Http\Request;
use App\Models\PurchaseOrderLine;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseOrderTransaction;
use App\Models\Store;
use App\Models\Supplier;
use App\Utils\StockTransactionUtil;
use App\Utils\Util;
use Illuminate\Support\Facades\Log;

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
    public function index()
    {
        //
    }
    /* +++++++++++++++ create() +++++++++++++++ */
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $stores = Store::getDropdown();
        $po_no = $this->productUtil->getNumberByType('purchase_order');
        return view('purchase_order.create')->with(compact(
            'suppliers',
            'stores',
            'po_no',
            'products'
        ));
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $products = Product::with('stock_lines')->whereIn('id', $ids)->get();
        return $products;
    }
    // ++++++++++++++++++++++++++++++ Ajax Search : get_products() ++++++++++++++++++++++++++++++++
    // public function search(Request $request)
    // {
    //     // return $request;

    //     // if($request->ajax())
    //     // {
    //     //     $data = Product::all();
    //     //     $output='';
    //     //     if( count($data) > 0 )
    //     //     {
    //     //         $output ='
    //     //                 <thead>
    //     //                     <tr>
    //     //                         <th scope="col">#</th>
    //     //                         <th scope="col">name</th>
    //     //                     </tr>
    //     //                 </thead>
    //     //                 <tbody>';
    //     //                 foreach($data as $row){
    //     //                     $output .='
    //     //                     <tr>
    //     //                     <th scope="row">'.$row->id.'</th>
    //     //                     <td>'.$row->name.'</td>
    //     //                     </tr>
    //     //                     ';
    //     //                 }
    //     //         $output .= '
    //     //             </tbody>';
    //     //     }
    //     //     else
    //     //     {
    //     //         $output .='No results';
    //     //     }
    //     //     return $output;
    //     // }
    // }
    /* ++++++++++++++++++++++++++++++ store() ++++++++++++++++++++++++++ */
    public function store(Request $request)
    {
        // return $request;
        try
        {
            // Create a new PurchaseOrderTransaction instance and populate it with data from the request
            $purchaseOrderTransaction = new PurchaseOrderTransaction();
            $purchaseOrderTransaction->store_id = $request['store_id'];
            $purchaseOrderTransaction->supplier_id = $request['supplier_id'];
            $purchaseOrderTransaction->grand_total = 0; // You'll update this after saving the transaction
            $purchaseOrderTransaction->final_total = $request['total_subtotal'];
            $purchaseOrderTransaction->po_no = $request['po_no'];
            $purchaseOrderTransaction->created_by = auth()->user()->id;
            $purchaseOrderTransaction->order_date = now();
            $purchaseOrderTransaction->transaction_date = now();

            // Save the purchase order transaction to the database
            $purchaseOrderTransaction->save();

            // Retrieve the ID of the saved PurchaseOrderTransaction
            // $transactionId = $purchaseOrderTransaction->id;

            // Create an array to store purchase order lines
            $purchaseOrderLines = [];
            // return $request['product_id'];
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
                $purchaseOrderLine->purchase_transaction_id = $purchaseOrderTransaction->id;
                // return $purchaseOrderLine->purchase_transaction_id;

                $purchaseOrderLine->save();

                // // Push the purchase order line to the array
                // $purchaseOrderLines[] = $purchaseOrderLine->toArray(); // Convert to array
            }
            // return $purchaseOrderLines;


            // Use the insert method to insert all purchase order lines into the database
            // PurchaseOrderLine::insert($purchaseOrderLines);

            // Now, you can update the grand_total and details of the PurchaseOrderTransaction
            $purchaseOrderTransaction->grand_total = $request['total_subtotal'];
            $purchaseOrderTransaction->details = $request['details'];

            // Save the updated PurchaseOrderTransaction
            $purchaseOrderTransaction->save();

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




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrderLine  $purchaseOrderLine
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrderLine $purchaseOrderLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrderLine  $purchaseOrderLine
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrderLine $purchaseOrderLine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrderLine  $purchaseOrderLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrderLine $purchaseOrderLine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrderLine  $purchaseOrderLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrderLine $purchaseOrderLine)
    {
        //
    }
}
