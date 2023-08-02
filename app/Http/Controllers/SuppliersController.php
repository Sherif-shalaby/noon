<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('id','desc')->get();

        return view('suppliers.index')->with(compact(
            'suppliers',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier_categories = Category::where('parent_id',null)->pluck('name', 'id');
        
        return view('suppliers.create')->with(compact(
            'supplier_categories',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'max:30'],
                'company_name' => ['nullable', 'max:30'],
                'vat_number' => ['nullable', 'max:30'],
                'email' => ['nullable', 'email'],
                'mobile_number' => ['nullable', 'max:30'],
                'address' => ['nullable', 'max:60'],
                'city' => ['nullable', 'max:30'],
                'state' => ['nullable', 'max:30'],
                'country' => ['nullable', 'max:30'],
                'postal_code' => ['nullable', 'max:30']
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
        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        if ($request->file('image')) {
            $data['image'] = store_file($request->file('image'), 'suppliers');
        }
        
        Supplier::create($data);
        // return "test";
        return response()->json(['status' => __('lang.success')]);
        // return redirect()->back()->with('status', __('lang.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('suppliers.edit')->with(compact(
            'supplier'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data['name'] = $request->name;
            $data['company_name'] = $request->company_name;
            $data['supplier_category_id'] = $request->supplier_category_id;
            $data['vat_number'] = $request->vat_number;
            $data['email'] = $request->email;
            $data['mobile_number'] = $request->mobile_number;
            $data['address'] = $request->address;
            $data['city'] = $request->city;
            $data['country'] = $request->country;
            $data['postal_code'] = $request->postal_code;
            $data['exchange_rate'] = $request->exchange_rate;
            $data['edited_by'] = Auth::user()->id;
            Supplier::find($id)->update($data);
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
        return response()->json(['status' => $output]);
        // return redirect()->back()->with('status', $output);
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
}
