<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Utils\Util;
use App\Models\City;
use App\Models\State;
use App\Models\System;
use App\Models\Country;
use App\Models\Quarter;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionSellLine;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerImportantDate;
use App\Http\Requests\CustomerRequest;
use Illuminate\Contracts\View\Factory;
use App\Models\PaymentTransactionSellLine;
use App\Http\Requests\CustomerUpdateRequest;
use Illuminate\Contracts\Foundation\Application;

class CustomerController extends Controller
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
   * @return Response
   */
  public function index()
  {
      $customers=Customer::latest()->get();
      return view('customers.index',compact('customers'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
    $customer_types=CustomerType::latest()->pluck('name','id');

    $quick_add = request()->quick_add ?? null;
    $customers = Customer::getCustomerArrayWithMobile();
    // ++++++++++++++++++++ Country , State , Cities Selectbox ++++++++++++++++
    $countryId = System::getProperty('country_id');
    $countryName = Country::where('id', $countryId)->pluck('name')->first();

      if ($quick_add) {
          return view('customers.quick_add')->with(compact(
              'customer_types',
              'customers',
              'quick_add',
          ));
      }
    return view('customers.create',compact('customer_types','countryId','countryName'));

  }
    // ++++++++++++++ fetchState(): to get "states" of "selected country" selectbox ++++++++++++++
    public function fetchState(Request $request)
    {
        // return($request);
        $data['states'] = State::where('country_id', $request->country_id)->get(['id','name']);
        return response()->json($data);
    }
    // ++++++++++++++ fetchCity(): to get "cities" of "selected state" selectbox ++++++++++++++
    public function fetchCity(Request $request)
    {
        // return($request);
        $data['cities'] = City::where('state_id', $request->state_id)->get(['id','name']);
        return response()->json($data);
    }
    // ++++++++++++++ fetchQuarter(): to get "quarters" of "selected city" selectbox ++++++++++++++
    public function fetchQuarter(Request $request)
    {
        // return($request);
        $data['quarters'] = Quarter::where('city_id', $request->city_id)->get(['id','name']);
        return response()->json($data);
    }
  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
    public function store(CustomerRequest $request)
    {
        // dd($request);
        try
        {
            DB::beginTransaction();
            $data = $request->except('_token','phone','email');
            // ++++++++++++++ store phones in array ++++++++++++++++++
            $data['phone'] = json_encode($request->phone);
            // ++++++++++++++ store email in array ++++++++++++++++++
            $data['email'] = json_encode($request->email);
            // ++++++++++++++ store created_by ++++++++++++++++++
            $data['created_by']=Auth::user()->id;
            // ========== uploaded image ==========
            if ($request->file('image'))
            {
                $data['image'] = store_file($request->file('image'), 'customers');
            }
            // dd($data);

            $customer = Customer::create($data);


            if (!empty($request->important_dates)) {
                $this->createOrUpdateCustomerImportantDate($customer->id, $request->important_dates);
            }

            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
            if($request->quick_add){
                return $output;
            }
            DB::commit();

        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            dd($e);
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        //   if ($request->quick_add) {
        //       return $output;
        //   }

        return redirect()->back()->with('status', $output);
    }
    // +++++++++ store region +++++++++++
    public function storeRegion(Request $request)
    {
        try
        {
            // dd($request);
            // Validate the incoming request data
            $validatedData = $request->validate([
                'state_id' => 'required|integer',
                'name' => 'required|string|max:255|unique:cities,name,NULL,id,state_id,' . $request->state_id,
            ]);
            // Create a new region in the cities table
            $city = new City();
            $city->state_id = $request->state_id;
            $city->name = $request->name;
            // Save the new region to the database
            $city->save();
            // Optionally, you can return a response to the client
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            // dd($e);
            $output = [
                'success' => false,
                // 'msg' => __('lang.something_went_wrong')
                'msg' => $e->getMessage(),
            ];
        }
        return redirect()->back()->with('status', $output);
    }

    // +++++++++ store quarter +++++++++++
    public function storeQuarter(Request $request)
    {
        // return($request);
        try
        {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'city_id' => 'required|integer',
                'name' => 'required|string|max:255|unique:quarters,name,NULL,id,city_id,' . $request->input('city_id'),
            ]);
            // Create a new quarter in the quarter table
            $quarter = new Quarter();
            $quarter->city_id = (int)$request->city_id;
            $quarter->name = $request->name;
            // Save the new quarter to the database
            $quarter->save();
            // Optionally, you can return a response to the client
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            // dd($e);
            $output = [
                'success' => false,
                // 'msg' => __('lang.something_went_wrong')
                'msg' => $e->getMessage(),
            ];
        }
        return redirect()->back()->with('status', $output);
    }
    public function createOrUpdateCustomerImportantDate($customer_id, $customer_important_dates)
    {
        $customer=CustomerImportantDate::where('customer_id',$customer_id)->delete();
        foreach ($customer_important_dates as $key => $value) {
            $id = !empty($value['id']) ? $value['id'] : null;
            $customer_important_date = CustomerImportantDate::firstOrNew(['customer_id' => $customer_id, 'id' => $id]);
            $customer_important_date->customer_id = $customer_id;
            $customer_important_date->details = $value['details'];
            $customer_important_date->date = !empty($value['date']) ? Carbon::createFromFormat('Y-m-d', $value['date']) : null;
            $customer_important_date->notify_before_days = $value['notify_before_days'] ?? 0;
            $customer_important_date->created_by = Auth::user()->id;

            $customer_important_date->save();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return view('customers.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        $customer_types = CustomerType::pluck('name', 'id');
        $countryId = System::getProperty('country_id');
        $countryName = Country::where('id', $countryId)->pluck('name')->first();

        return view('customers.edit')->with(compact(
            'customer',
            'customer_types','countryId','countryName'
        ));
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(CustomerUpdateRequest $request,$id)
  {
    try {
        $data = $request->except('_token');
        $data['name'] = $request->name;
      $data['updated_by'] = Auth::user()->id;
      Customer::find($id)->update($data);
      if (!empty($request->important_dates)) {
        $this->createOrUpdateCustomerImportantDate($id, $request->important_dates);
      }else{
        $customer=CustomerImportantDate::where('customer_id',$id)->delete();
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
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    try {
      $customer=Customer::find($id);
      $customer->deleted_by=Auth::user()->id;
      $customer->save();
      $customer->delete();
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
  public function getImportantDateRow()
    {
        $index = request()->index ?? 0;

        return view('customers.important_date_row')->with(compact(
            'index'
        ));
    }
    public function getDropdown()
    {
        $customers = Customer::orderBy('created_by', 'asc')->pluck('name', 'id')->toArray();
        $customers_dp = $this->Util->createDropdownHtml($customers, __('lang.please_select'));
        $output = [$customers_dp , array_key_last($customers)];
        return $output;
    }

    public function get_due(Request $request){
        $today = Carbon::today()->toDateString();

        if (!$request->date) {
             $dues = TransactionSellLine::where('payment_status', '!=', 'paid')
                ->where('status', 'final')
                ->where('due_date', '=', $today)
                ->get();
        } else {
            $dues = TransactionSellLine::where('payment_status', '!=', 'paid')
                ->where('status', 'final')
                ->where('due_date', '=', $request->date)
                ->get();
        }

        return view('customers.due', compact('dues'));
    }
    public function customer_dues($id,Request $request){
        $cities = City::pluck('name', 'id');
        $dues = TransactionSellLine::where('customer_id', $id)
            ->where('payment_status', '!=', 'paid')
            ->where('status', 'final')
            ->where('due_date', '=', $request->date);

        if ($request->date) {
            $dues->where('due_date', '=', $request->date);
        }

        // Add the get() method to execute the query and retrieve the results
        $dues = $dues->get();

        // Now you can use $dues to access the results
        return view('customers.due', compact('dues','cities'));
    }
    public function pay_due_view($id){
        // if(!$request->date){
        $due = TransactionSellLine::where('id',$id)->first();
        $totalPayments = $due->transaction_payments->sum('amount');
        $totalDollarPayments = $due->transaction_payments->sum('dollar_amount');
        $dueAmount = $due->final_total - $totalPayments;
        $dueDollarAmount = $due->dollar_final_total - $totalDollarPayments;
        $dollarExchange = System::getProperty('dollar_exchange');

        return view('customers.due_modal')->with(compact('dueAmount', 'dueDollarAmount','due','dollarExchange'));
    }



    public function pay_due(Request $request, $id){
        // return $request;
        // dd($request);
        $due = TransactionSellLine::where('id',$id)->first();
        $customer = Customer::where('id',$due->customer_id)->first();

            if(number_format($request->dueAmount <= $request->due ) && number_format($request->dueDollarAmount <= $request->due_dollar)){
                // return '1';
                if($request->add_to_customer_balance_dinar < 0){
                    $customer->balance_in_dinar = $customer->balance_in_dinar + abs($request->add_to_customer_balance_dinar);
                }
                if($request->add_to_customer_balance_dollar < 0){
                    $customer->balance_in_dinar = $customer->balance_in_dollar + abs($request->add_to_customer_balance_dollar);
                }
                $payment_data = [
                    'transaction_id' => $due->id,
                    'amount' => $request->due,
                    'dollar_amount' => $request->due_dollar,
                    'method' => 'cash',
                    'paid_on' => Carbon::now(),
                    'exchange_rate' => System::getProperty('dollar_exchange'),
                ];

                if($request->amount_change_dinar && !$request->add_to_customer_balance_dinar){
                    $payment_data['amount_change_dinar']  = abs($request->amount_change_dollar);
                }
                if($request->amount_change_dollar && !$request->add_to_customer_balance_dinar){
                    $payment_data['amount_change_dollar'] = abs($request->amount_change_dollar) ;
                }
                $payment_data['created_by'] = Auth::user()->id;
                $payment_data['payment_for'] =  $due->customer_id;
                $transaction_payment = PaymentTransactionSellLine::create($payment_data);
                $due->dollar_remaining = $due->dollar_remaining - $request->due_dollar;
                $due->dinar_remaining = $due->dinar_remaining - $request->due;
                $due->payment_status = 'paid';
                $due->due_date = null;

            }else if($request->dueAmount > $request->due || $request->dueDollarAmount > $request->due_dollar){
                // return '2';
                $payment_data = [
                    'transaction_id' => $due->id,
                    'amount' => $request->due,
                    'dollar_amount' => $request->due_dollar,
                    'method' => 'cash',
                    'paid_on' => Carbon::now(),
                    'exchange_rate' => System::getProperty('dollar_exchange'),
                ];
                $payment_data['created_by'] = Auth::user()->id;
                $payment_data['payment_for'] =  $due->customer_id;
                $transaction_payment = PaymentTransactionSellLine::create($payment_data);
                if($request->amount_change_dollar >= 0 ){
                    $due->dollar_remaining = $request->amount_change_dollar;
                }
                if($request->amount_change_dinar >= 0 ){
                    $due->dinar_remaining = $request->amount_change_dinar;
                }
                $due->due_date = $request->due_date ;
                $due->payment_status = 'partial';
            }
        $due->save();
        $customer->save();
        $output = [
            'success' => true,
            'msg' => __('lang.success')
        ];
        return redirect()->back()->with('status',$output);
    }
    public function show_customer_invoices($cus_id, $del_id){
      $transactions = TransactionSellLine::where('customer_id', $cus_id)
          ->where('deliveryman_id', $del_id)->get();
      return view('customers.partials.show_invoices', compact('transactions'));
    }
}

?>
