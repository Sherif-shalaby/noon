<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneySafeRequest;
use App\Http\Requests\MoneySafeUpdateRequest;
use App\Models\Currency;
use App\Models\MoneySafe;
use App\Models\Store;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MoneySafeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moneysafe=MoneySafe::latest()->get();
        $stores=Store::getDropdown();
        $currenciesId=System::getProperty('currency') ? json_decode(System::getProperty('currency'), true) : [];
        $selected_currencies=Currency::whereIn('id',$currenciesId)->pluck('currency','id');
        return view('money_safe.index',compact('moneysafe','stores','selected_currencies'));
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
    public function store(MoneySafeRequest $request)
    {
        try {
            $data = $request->except('_token');
            $data['created_by'] = Auth::user()->id;
            $money_safe=MoneySafe::create($data);
            $output = [
              'success' => true,
              'msg' => __('lang.success')
          ];
          }catch (\Exception $e) {
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
        $moneysafe=MoneySafe::find($id);
        $stores=Store::getDropdown();
        $currenciesId=System::getProperty('currency') ? json_decode(System::getProperty('currency'), true) : [];
        $selected_currencies=Currency::whereIn('id',$currenciesId)->pluck('currency','id');
        return view('money_safe.edit')->with(compact('moneysafe','stores','selected_currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MoneySafeUpdateRequest $request, $id)
    {
        try {
            $data = $request->except('_token');
            $data['edited_by'] = Auth::user()->id;
            MoneySafe::find($id)->update($data);
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
      
        return redirect()->back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $money_safe=MoneySafe::find($id);
            $money_safe->deleted_by=Auth::user()->id;
            $money_safe->save();
            $money_safe->delete();
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
