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
    public function indexForRep()
    {
        $delivery_men  = Employee::whereHas('job_type', function ($query) {
            $query->Where('title', 'Representative');
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
        try{

            // Find the DeliveryCustomerPlan and DeliveryLocation by their IDs
            $deliveryLocation = DeliveryLocation::findOrFail($id); // Assuming city_id corresponds to delivery_location_id
            $deliveryCustomerPlan = DeliveryCustomerPlan::where('delivery_location_id',$id)->get();

            // Update the deliveryLocation data
            $deliveryLocation->date = $request->input('date');
            $deliveryLocation->city_id = $request->input('city_id');

            // Update other fields as needed
            $deliveryLocation->save();



            // Get the existing customer IDs from the database records
            $existingCustomerIds = $deliveryCustomerPlan->pluck('customers_id')->toArray();

            // Get the new customer IDs from the request
            $newCustomerIds = $request->customers;

            // Find customer IDs that need to be added (present in the request but not in the database)
            $customerIdsToAdd = array_diff($newCustomerIds, $existingCustomerIds);

            // Find customer IDs that need to be deleted (present in the database but not in the request)
            $customerIdsToDelete = array_diff($existingCustomerIds, $newCustomerIds);

            // Add new customers
            foreach ($customerIdsToAdd as $customerId) {
                $newDeliveryCustomerPlan = new DeliveryCustomerPlan();
                $newDeliveryCustomerPlan->delivery_location_id = $id;
                $newDeliveryCustomerPlan->customers_id = $customerId;
                $newDeliveryCustomerPlan->save();
            }

            // Delete customers that are not in the request
            DeliveryCustomerPlan::where('delivery_location_id', $id)
                ->whereIn('customers_id', $customerIdsToDelete)
                ->delete();

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

        // Redirect to a success page or return a response
        return redirect()->route('delivery_plan.plansList')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery_plan = DeliveryLocation::find($id);
        $delivery_plan->delete();
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
    public function plansListForRep(Request $request)
    {
        $cities = City::pluck('name', 'id');
        $delivery_men = Employee::whereHas('job_type', function ($query) {
            $query->where('title', 'Representative');
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
