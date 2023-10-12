<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\System;
use App\Models\JobType;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\MoneySafe;
use App\Models\GeneralTax;
use App\Models\AddStockLine;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\customer_offer_price;
use App\Models\TransactionCustomerOfferPrice;

class CustomerOfferPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livewire.customer-price-offer.index');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer_offer_price  $customer_offer_price
     * @return \Illuminate\Http\Response
     */
    // public function show(customer_offer_price $customer_offer_price)
    // {
    //     //
    // }

    /* +++++++++++++++++ edit() +++++++++++++++++  */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer_offer_price  $customer_offer_price
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, customer_offer_price $customer_offer_price)
    // {
    //     //
    // }
    public function getPurchaseOrderStatusArray()
    {
        return [
            'draft' => __('lang.draft'),
            'sent_admin' => __('lang.sent_to_admin'),
            'sent_supplier' => __('lang.sent_to_supplier'),
            'received' => __('lang.received'),
            'pending' => __('lang.pending'),
            'partially_received' => __('lang.partially_received'),
        ];
    }
    public function getPaymentStatusArray()
    {
        return [
            'partial' => __('lang.partially_paid'),
            'paid' => __('lang.paid'),
            'pending' => __('lang.pay_later'),
        ];
    }

    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }
    /* +++++++++++++++++++++++++ destroy() +++++++++++++++++++++++++ */
    public function destroy($id)
    {
        try
        {
            // Find the TransactionCustomerOfferPrice by ID
            $transaction_customer_offer_price = TransactionCustomerOfferPrice::findOrFail($id);
            // Get the related products
            $products = $transaction_customer_offer_price->transaction_customer_offer_price;
            // Start a database transaction
            DB::beginTransaction();
            // Delete the related products
            foreach ($products as $product)
            {
                $product->delete();
            }
            // Delete the TransactionCustomerOfferPrice
            $transaction_customer_offer_price->delete();

            // Commit the transaction
            DB::commit();

            $output = [
                'success' => true,
                'msg' => __('lang.delete_msg')
            ];
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        // Return the output (success/failure message)
        return redirect()->back()->with('status', $output);
}

}
