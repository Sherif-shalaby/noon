<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTax;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductTax;

class ProductTaxController extends Controller
{
    protected $Util;

    /**
     * Constructor
     *
     * @param Utils $product
     * @return void
     */
    public function __construct(Util $Util)
    {
        $this->Util = $Util;
    }
     /* ++++++++++++++++++++ index() ++++++++++++++++++++ */
     public function index()
     {
        $product_taxes = ProductTax::get();
        return view('product-tax.index',compact('product_taxes'));
     }
     /* ++++++++++++++++++++ create() ++++++++++++++++++++ */
     public function create()
     {
         return view('product-tax.create');
     }
     /* ++++++++++++++ store() ++++++++++++++ */
     public function store(Request $request)
     {
//         dd($request);
         try
         {
             $productTax = new ProductTax();
             $productTax->name = $request->name ;
             $productTax->rate = $request->rate ;
             $productTax->details = $request->details ;
             $productTax->status = $request->status ;
             $productTax->created_by = Auth::user()->name;
             // store data
             $productTax->save();

             $output = [
                 'success' => true,
                 'id' => $productTax->id,
                 'msg' => __('lang.success')
             ];
         }
         catch (\Exception $e)
         {
             return $e->getMessage();
             $output = [
                 'success' => false,
                 'msg' => __('lang.something_went_wrong')
             ];
         }
         if ($request->quick_add) {
            return $output;
         }
         return $output;
     }

    /* +++++++++++++++++++++ show() +++++++++++++++++++ */
      public function show($id)
      {
          //
      }

     /* +++++++++++++++++++++ edit() +++++++++++++++++++ */
     public function edit($id)
     {
         $product_tax = ProductTax::findOrFail($id);
         return view('product-tax.edit')
             ->with(compact('product_tax'));
     }
     /* +++++++++++++++++++++ update() +++++++++++++++++++ */
     public function update(Request $request,$id)
     {
         try
         {
             // Get "Upated Section" data
             $updated_product_tax = ProductTax::findOrFail($id);
             // +++++++++++++ update ++++++++++++++
             $updated_product_tax->update([
                 // update "name"
                 "name" => $request->name ,
                 // update "name"
                 "rate" => $request->rate,
                 // update "status"
                 "status" => $request->status ,
                 // update "details"
                 "details" => $request->details ,
                 // update "updated_by"
                 "updated_by" => Auth::user()->name,
             ]);
             // ++++++++++++++++++++ product_tax : update pivot Table ++++++++++++++++++++
             $updated_product_tax->save();
             $output = [
                 'success' => true,
                 'msg' => __('lang.success')
             ];
         } catch (\Exception $e) {
             return  $e->getMessage();
             Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
             $output = [
                 'success' => false,
                 'msg' => __('lang.something_went_wrong')
             ];
         }
         return redirect()->back()->with('status', $output);
     }
    //  ++++++++++++++++ destroy +++++++++++++++++++
     public function destroy($id)
     {
         try
         {
            $deleted_product_tax = ProductTax::findOrFail($id);
            $deleted_product_tax->update([
                "deleted_by" => Auth::user()->name
            ]);
            $deleted_product_tax->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
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

         return $output;
     }
    public function getDropdown()
    {
        $product_tax = ProductTax::orderBy('name', 'desc')->pluck('name', 'id');
        $product_tax_dp = $this->Util->createDropdownHtml($product_tax, __('lang.please_select'));
        return $product_tax_dp;
    }
}
