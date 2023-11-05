<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RequiredProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\PurchaseOrderLine;
use App\Models\PurchaseOrderTransaction;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;

class RequiredProductController extends Controller
{
    /* ++++++++++++++++++++ index() +++++++++++++++++++++  */
    public function index()
    {
        $requiredProducts = RequiredProduct::all();
        // return $requiredProducts;
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
        // return $request;
        try
        {
            // Retrieve products data from the request
            $products = $request->input('products');
            // Filter the checked rows
            $checkedRows = collect($request->input('products'))->filter(function ($product) {
                return isset($product['checkbox']) && $product['checkbox'] == 1;
            });
            // Group by supplier_id
            $groupedProducts = $checkedRows->groupBy('supplier_id');
            foreach ($groupedProducts as $supplierId => $productsForSupplier)
            {
                foreach ($productsForSupplier as $productData)
                {
                    // +++++++++++++++ Second Way : Store +++++++++++++++++++
                    // +++++++++++++++++++++ Store in "purchaseOrderTransaction" +++++++++++++++++++
                    $purchaseOrderTransaction = new PurchaseOrderTransaction();
                    $purchaseOrderTransaction->store_id = $request['store_id'];
                    $purchaseOrderTransaction->supplier_id = isset($supplierId) ? $supplierId : null ;
                    $purchaseOrderTransaction->grand_total = (isset($productData['purchase_price']) && isset($productData['required_quantity'])) ? $productData['purchase_price'] * $productData['required_quantity'] : 0;
                    $purchaseOrderTransaction->final_total = (isset($productData['purchase_price']) && isset($productData['required_quantity'])) ? $productData['purchase_price'] * $productData['required_quantity'] : 0;
                    // $purchaseOrderTransaction->quantity = (isset($productData['required_quantity']) ) ? $productData['purchase_price'] * $productData['required_quantity'] : 1 ;
                    // $purchaseOrderTransaction->sub_total = (isset($productData['purchase_price']) && isset($productData['required_quantity'])) ? $productData['purchase_price'] * $productData['required_quantity'] : 0;
                    // $purchaseOrderTransaction->po_no = $this->getNumberByType('purchase_order');
                    $purchaseOrderTransaction->po_no ='purchase_order';
                    $purchaseOrderTransaction->created_by = auth()->user()->id;
                    $purchaseOrderTransaction->order_date = (isset($productData['order_date'])) ? $productData['order_date'] : now() ;
                    $purchaseOrderTransaction->transaction_date = now();
                    // Save the purchase order transaction to the database
                    $purchaseOrderTransaction->save();
                    // Retrieve the ID of the saved PurchaseOrderTransaction
                    $transactionId = $purchaseOrderTransaction->id;
                    // dd($transactionId);
                    // +++++++++++++++++++++ Store in "purchaseOrderLine" ++++++++++++++++++
                    // Loop through each product and create a new PurchaseOrderLine instance for each
                    foreach ($productsForSupplier as $productData)
                    {
                        $purchaseOrderLine = new PurchaseOrderLine();
                        $purchaseOrderLine->purchase_order_transaction_id = $transactionId; // Associate the line with the transaction
                        $purchaseOrderLine->product_id = $productData['product_id'];
                        $purchaseOrderLine->quantity = isset($productData['required_quantity']) ? $productData['required_quantity'] : 1 ; // Assuming you have a quantity field in your products
                        $purchaseOrderLine->sub_total = (isset($productData['purchase_price']) && isset($productData['required_quantity'])) ? $productData['purchase_price'] * $productData['required_quantity'] : 0;
                        $purchaseOrderLine->purchase_price = (isset($productData['purchase_price'])) ? $productData['purchase_price'] : 0;
                        $purchaseOrderLine->purchase_price_dollar = (isset($productData['purchase_price_dollar'])) ? $productData['purchase_price_dollar'] : 0;
                        $purchaseOrderLine->created_at = now();
                        $purchaseOrderLine->created_by = auth()->user()->id;
                        // Set other fields of the purchase order line as needed
                        $purchaseOrderLine->save(); // Save the purchase order line to the database
                    };
                    $output =
                    [
                        'success' => true,
                        'msg' => __('lang.success')
                    ];
                }
            }
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
        // try
        // {
        //     DB::beginTransaction();

        //     for ($i = 0; $i < count($employeeIds); $i++)
        //     {
        //         // =============================== PurchaseOrderTransaction ===============================
        //         // Create a new PurchaseOrderTransaction instance and populate it with data from the request
        //         $purchaseOrderTransaction = new PurchaseOrderTransaction();
        //         // $purchaseOrderTransaction->employee_id = $employeeIds[$i];
        //         $purchaseOrderTransaction->order_date = isset($orderDates[$i]) ? $orderDates[$i] : now();
        //         $purchaseOrderTransaction->supplier_id = $supplierIds[$i];
        //         $purchaseOrderTransaction->grand_total = 0;
        //         $purchaseOrderTransaction->final_total = 0;
        //         $purchaseOrderTransaction->type = "purchase_order";
        //         $purchaseOrderTransaction->status = "final";
        //         $purchaseOrderTransaction->transaction_date = now(); // Add missing fields
        //         $purchaseOrderTransaction->details = "";
        //         $purchaseOrderTransaction->store_id = $storeIds[$i]; // Add missing fields
        //         $purchaseOrderTransaction->created_by = auth()->user()->id; // Add missing fields
        //         // $purchaseOrderTransaction->purchase_price = $purchase_prices[$i]; // Add missing fields
        //         // $purchaseOrderTransaction->dollar_purchase_price = $dollar_purchase_prices[$i]; // Add missing fields
        //         // $purchaseOrderTransaction->required_quantity = $required_quantities[$i]; // Add missing fields
        //         $purchaseOrderTransaction->save();
        //         // =============================== PurchaseOrderTransaction ===============================

        //     }

        //     DB::commit();
        //     // Loop through each product and create a new PurchaseOrderLine instance for each
        //     // for ($i = 0; $i < count($request['product_id']); $i++)
        //     // {
        //     //     $purchaseOrderLine = new PurchaseOrderLine();
        //     //     $purchaseOrderLine->product_id = $request['product_id'][$i];
        //     //     $purchaseOrderLine->quantity = $request['quantity'][$i];
        //     //     $purchaseOrderLine->purchase_price = $request['purchase_price'][$i];
        //     //     $purchaseOrderLine->purchase_price_dollar = $request['purchase_price_dollar'][$i];
        //     //     $purchaseOrderLine->sub_total = $request['sub_total'][$i];
        //     //     // Set the purchase_transaction_id to the retrieved transaction ID
        //     //     $purchaseOrderLine->purchase_order_transaction_id = $transactionId;
        //     //     $purchaseOrderLine->save();
        //     //     // Push the purchase order line to the array
        //     // }
        //     // // Now, you can update the grand_total and details of the PurchaseOrderTransaction
        //     // $purchaseOrderTransaction->grand_total = $request['total_subtotal'];
        //     // $purchaseOrderTransaction->details = $request['details'];
        //     // Save the updated PurchaseOrderTransaction
        //     // You can return a success response or redirect to a success page here
        //     $output = [
        //         'success' => true,
        //         'msg' => __('lang.success')
        //     ];
        // }
        // catch (\Exception $e)
        // {
        //     dd($e);
        //     Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
        //     $output = [
        //         'success' => false,
        //         'msg' => __('lang.something_went_wrong')
        //     ];
        // }
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
    /* ++++++++++++++++ getNumberByType() : get "product number" ++++++++++++++++ */
    public function getNumberByType($type, $store_id = null, $i = 1)
    {
        $number = '';
        $store_string = '';
        if (!empty($store_id)) {
            $store_string = $this->getStoreNameFirstLetters($store_id);
        }
        if ($type == 'purchase_order')
        {
            $po_count = PurchaseOrderTransaction::where('type', $type)->count() + $i;
            $number = 'PO' . $store_string . $po_count;
        }
        return $number;
    }
}
