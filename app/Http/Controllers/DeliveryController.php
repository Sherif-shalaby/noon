<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\DeliveryCustomerPlan;
use App\Models\DeliveryLocation;
use App\Models\Employee;
use App\Models\State;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_men  = Employee::whereHas('job_type', function ($query) {
            $query->where('title', 'Deliveryman');
        })->get();
        return view('delivery.index',compact('delivery_men'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $delivery = Employee::find($id);
        $countryId = System::getProperty('country_id');
        $countryName = Country::where('id', $countryId)->pluck('name')->first();
        $states = State::where('country_id', $countryId)->get(['id','name']);
        return view('delivery.create',compact('countryName','countryId','states','delivery'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $data = $request->except('_token','customers');
            // ++++++++++++++ store customers in  ++++++++++++++++++
            
        
    
            $data['created_by']=Auth::user()->id;
           
    
            $delivery = DeliveryLocation::create($data);
            foreach($request->customers as $customer){
                $plan = DeliveryCustomerPlan::create(
                    [
                        'delivery_location_id'=>$delivery->id,
                        'customers_id'=>$customer,
                        'created_by'=>Auth::user()->id,
                    ]);

            }
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery_plans = DeliveryCustomerPlan::where('delivery_location_id',$id)->get();
          
        return view('delivery.show',compact('delivery_plans'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = DeliveryLocation::with('customers_plan')->find($id);
        $customerIds = [];

        // Loop through the customers_plan relationship and extract customer IDs
        foreach ($plan->customers_plan as $customerPlan) {
            $customerIds[] = $customerPlan->customers_id;
        }

        // Query the Customer model to get customer records by IDs
        $customers = Customer::whereIn('id', $customerIds)->get();
        $delivery = Employee::find($plan->delivery_id);
        $cityId = city::find($plan->city_id);
        $stateId = State::find($cityId->state_id);
        $countryIdCurrent = Country::find($stateId->country_id);
        $countryId = System::getProperty('country_id');
        $countryName = Country::where('id', $countryId)->pluck('name')->first();
        $states = State::where('country_id', $countryId)->get(['id','name']);
        return view('delivery.edit',compact('plan','countryName','countryId','states','delivery','countryIdCurrent','cityId','stateId','customers','customerIds'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function plansList(Request $request)
    {
        $cities = City::pluck('name', 'id');
        $delivery_men = Employee::whereHas('job_type', function ($query) {
            $query->where('title', 'Deliveryman');
        })->with('user')->get();
        
        $delivery_men_data = $delivery_men->pluck('user.name', 'id');
        
        $user = auth()->user();

        // Retrieve the delivery employee ID
        $deliveryEmployeeId = $user->employee->id;

        // Initialize the query with the DeliveryLocation model
        $query = DeliveryLocation::query();
    //    return  $user->employee->job_type;
        if($user->employee->job_type){
            // If the user is a Deliveryman, filter by delivery ID
            if ($user->employee->job_type->title === 'Deliveryman') {
                $query->where('delivery_id', $deliveryEmployeeId);
            }
        }
        // If a specific date is provided in the request, filter by date
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        if($request->city_id){
            $query->where('city_id', $request->city_id);
        }
        if($request->delivery_id){
            $query->where('delivery_id', $request->delivery_id);
        }
        // Order the results by date in descending order
        $plans = $query->orderByDesc('date')->get();

        return view('delivery.plans', compact('plans','cities','delivery_men_data'));
    }

    public function fetchCustomerByCity(Request $request){
        // return $request->city_id;
        $customers = Customer::where('city_id', $request->city_id)->get(['id','name','address']);
        $customerData = [];
    
        foreach ($customers as $customer) {
            // $matches = [];
            
            preg_match('/@([-?\d\.]+),([-?\d\.]+),/',  $customer->address, $matches);
            $latitude = $matches[1];
            $longitude = $matches[2];
    
            $customerData[] = [
                'id' => $customer->id,
                'name' => $customer->name,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];
        }
    
        return response()->json(['customers' => $customerData]);
    }

    public function signIn(Request $request){
        $delivery_plan = DeliveryCustomerPlan::where('delivery_location_id',$request->delivery_location_id)->where('customers_id',$request->customer_id)->first();
        if($request->sign_in){
            $delivery_plan->signed_at = now();
            $delivery_plan->save();
        }
    }
    public function signOut(Request $request){
        $delivery_plan = DeliveryCustomerPlan::where('delivery_location_id',$request->delivery_location_id)->where('customers_id',$request->customer_id)->first();
        if($request->sign_out){
            $delivery_plan->submitted_at = now();
            $delivery_plan->save();
        }
    }
}
