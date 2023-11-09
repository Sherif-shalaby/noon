<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\SellCar;
use App\Models\Store;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SellCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $sell_cars=SellCar::latest()->get();
        $rep_job=JobType::where('title','Representative')->pluck('id')->toArray();
        $del_types=JobType::where('title','Deliveryman')->pluck('id')->toArray();
        $representatives = Employee::whereIn('job_type_id',$rep_job)->pluck('employee_name','id')->toArray();
        $deliveries = Employee::whereIn('job_type_id',$del_types)->pluck('employee_name','id')->toArray();
        return view('sell-car.index',compact('sell_cars','representatives','deliveries'));
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        try {
            $data = $request->except('_token');
            $data['created_by']=Auth::user()->id;
            DB::beginTransaction();
            $sell_car = SellCar::create($data);

            if(!empty($request->has_store_pos)){

                $branch = new Branch();
                $branch->name = $sell_car->car_name;
                $branch->type = 'sell_car';
                $branch->created_by  = Auth::user()->id;
                $branch->sell_car_id = $sell_car->id;
                $branch->save();

                $store = new Store();
                $store->name =$sell_car->car_name . "_store";
                $store->created_by = Auth::user()->id;
                $store->branch_id  = $branch->id;
                $store->save();
                if(!empty($request->representative_id )){
                    $employee = Employee::find($request->representative_id );
                    if(!empty($employee->stores)){
                        foreach ($employee->stores as $store){
                            if($store->branch->type == 'branch'){
                                $employee->stores()->detach($store->id);
                            }
                        }
                    }
                    $employee->branch_id  = $branch->id;
                    $employee->stores()->attach($store->id);
                    $employee->save();

                }
                if(!empty($request->driver_id  )){
                    $employee = Employee::find($request->driver_id  );
                    if(!empty($employee->stores)){
                        foreach ($employee->stores as $store){
                            if($store->branch->type == 'branch'){
                                $employee->stores()->detach($store->id);
                            }
                        }
                    }
                    $employee->branch_id  = $branch->id;
                    $employee->stores()->attach($store->id);
                    $employee->save();
                }
            }
            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
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
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $sell_car=SellCar::find($id);
        $rep_job=JobType::where('title','Representative')->pluck('id')->toArray();
        $del_types=JobType::where('title','Deliveryman')->pluck('id')->toArray();
        $representatives = Employee::whereIn('job_type_id',$rep_job)->pluck('employee_name','id')->toArray();
        $deliveries = Employee::whereIn('job_type_id',$del_types)->pluck('employee_name','id')->toArray();
        return view('sell-car.edit',compact('sell_car','representatives','deliveries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->except('_token','_method');
            $data['car_no'] = $request->car_no;
            $data['edited_by'] = Auth::user()->id;
            SellCar::find($id)->update($data);
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
        try {
            $sell_car=SellCar::find($id);
            DB::beginTransaction();
            $sell_car->deleted_by=Auth::user()->id;
            $sell_car->save();

            if( $sell_car->delete() ){
                $branch = $sell_car->branch;
                if(!empty($branch)){
                    $branch->deleted_by = Auth::user()->id;
                    $store = $branch->stores->first();
                    if(!empty($store)){
                        $store->deleted_by = Auth::user()->id;
                        $store->delete();
                    }
                    $branch->delete();
                }
            }
            DB::commit();
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
