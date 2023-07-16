<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\NumberOfLeave;use App\Models\Store;
use App\Models\User;
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
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{

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

//      dd($stores);
      return view('employees.create')
          ->with(
              compact('stores','jobs','leave_types' ,
                'week_days','modulePermissionArray','subModulePermissionArray',
                'payment_cycle','commission_type','commission_calculation_period'
              )
          );

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
       $request->validate([
          'email' => 'required|email|unique:users|max:255',
          'name' => 'required|max:255',
          'password' => 'required|confirmed|max:255',
      ]);

      try {

          DB::beginTransaction();

          $data = $request->except('_token');
//          $data['commission'] = !empty($data['commission']) ? 1 : 0;


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
          $employee->save();
          $employee->stores()->sync($data['store_id']);

//          if ($request->hasFile('photo')) {
//              $employee->addMedia($request->photo)->toMediaCollection('employee_photo');
//          }
//
//          if ($request->hasFile('upload_files')) {
//              foreach ($request->file('upload_files') as $file) {
//                  $employee->addMedia($file)->toMediaCollection('employee_files');
//              }
//          }

          //add of update number of leaves
          $this->createOrUpdateNumberofLeaves($request, $employee->id);

          //assign permissions to employee
//          if (!empty($data['permissions'])) {
//              $user->syncPermissions($data['permissions']);
//          }
          DB::commit();

          $output = [
              'success' => true,
              'msg' => __('lang.employee_added')
          ];

          return redirect()->route('employees.index')->with('status', $output);
      }
      catch (\Exception $e) {
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
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {

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
