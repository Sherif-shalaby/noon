<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Carbon\Carbon;
use App\Utils\Util;
use App\Models\User;
use App\Models\Brand;
use App\Models\Leave;
use App\Models\Store;
use App\Models\JobType;
use App\Models\Product;
use App\Models\Category;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Attendance;
use App\Models\CustomerType;
use App\Models\EmployeeProducts;
use App\Utils\MoneySafeUtil;
use Illuminate\Http\Request;
use App\Models\NumberOfLeave;
use Illuminate\Support\Facades\DB;
use App\Utils\StockTransactionUtil;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Crypt;

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
        $employees = Employee::orderBY('created_at','desc')->get();

        return view('employees.index')
            ->with(compact('employees'));
    }
    /* +++++++++++++++++++++ filterProducts() ++++++++++++++++++ */
    public function filterProducts(Request $request)
    {
        try
        {
            $category_id     = $request->input('category_id');
            $subcategory1_id = $request->input('subcategory1_id');
            $subcategory2_id = $request->input('subcategory2_id');
            $subcategory3_id = $request->input('subcategory3_id');
            $brand = $request->input('brand');
            $filtered_Products = Product::query();
            if ($category_id)
            {
                $filtered_Products->where('category_id', $category_id);
            }
            if ($subcategory1_id) {
                $filtered_Products->where('subcategory_id1', $subcategory1_id);
            }
            if ($subcategory2_id) {
                $filtered_Products->where('subcategory_id2', $subcategory2_id);
            }
            if ($subcategory3_id) {
                $filtered_Products->where('subcategory_id3', $subcategory3_id);
            }
            if ($brand) {
                $filtered_Products->where('brand_id', $brand);
            }

            // Execute the query and get the filtered products
            $filteredProducts = $filtered_Products->get();

            // Return the filtered products as a JSON response
            return response()->json(['success' => true, 'products' => $filteredProducts]);
        }
        catch (\Exception $e)
        {
            dd($e); // Log the error for debugging
            // return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // +++++++++++++++++++++++++++++ create() +++++++++++++++++++++++++++
    public function create(Request $request)
    {
        $stores = Store::pluck('name', 'id')->toArray();
        $branches = Branch::pluck('name', 'id')->toArray();
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
        // ++++++++++++++++++++++++++++ start : for "employee's products" Filters +++++++++++++++++++++++++++++
        $employee_products=Product::query();
        if( request()->ajax() ){
            $employee_products = $employee_products->when( $request->category_id != null, function ($query) use ( $request ) {
                $query->where('category_id', $request->category_id);
            })
            ->when( $request->subcategory_id1 != null, function ($query) use ( $request ) {
                $query->where('subcategory_id1', $request->subcategory_id1);
            })
            ->when( $request->subcategory_id2 != null, function ($query) use ( $request ) {
                $query->where('subcategory_id2', $request->subcategory_id2);
            })
            ->when( $request->subcategory_id3 != null, function ($query) use ( $request ) {
                $query->where('subcategory_id3', $request->subcategory_id3);
            })
            ->when( $request->brand_id != null, function ($query) use ( $request ) {
                $query->where('brand_id', $request->brand_id);
            })
            // ->latest()->get();
            ->orderBy("created_at","asc")->get();
            return $employee_products;
        }else{
            // $employee_products = $employee_products->latest()->get();
            $employee_products = $employee_products->orderBy("created_at","asc")->get();
        }
        // ++++++++++++++++++++++++++++ end : for "employee's products" Filters +++++++++++++++++++++++++++++
        $categories= Category::whereNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $subcategories= Category::whereNotNull('parent_id')->orderBy('created_at', 'desc')->pluck('name','id');
        $brands=Brand::orderBy('created_at', 'desc')->pluck('name','id');
        return view('employees.create')
            ->with(
                compact('stores','jobs','leave_types' ,'employee_products',
                    'week_days','modulePermissionArray','subModulePermissionArray',
                    'payment_cycle','commission_type','commission_calculation_period',
                    'products','customer_types','cashiers' ,'categories','subcategories','brands','branches'
                )
            );

    }

  /* =========================== store() =========================== */
    public function store(Request $request)
    {
        //   return response($request);
        $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'name' => 'required|max:255',
            'password' => 'required|confirmed|max:255',
        ]);
        try {
            DB::beginTransaction();
            $data = $request->except('_token');
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
            $employee->pass_string = !empty($data['password']) ? Crypt::encrypt($data['password']) : null;
            $employee->date_of_start_working = $data['date_of_start_working'];
            $employee->date_of_birth = $data['date_of_birth'];
            $employee->job_type_id = $data['job_type_id'];
            // Set the mobile attribute based on user input (if provided)
            $employee->mobile = !empty($data['mobile']) ? $data['mobile'] : null;
            $employee->annual_leave_per_year = !empty($data['annual_leave_per_year']) ?  $data['annual_leave_per_year'] : 0;
            $employee->number_of_days_any_leave_added = !empty($data['number_of_days_any_leave_added']) ?  $data['number_of_days_any_leave_added'] : 0;
            // Working per week
            $employee->working_day_per_week = json_encode(!empty($data['working_day_per_week']) ?  $data['working_day_per_week'] : []);
            $employee->check_in = json_encode(!empty($data['check_in']) ?  $data['check_in'] : []);
            $employee->check_out = json_encode(!empty($data['check_out']) ?  $data['check_out'] : []);
            // Evening shift
            $employee->evening_shift_checkbox  = json_encode(!empty($data['evening_shift_checkbox'])  ?  $data['evening_shift_checkbox'] : []);
            $employee->evening_shift_check_in  = json_encode(!empty($data['evening_shift_check_in'])  ?  $data['evening_shift_check_in'] : []);
            $employee->evening_shift_check_out = json_encode(!empty($data['evening_shift_check_out']) ?  $data['evening_shift_check_out'] : []);

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
            $employee->branch_id  = $request->branch_id ?? null;
            if ($request->hasFile('photo')) {
                $employee->photo = store_file($request->file('photo'), 'employees');
            }
            $employee->save();
            // insert "employee_id" and "product_id" of employee's product into "employee_product" table
            if (isset($data['ids'])) {
                for ($i = 0; $i < count($data['ids']); $i++) {
                    $product = Product::find($data['ids'][$i]);
                    if ($product) {
                        // Assuming $employee is already defined or fetched from somewhere
                        $employee->products()->attach($product->id);
                    }
                }
            }
            $employee->stores()->sync($data['store_id']);
            //add of update number of leaves
            $this->createOrUpdateNumberofLeaves($request, $employee->id);
            //assign permissions to employee
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
        } catch (\Exception $e) {
            dd($e);
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];

            return redirect()->back()->with('status', $output);
        }
    }
    /* ============================= show() ============================= */
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
    // ============================= Employee's Products : Real-Time Filters =============================
    // ++++++ fetch_sub_categories1() : Get Sub_Categories1 According to "selected main_categories" selectbox ++++++
    public function fetch_sub_categories1(Request $request)
    {
        $data['subcategory_id1'] = Category::where('parent_id', $request->subcategories1_id)->get(['id','name']);
        return response()->json($data);
    }
    // ++++++ fetch_sub_categories2() : Get Sub_Categories2 According to "selected sub_category1" selectbox ++++++
    public function fetch_sub_categories2(Request $request)
    {
        $data['subcategory_id2'] = Category::where('parent_id', $request->subcategories2_id)->get(['id','name']);
        return response()->json($data);
    }
    // ++++++ fetch_sub_categories3() : Get Sub_Categories3 According to "selected sub_category2" selectbox ++++++
    public function fetch_sub_categories3(Request $request)
    {
        $data['subcategory_id3'] = Category::where('parent_id', $request->subcategories3_id)->get(['id','name']);
        return response()->json($data);
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
      $branches = Branch::pluck('name', 'id')->toArray();
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
          'selected_stores',
          'branches'
      ));

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return RedirectResponse
   */
  public function update($id ,Request $request)
  {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|max:255'
        ]);

        try
        {

            DB::beginTransaction();
            $data = $request->except('_token');
            $data['date_of_start_working'] = !empty($data['date_of_start_working']) ? Carbon::createFromFormat('m/d/Y', $data['date_of_start_working'])->format('Y-m-d') : null;
            $data['date_of_birth'] = !empty($data['date_of_birth']) ? Carbon::createFromFormat('m/d/Y', $data['date_of_birth'])->format('Y-m-d') : null;
            $data['fixed_wage'] = !empty($data['fixed_wage']) ? 1 : 0;
            $data['commission'] = !empty($data['commission']) ? 1 : 0;
            $user_data = [
                'name' => $data['name'],
                'email' => $data['email']
            ];
            $employee =  Employee::find($id);
            $employee->employee_name = $data['name'];
            // Check if a new password is provided in the request
            if (!empty($data['password']))
            {
                // Encrypt and update the new password if provided
                $employee->pass_string = Crypt::encrypt($data['password']);
            }
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
            $employee->branch_id = $request->branch_id ?? null;

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
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
            dd($e);
            return redirect()->back()->with('status', $output);
        }
    }

    /* ============================= destroy() ============================= */
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
    /* ============================= addPoints() ============================= */
    public function  addPoints()
    {
        return view('employees.add_point');
    }
    /* ============================= createOrUpdateNumberofLeaves() ============================= */
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
