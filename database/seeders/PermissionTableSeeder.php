<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulePermissionArray = User::modulePermissionArray();
        $subModulePermissionArray = User::subModulePermissionArray();

        $data = [];
        foreach ($modulePermissionArray as $key_module => $moudle) {
            if (!empty($subModulePermissionArray[$key_module])) {
                foreach ($subModulePermissionArray[$key_module] as $key_sub_module =>  $sub_module) {
                    $data[] = ['name' => $key_module];
                    $data[] = ['name' => $key_module . '.' . $key_sub_module . '.view'];
                    $data[] = ['name' => $key_module . '.' . $key_sub_module . '.create'];
                    $data[] = ['name' => $key_module . '.' . $key_sub_module . '.edit'];
                    $data[] = ['name' => $key_module . '.' . $key_sub_module . '.delete'];
                }
            }
        }

        $insert_data = [];
        $time_stamp = Carbon::now()->toDateTimeString();
        foreach ($data as $index=>$d) {
            $d['id'] = $index+1;
            $d['guard_name'] = 'web';
            $d['created_at'] = $time_stamp;
            $insert_data[] = $d;
        }
        foreach ($insert_data as $item) {
            Permission::updateOrCreate(['id' => $item['id']],$item);
        }
    }
}
