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

  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index(): View|Factory|Application
  {
      $jobs = JobType::all();
      $modulePermissionArray = User::modulePermissionArray();
      return view('jobs.index')->with(compact('jobs','modulePermissionArray'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return RedirectResponse
   */
    public function store(Request $request)
        //  : RedirectResponse
    {
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
            //   $role = Role::create(['name' => $job->title]);
            $subModulePermissionArray = User::subModulePermissionArray();
            // Check if $request->permissions is not null before looping through it
            if (!is_null($request->permissions))
            {
                // dd("True");
                foreach($request->permissions as $key=>$permission)
                {
                    if (!empty($subModulePermissionArray[$key]))
                    {
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
   * @return Application|Factory|View
   */
  public function edit($id)
  {
      $job = JobType::findOrFail($id);
      $modulePermissionArray = User::modulePermissionArray();
      $subModulePermissionArray = User::subModulePermissionArray();
      $role = Role::where('name',$job->title)->first();
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
          $output = [
              'success' => true,
              'msg' => __('lang.success')
          ];
      } catch (\Exception $e) {
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
    // ++++++++++++++++++++++++ forceDelete ++++++++++++++++++++++++
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
