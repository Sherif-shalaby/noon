<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\PurchaseOrderTransaction;
use App\Models\State;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\System;
use App\Utils\Util;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('id','desc')->paginate(10);
        $countryId = System::getProperty('country_id');
        $countryName = Country::where('id', $countryId)->pluck('name')->first();
        // return $settings;

        return view('suppliers.index')->with(compact(
            'suppliers','countryId' , 'countryName'
        ));
    }
    /* ++++++++++++++++++++++++++ create() ++++++++++++++++++++ */
    public function create()
    {
        $supplier_categories = Category::where('parent_id',null)->pluck('name', 'id');
        // ++++++++++++++++++++ Country , State , Cities Selectbox ++++++++++++++++
        $countryId = System::getProperty('country_id');
        $countryName = Country::where('id', $countryId)->pluck('name')->first();
        return view('suppliers.create')->with(compact(
            'supplier_categories','countryId','countryName'
        ));
    }
    // ++++++++++++++ fetchState(): to get "states" of "selected country" selectbox ++++++++++++++
    public function fetchState(Request $request)
    {
        $data['states'] = State::where('country_id', $request->country_id)->get(['id','name']);
        return response()->json($data);
    }
    // ++++++++++++++ fetchCity(): to get "cities" of "selected city" selectbox ++++++++++++++
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where('state_id', $request->state_id)->get(['id','name']);
        return response()->json($data);
    }
    /* +++++++++++++++++++ store() +++++++++++++++++++ */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => ['required', 'max:30'],
                    'notes' => ['nullable', 'max:255'],
                    'company_name' => ['required', 'max:30'],
                    'vat_number' => ['nullable', 'max:30'],
                    'email' => ['nullable', 'max:50'],
                    'mobile_number' => ['required', 'max:30'],
                    'address' => ['nullable', 'max:60'],
                    'city' => ['nullable', 'max:30'],
                    'state' => ['nullable', 'max:30'],
                    'country' => ['nullable', 'max:30'],
                ]
            );
            if ($validator->fails()) {
                $output = [
                    'success' => false,
                    'msg' => $validator->getMessageBag()->first()
                ];
                if ($request->ajax()) {
                    return $output;
                }

                return redirect()->back()->withInput()->with('status', $output);
            }
            $data = $request->except('_token','mobile_number','email');
            // ++++++++++++++ store mobile_number in array ++++++++++++++++++
            $data['mobile_number'] = json_encode($request->mobile_number);
            // ++++++++++++++ store email in array ++++++++++++++++++
            $data['email'] = json_encode($request->email);

            $data['created_by'] = Auth::user()->id;
            if ($request->file('image')) {
                $data['image'] = store_file($request->file('image'), 'suppliers');
            }

            $supplier = Supplier::create($data);

            $output = [
                'success' => true,
                'id' => $supplier->id,
                'msg' => __('lang.success')
            ];
            if ($request->ajax()) {
                return $output;
            }
        }
        catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return redirect()->back()->with('status', $output);
    }
    /* +++++++++++++++++++ show() +++++++++++++++++++ */
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        // tab 1 : Stock Transactions : كشف حساب
        $add_stocks = StockTransaction::whereIn('type', ['add_stock', 'purchase_return'])
                                        ->whereIn('status', ['received', 'final'])
                                        // ->where('supplier_id',$id)
                                        ->get();
        // tab 2 : Purchase Orders : الاوامر المعلقة
        $purchase_orders = PurchaseOrderTransaction::whereIn('type', ['purchase_order'])
                                                    ->where('status', 'pending')
                                                    // ->where('supplier_id',$id)
                                                    ->get();
        // dd($purchase_orders);
        return view('suppliers.show',compact('supplier','add_stocks','purchase_orders'));
        // dd($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        $countryId = System::getProperty('country_id');
        $countryName = Country::where('id', $countryId)->pluck('name')->first();
        return view('suppliers.edit')->with(compact(
            'supplier',
            'countryId',
            'countryName'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
//        dd($request);
        try {
            $supplier = Supplier::find($id);
            $data['name'] = $request->name;
            $data['company_name'] = $request->company_name;
            $data['mobile_number'] = $request->mobile_number;
            $data['exchange_rate'] = $request->exchange_rate;
            $data['start_date'] = $request->start_date;
            $data['country'] = $request->country;
            $data['state_id'] = $request->state_id;
            $data['city_id'] = $request->city_id;
            $data['end_date'] = $request->end_date;
            $data['owner_debt_in_dinar'] = $request->owner_debt_in_dinar;
            $data['owner_debt_in_dollar'] = $request->owner_debt_in_dollar;
            $data['email'] = $request->email;
            $data['address'] = $request->address;
            $data['notes'] = $request->notes;
            $data['updated_by'] = Auth::user()->id;
            if ($request->hasFile('image')){
                delete_file($supplier->image);
                $data['image'] = store_file($request->file('image'),'suppliers');
            }
            $supplier->update($data);

            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
         return redirect()->route('suppliers.index')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $brand=Supplier::find($id);
            $brand->deleted_by=Auth::user()->id;
            $brand->save();
            $brand->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
          } catch (\Exception $e) {
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
        $suppliers =Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $suppliers_dp = $this->Util->createDropdownHtml($suppliers, __('lang.please_select'));
        return $suppliers_dp;
    }
}
