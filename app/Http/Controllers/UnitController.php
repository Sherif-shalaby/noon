<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Http\Requests\UnitupdateRequest;
use App\Models\Unit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function index(){
        $units = Unit::latest()->paginate(10);
        return view('units.index', compact('units'));
    }
    public function store(UnitRequest $request){
        try {
            $input['name'] = $request->name;
            $input['slug'] = Str::slug($request->name);
            $input['base_unit_multiplier'] = $request->base_unit_multiplier?? 1;
            if(!empty($request->translations))
            {
                $input['translation']= $request->translations;
            }else{
                $input['translation']=[];
            }
            Unit::create($input);
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
    public function update(UnitupdateRequest $request, Unit $unit){
        try {
            $input['name'] = $request->name;
            $input['slug'] = Str::slug($request->name);
            $input['base_unit_multiplier'] = $request->base_unit_multiplier?? 1;
            if(!empty($request->translations))
            {
                $input['translation']= $request->translations;
            }else{
                $input['translation']=[];
            }
            $unit->update($input);
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

    public function destroy(Unit $unit){
        try {
            $unit->delete();
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
