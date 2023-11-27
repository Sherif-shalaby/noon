<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class JobTypeController extends Controller
{

    // +++++++++++++++++++ index() +++++++++++++++++++
    public function index(): View|Factory|Application
    {
        $jobs = JobType::all();
        // "main_modules" in "permissions table"
        $modulePermissionArray = User::modulePermissionArray();
        // "sub_modules of main_modules" in "permissions table"
        $subModulePermissionArray = User::subModulePermissionArray();
        return view('jobs.index')->with(compact('jobs','modulePermissionArray','subModulePermissionArray'));
    }
    // +++++++++++++++++++ create() +++++++++++++++++++
    public function create()
    {

    }
    // +++++++++++++++++++ store() +++++++++++++++++++
    public function store(Request $request)
    {
        // return response($request);
        $output = []; // Initialize the $output variable
        try
        {
            $job = new JobType();
            $job->title=$request->title;
            $job->created_by = Auth::user()->id;
            $job->date_of_creation = date('Y-m-d');
            $job->save();
            $existingRole = Role::where('name', $job->title)->first();
            // +++++++ Check if the Role Exists : Before creating a new role, check if a role with the same name already exists. If it does, you can use the existing role instead of creating a duplicate
            if (!$existingRole)
            {
                // Role does not exist, create a new one
                $role = Role::create(['name' => $job->title]);
            }
            else
            {
                // Use the existing role
                $role = $existingRole;
            }
            $subModulePermissionArray = User::subModulePermissionArray();
            $data = $request->except('_token');
            // ++++++++++++++++ Assign permissions to "new job" ++++++++++++++++++++++
            // Check if permissions data is present in the request
            if (!empty($request->permissions))
            {
                // Get the permission names from the request
                $permissionNames = array_keys($request->permissions);
                // Check if any permissions exist
                if (!empty($permissionNames))
                {
                    // Find or create permissions in the database
                    $permissions = Permission::whereIn('name', $permissionNames)->get();
                    // Attach the permissions to the job
                    $job->givePermissionTo($permissions);
                }
            }
            $output =
            [
                'success' => true,
                'msg' => __('lang.success')
            ];
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
            dd($e);
        }
        return redirect()->back()->with('status',$output);
    }
    // +++++++++++++++++++ show() +++++++++++++++++++
    public function show($id)
    {

    }
    // +++++++++++++++++++++++ edit() +++++++++++++++++++++++
    public function edit($id)
    {
        $job = JobType::findOrFail($id);
        $modulePermissionArray = User::modulePermissionArray();
        $subModulePermissionArray = User::subModulePermissionArray();
        $role = Role::where('name',$job->title)->first();
        // ====== Edit Permissions ======
        $permissions = $role->permissions;
        $uniqueModuleNames = [];
        foreach ($permissions as $permission)
        {
            $moduleName = $permission->module_name;
            $uniqueModuleNames[$moduleName] = true;
        }
        $uniqueModuleNames = array_keys($uniqueModuleNames);
        return view('jobs.edit',compact('job','modulePermissionArray','subModulePermissionArray','permissions','uniqueModuleNames'));
    }
    // ++++++++++++++++++++++++++ update() +++++++++++++++++++++++++
    public function update(Request $request ,$id)
    {
        try
        {
              $data = [
                  'title' => $request->title,
                  'updated_by' => Auth::user()->id,
              ];
            $data = $request->except('_token');
            $job=JobType::where('id', $id)->first();
            $role=Role::where('name',$job->title)->first();
            $role->update([
            'name' => $request->title,
            ]);
            $job->update($data);
            $rolePermissions = $role->permissions()->delete();
            $subModulePermissionArray = User::subModulePermissionArray();
              foreach($request->permissions as $key=>$permission)
              {
                if (!empty($subModulePermissionArray[$key])) {
                    foreach ($subModulePermissionArray[$key] as $key_sub_module =>  $sub_module) {
                        $permission=Permission::where('name', $key . '.' . $key_sub_module . '.view')->first();
                        if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                        $permission=Permission::where('name', $key . '.' . $key_sub_module . '.edit')->first();
                        if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                        $permission=Permission::where('name', $key . '.' . $key_sub_module . '.create')->first();
                        if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                        $permission=Permission::where('name', $key . '.' . $key_sub_module . '.delete')->first();
                        if (!empty($permission)) {$role->givePermissionTo($permission->id);}
                    }
                }
              }
            // ++++++++++++++++ Update permissions of "job type" ++++++++++++++++++++++
            // Check if permissions data is present in the request
            if (!empty($data['permissions']))
            {
                foreach ($data['permissions'] as $key => $value) {
                    $permissions[] = $key;
                }

                if (!empty($permissions)) {
                    $job->syncPermissions($permissions);
                }
            }
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }
    // ++++++++++++++++++++++++ destroy ++++++++++++++++++++++++
    public function destroy($id): RedirectResponse
    {
        try {
            $job = JobType::find($id);
            $job->delete();

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
    // ++++++++++++++++++++++++ forceDelete ++++++++++++++++++++++++    // ++++++++++++++++++++++++ forceDelete ++++++++++++++++++++++++
    public function forceDelete($id): RedirectResponse
    {
        try {
            JobType::withTrashed()->find($id)->forceDelete();
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

}

?>
