<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\CustomerType;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\NumberOfLeave;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Utils\MoneySafeUtil;
use App\Utils\StockTransactionUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    protected $commonUtil;


    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;

    }

    /**
   * Display a listing of the resource.
   *
   *
   */
  public function index()
  {
      $employees = Employee::all();
      return view('employees.index')
          ->with(compact('employees'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
      $stores = Store::pluck('name', 'id')->toArray();
      $jobs = JobType::pluck('title', 'id')->toArray();
      $leave_types = LeaveType::all();
      $week_days =  Employee::getWeekDays();
      $payment_cycle = Employee::paymentCycle();
      $commission_type = Employee::commissionType();
      $commission_calculation_period = Employee::commissionCalculationPeriod();
      $modulePermissionArray = User::modulePermissionArray();
      $subModulePermissionArray = User::subModulePermissionArray();
      $products = Product::orderBy('name', 'asc')->pluck('name', 'id');
      $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
      $cashiers = Employee::getDropdownByJobType('Cashier');

      return view('employees.create')
          ->with(
              compact('stores','jobs','leave_types' ,
                'week_days','modulePermissionArray','subModulePermissionArray',
                'payment_cycle','commission_type','commission_calculation_period',
                'products','customer_types','cashiers'
              )
          );

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return RedirectResponse
   */
  public function store(Request $request)
  {
      // return response($request);
      $request->validate([
          'email' => 'required|email|unique:users|max:255',
          'name' => 'required|max:255',
          'password' => 'required|confirmed|max:255',
      ]);

      try {

          DB::beginTransaction();

          $data = $request->except('_token');
//          dd($data['commission_type']);
          $data['fixed_wage'] = !empty($data['fixed_wage']) ? 1 : 0;
          $data['commission'] = !empty($data['commission']) ? 1 : 0;

          $user_data = [
              'name' => $data['name'],
              'email' => $data['email'],
              'password' => Hash::make($data['password']),

          ];
          $user = User::create($user_data);

          $employee = new Employee();
          $employee->employee_name = $data['name'];
          $employee->user_id = $user->id;
          $employee->pass_string = Crypt::encrypt($data['password']);
          $employee->date_of_start_working = $data['date_of_start_working'];
          $employee->date_of_birth = $data['date_of_birth'];
          $employee->job_type_id = $data['job_type_id'];
          $employee->mobile = $data['mobile'];
          $employee->annual_leave_per_year = !empty($data['annual_leave_per_year']) ?  $data['annual_leave_per_year'] : 0;
          $employee->number_of_days_any_leave_added = !empty($data['number_of_days_any_leave_added']) ?  $data['number_of_days_any_leave_added'] : 0;
          $employee->working_day_per_week =json_encode(!empty($data['working_day_per_week']) ?  $data['working_day_per_week'] : []) ;
          $employee->check_in =json_encode(!empty($data['check_in']) ?  $data['check_in'] : []) ;
          $employee->check_out = json_encode(!empty($data['check_out']) ?  $data['check_out'] : []);
          $employee->fixed_wage = $data['fixed_wage'];
          $employee->fixed_wage_value = $data['fixed_wage_value'] ?? 0;
          $employee->payment_cycle = $data['payment_cycle'];
          $employee->commission = $data['commission'];
          $employee->commission_value = $this->commonUtil->num_uf($data['commission_value']) ?? 0;
          $employee->commission_type = $data['commission_type'];
          $employee->commision_calculation_period = $data['commission_calculation_period'];
          $employee->comissioned_products = json_encode(!empty($data['commissioned_products']) ? $data['commissioned_products'] : []);
          $employee->comission_customer_types = json_encode(!empty($data['commission_customer_types']) ? $data['commission_customer_types'] : []);
          $employee->comission_stores = json_encode(!empty($data['commission_stores']) ? $data['commission_stores'] : []);
          $employee->comission_cashier = json_encode(!empty($data['commission_cashiers']) ? $data['commission_cashiers'] : []);
          if ($request->hasFile('photo')) {
              $employee->photo = store_file($request->file('photo'), 'employees');
          }
          $employee->save();
          $employee->stores()->sync($data['store_id']);



        //   if ($request->hasFile('upload_files')) {
        //       foreach ($request->file('upload_files') as $file) {
        //           $employee->addMedia($file)->toMediaCollection('employee_files');
        //       }
        //   }

          //add of update number of leaves
          $this->createOrUpdateNumberofLeaves($request, $employee->id);

          //assign permissions to employee
//          dd($data['permissions']);
          if (!empty($data['permissions'])) {
              foreach ($data['permissions'] as $key => $value) {
                  $permissions[] = $key;
              }

              if (!empty($permissions)) {
                  $user->syncPermissions($permissions);
              }
          }
          DB::commit();

          $output = [
              'success' => true,
              'msg' => __('lang.employee_added')
          ];

          return redirect()->route('employees.index')->with('status', $output);
      }
      catch (\Exception $e) {
          dd($e);
          Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
          $output = [
              'success' => false,
              'msg' => __('lang.something_went_wrong')
          ];

          return redirect()->back()->with('status', $output);

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
      $employee = Employee::findOrFail($id);
      $week_days = Employee::getWeekDays();
      $modulePermissionArray = User::modulePermissionArray();
      $subModulePermissionArray = User::subModulePermissionArray();

      return view('employees.show')
          ->with(
              compact('employee','week_days','modulePermissionArray','subModulePermissionArray')
          );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Application|Factory|View
   */
  public function edit($id)
  {
      $jobs = JobType::pluck('title', 'id')->toArray();
      $customer_types = CustomerType::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
      $cashiers = Employee::getDropdownByJobType('Cashier');
      $week_days = Employee::getWeekDays();
      $payment_cycle = Employee::paymentCycle();
      $commission_type = Employee::commissionType();
      $commission_calculation_period = Employee::commissionCalculationPeriod();
      $modulePermissionArray = User::modulePermissionArray();
//      dd()
      $subModulePermissionArray = User::subModulePermissionArray();
      $employee = Employee::find($id);
      $user = User::find($employee->user_id);
      $stores = Store::pluck('name', 'id')->toArray();
      $selected_stores = $employee->stores->pluck('id');
      $products = Product::orderBy('name', 'asc')->pluck('name', 'id');

      return view('employees.edit')->with(compact(
          'jobs',
          'employee',
          'stores',
          'stores',
          'customer_types',
          'cashiers',
          'week_days',
          'payment_cycle',
          'commission_type',
          'products',
          'commission_calculation_period',
          'modulePermissionArray',
          'subModulePermissionArray',
          'user',
          'selected_stores'
      ));

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id ,Request $request)
  {
//      dd($request);
//      dd($request);
      $validated = $request->validate([
          'email' => 'required|email|max:255',
          'name' => 'required|max:255'
      ]);

      try {

          DB::beginTransaction();

          $data = $request->except('_token');
          $data['date_of_start_working'] = !empty($data['date_of_start_working']) ? Carbon::createFromFormat('m/d/Y', $data['date_of_start_working'])->format('Y-m-d') : null;
          $data['date_of_birth'] = !empty($data['date_of_birth']) ? Carbon::createFromFormat('m/d/Y', $data['date_of_birth'])->format('Y-m-d') : null;
          $data['fixed_wage'] = !empty($data['fixed_wage']) ? 1 : 0;
//          dd($data['fixed_wage_value']);
          $data['commission'] = !empty($data['commission']) ? 1 : 0;

          $user_data = [
              'name' => $data['name'],
              'email' => $data['email']
          ];

          $employee =  Employee::find($id);
          $employee->employee_name = $data['name'];
          $employee->pass_string = Crypt::encrypt($data['password']);
          $employee->date_of_start_working = $data['date_of_start_working'];
          $employee->date_of_birth = $data['date_of_birth'];
          $employee->job_type_id = $data['job_type_id'];
          $employee->mobile = $data['mobile'];
          $employee->annual_leave_per_year = !empty($data['annual_leave_per_year']) ?  $data['annual_leave_per_year'] : 0;
          $employee->number_of_days_any_leave_added = !empty($data['number_of_days_any_leave_added']) ?  $data['number_of_days_any_leave_added'] : 0;
          $employee->working_day_per_week =json_encode(!empty($data['working_day_per_week']) ?  $data['working_day_per_week'] : []) ;
          $employee->check_in =json_encode(!empty($data['check_in']) ?  $data['check_in'] : []) ;
          $employee->check_out = json_encode(!empty($data['check_out']) ?  $data['check_out'] : []);
          $employee->fixed_wage = $data['fixed_wage'];
          $employee->fixed_wage_value = $data['fixed_wage_value'] ?? 0;
          $employee->payment_cycle = $data['payment_cycle'];
          $employee->commission = $data['commission'];
          $employee->commission_value = $data['commission_value']?? 0;
          $employee->commission_type = $data['commission_type'];
          $employee->commision_calculation_period = $data['commission_calculation_period'];
          $employee->comissioned_products = json_encode(!empty($data['commissioned_products']) ? $data['commissioned_products'] : []);
          $employee->comission_customer_types = json_encode(!empty($data['commission_customer_types']) ? $data['commission_customer_types'] : []);
          $employee->comission_stores = json_encode(!empty($data['commission_stores']) ? $data['commission_stores'] : []);
          $employee->comission_cashier = json_encode(!empty($data['commission_cashiers']) ? $data['commission_cashiers'] : []);

          if ($request->hasFile('photo')) {
              $employee->photo = store_file($request->file('photo'), 'employees');
          }
          $employee->save();

          if (!empty($request->input('password'))) {
              $validated = $request->validate([
                  'password' => 'required|confirmed|max:255',
              ]);
              $user_data['password'] = Hash::make($request->input('password'));
              $employee_data['pass_string'] = Crypt::encrypt($data['password']);;
          }

          $user = User::find($employee->user_id);
          User::where('id', $employee->user_id)->update($user_data);


          if ($request->hasFile('upload_files')) {
              foreach ($request->file('upload_files') as $file) {
                  $employee->addMedia($file)->toMediaCollection('employee_files');
              }
          }

         $employee->stores()->sync($data['store_id']);

          //add of update number of leaves
          $this->createOrUpdateNumberofLeaves($request, $id);

          if (!empty($data['permissions'])) {
              foreach ($data['permissions'] as $key => $value) {
                  $permissions[] = $key;
              }

              if (!empty($permissions)) {
                  $user->syncPermissions($permissions);
              }
          }

          DB::commit();

          $output = [
              'success' => true,
              'msg' => __('lang.employee_updated')
          ];

          return redirect()->route('employees.index')->with('status', $output);
      } catch (\Exception $e) {
          Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
          $output = [
              'success' => false,
              'msg' => __('lang.something_went_wrong')
          ];
          dd($e);
          return redirect()->back()->with('status', $output);
      }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function destroy($id)
  {
      try {
          $employee = Employee::find($id);
          $employee->delete();

          $output = [
              'success' => true,
              'msg' => __('lang.job_deleted')
          ];
      }

      catch (\Exception $e) {
          Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
          $output = [
              'success' => false,
              'msg' => __('messages.something_went_wrong')
          ];
      }
      return redirect()->back()->with('status', $output);

  }

  public function  addPoints(){
//      dd('test');
      return view('employees.add_point');
  }

  public function createOrUpdateNumberofLeaves($request, $employee_id)
  {
      if (!empty($request->number_of_leaves)) {
          foreach ($request->number_of_leaves as $key => $value) {
              NumberOfLeave::updateOrCreate(
                  ['employee_id' => $employee_id, 'leave_type_id' => $key],
                  ['number_of_days' => $value['number_of_days'], 'created_by' => Auth::user()->id, 'enabled' => !empty($value['enabled']) ? 1 : 0]
              );
          }
      }
  }


}

?>
