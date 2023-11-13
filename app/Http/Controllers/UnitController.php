<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Http\Requests\UnitupdateRequest;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Unit;
use App\Models\Variation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Utils\Util;
class UnitController extends Controller
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
    public function index(){
        $units = Unit::latest()->paginate(10);
        $unitArray = Unit::orderBy('created_at','desc')->pluck('name', 'id');
        return view('units.index', compact('units','unitArray'));

    }
    public function store(UnitRequest $request){
        try {
            $input['name'] = $request->name;
            $input['slug'] = Str::slug($request->name);
            $input['base_unit_multiplier'] = $request->base_unit_multiplier?? 1;
            $input['base_unit_id'] = $request->base_unit_id?? 0;
            if(!empty($request->translations))
            {
                $input['translation']= $request->translations;
            }else{
                $input['translation']=[];
            }
            $unit=Unit::create($input);
            $output = [
                'success' => true,
                'id' => $unit->id,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        if ($request->quick_add) {
            return $output;
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
    public function getDropdown()
    {
        $units = Unit::orderBy('name', 'asc')->pluck('name', 'id');
        $units_dp = $this->Util->createDropdownHtml($units, __('lang.please_select'));
        return $units_dp;
    }
    public function getUnitData($id){
        return Unit::Find($id);
    }
    public function getUnitsDropdown(Request $request){
        // return $request->all();
        $dataArray = json_decode($request->selectBoxValues, true);
        $units = Unit::whereIn('id',$dataArray)->orderBy('name', 'asc')->pluck('name', 'id');
        $units_dp = $this->Util->createDropdownHtml($units, __('lang.please_select'));
        return $units_dp;
    }
    public function getUnitStore(Request $request){
        $variation=Variation::find($request->variation_id);
        $product=Product::find($request->product_id);
        foreach($product->product_stores as $store){
            $unit=!empty($store->variations)?$store->variations:[];
        }
        $amount=0;
        if(isset($unit->unit_id) && ($unit->unit_id == $variation->unit_id)){
            return ['name'=>$variation->unit->name,'store'=>$product->product_stores->sum('quantity_available')];
        }else if(isset($unit->unit_id) && ($unit->unit_id == $variation->basic_unit_id)){
            return ['name'=>$variation->unit->name,'store'=>$product->product_stores->sum('quantity_available')/ $variation->equal];
        }else if(isset($unit->basic_unit_id) && ($unit->basic_unit_id == $variation->unit_id)){
            return ['name'=>$variation->unit->name,'store'=>number_format( $unit->equal * $product->product_stores->sum('quantity_available'),3)];
        }else{
            $amount=1;
            foreach($product->variations as $var){
                    if($var->unit_id==$unit->unit_id){
                        continue;
                    }else{
                        if(isset($var->equal)){
                            $amount *= $var->equal;
                        }
                        if($var->unit_id == $variation->unit_id){
                            break;
                        }
                    }
            }
            return ['name'=>$variation->unit->name,'store'=>number_format( $product->product_stores->sum('quantity_available') / $amount,3)];

        }
    }
}
