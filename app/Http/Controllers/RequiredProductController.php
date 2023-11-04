<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RequiredProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\PurchaseOrderTransaction;
use Illuminate\Support\Facades\Auth;

class RequiredProductController extends Controller
{
    /* ++++++++++++++++++++ index() +++++++++++++++++++++  */
    public function index()
    {
        $requiredProducts = RequiredProduct::all();
        return view('purchase_order.required_products.index',compact('requiredProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /* ++++++++++++++++++++ store() ++++++++++++++++++++ */
    public function store(Request $request)
    {
        // +++++++++++++++++ Arrays +++++++++++++++++
        $employeeIds = $request->input('employee_ids');
        $orderDates = $request->input('order_dates');
        $productIds = $request->input('product_ids');
        $storeIds = $request->input('store_id');
        $status = $request->input('status');
        $supplierIds = $request->input('supplier_id');
        $branchIds = $request->input('branch_id');
        $purchase_prices = $request->input('purchase_price');
        $dollar_purchase_prices = $request->input('dollar_purchase_price');
        $required_quantities = $request->input('required_quantity');
        try {
            DB::beginTransaction();

            for ($i = 0; $i < count($employeeIds); $i++)
            {
                // =============================== PurchaseOrderTransaction ===============================
                // Create a new PurchaseOrderTransaction instance and populate it with data from the request
                $purchaseOrderTransaction = new PurchaseOrderTransaction();
                // $purchaseOrderTransaction->employee_id = $employeeIds[$i];
                $purchaseOrderTransaction->order_date = isset($orderDates[$i]) ? $orderDates[$i] : now();
                $purchaseOrderTransaction->supplier_id = $supplierIds[$i];
                $purchaseOrderTransaction->grand_total = 0;
                $purchaseOrderTransaction->final_total = 0;
                $purchaseOrderTransaction->type = "purchase_order";
                $purchaseOrderTransaction->status = "final";
                $purchaseOrderTransaction->transaction_date = now(); // Add missing fields
                $purchaseOrderTransaction->details = "";
                $purchaseOrderTransaction->store_id = $storeIds[$i]; // Add missing fields
                $purchaseOrderTransaction->created_by = auth()->user()->id; // Add missing fields
                // $purchaseOrderTransaction->purchase_price = $purchase_prices[$i]; // Add missing fields
                // $purchaseOrderTransaction->dollar_purchase_price = $dollar_purchase_prices[$i]; // Add missing fields
                // $purchaseOrderTransaction->required_quantity = $required_quantities[$i]; // Add missing fields
                $purchaseOrderTransaction->save();
                // =============================== PurchaseOrderTransaction ===============================

            }

            DB::commit();
            // Loop through each product and create a new PurchaseOrderLine instance for each
            // for ($i = 0; $i < count($request['product_id']); $i++)
            // {
            //     $purchaseOrderLine = new PurchaseOrderLine();
            //     $purchaseOrderLine->product_id = $request['product_id'][$i];
            //     $purchaseOrderLine->quantity = $request['quantity'][$i];
            //     $purchaseOrderLine->purchase_price = $request['purchase_price'][$i];
            //     $purchaseOrderLine->purchase_price_dollar = $request['purchase_price_dollar'][$i];
            //     $purchaseOrderLine->sub_total = $request['sub_total'][$i];
            //     // Set the purchase_transaction_id to the retrieved transaction ID
            //     $purchaseOrderLine->purchase_order_transaction_id = $transactionId;
            //     $purchaseOrderLine->save();
            //     // Push the purchase order line to the array
            // }
            // // Now, you can update the grand_total and details of the PurchaseOrderTransaction
            // $purchaseOrderTransaction->grand_total = $request['total_subtotal'];
            // $purchaseOrderTransaction->details = $request['details'];
            // Save the updated PurchaseOrderTransaction
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
     * @param  \App\Models\RequiredProduct  $requiredProduct
     * @return \Illuminate\Http\Response
     */
    public function show(RequiredProduct $requiredProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequiredProduct  $requiredProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(RequiredProduct $requiredProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequiredProduct  $requiredProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequiredProduct $requiredProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequiredProduct  $requiredProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequiredProduct $requiredProduct)
    {
        //
    }
}
