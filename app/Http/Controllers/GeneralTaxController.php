<?php

namespace App\Http\Controllers;

use App\Models\GeneralTax;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGeneralTax;
use App\Http\Requests\UpdateGeneralTax;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Ui\Presets\React;

class GeneralTaxController extends Controller
{
    /* ++++++++++++++++++++ index() ++++++++++++++++++++ */
    public function index()
    {
        $stores=Store::orderBy('created_at', 'desc')->pluck('name','id');
        $general_taxes = GeneralTax::with(['stores'])->get();
        return view('general-tax.index',compact('general_taxes','stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Store::all();
        return view('general-tax.create',compact('stores'));
    }

    /* ++++++++++++++ store() ++++++++++++++ */
    public function store(StoreGeneralTax $request)
    {
        try
        {
            $generalTax = new GeneralTax();
            $generalTax->name = $request->name ;
            $generalTax->rate = $request->rate ;
            $generalTax->details = $request->details ;
            $generalTax->method = $request->method ;
            $generalTax->status = $request->status ;
            $generalTax->created_by = Auth::user()->name;
            // store data
            // return $generalTax;
            $generalTax->save();
            // Store "store_id" And "general_tax_id" in "store_tax" table
            $generalTax->stores()->attach($request->store_id);

            $output = [
                'success' => true,
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
        return redirect()->back()->with('status', $output);
    }

    /* +++++++++++++++++++++ show() +++++++++++++++++++ */
    public function show(GeneralTax $generalTax)
    {
        //
    }

    /* +++++++++++++++++++++ edit() +++++++++++++++++++ */
    public function edit($id)
    {
        $general_taxes = GeneralTax::with('stores')->find($id);
        $stores_data = Store::all();

        return view('general-tax.edit')
            ->with(compact('general_taxes', 'stores_data'));
    }
    /* +++++++++++++++++++++ update() +++++++++++++++++++ */
    public function update(Request $request,$id)
    {
        // return $request;
        try
        {
            // Get "Upated Section" data
            $updated_general_tax = GeneralTax::findOrFail($id);
            // +++++++++++++ update ++++++++++++++
            $updated_general_tax->update([
                // update "name"
                "name" => $request->name ,
                // update "name"
                "rate" => $request->rate,
                // update "method"
                "method" => $request->method ,
                // update "status"
                "status" => $request->status ,
                // update "details"
                "details" => $request->details ,
                // update "updated_by"
                "updated_by" => Auth::user()->name,
            ]);
            // ++++++++++++++++++++ general_tax : update pivot Table ++++++++++++++++++++
            $updated_general_tax->stores()->sync($request->store_id);
            $updated_general_tax->save();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeneralTax  $generalTax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $deleted_general_tax = GeneralTax::find($id);
            $deleted_general_tax->update([
                "deleted_by" => Auth::user()->name
            ]);
            $deleted_general_tax->delete();
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
}
