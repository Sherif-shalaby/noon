<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\Store;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user_data = [
            'id'=>1,
            'name' => 'superadmin',
            'email' => 'superadmin@sherifshalaby.tech',
            'password' => Hash::make('123456'),
             'is_superadmin' => 1,
             'is_admin' => 0,
             'is_detault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        User::updateOrCreate(['id'=>1],$user_data);

        $employee_data = [
            'id'=>1,
            'user_id' => 1,
            'employee_name' => 'superadmin',
            'date_of_start_working' => Carbon::now(),
            'date_of_birth' => '1995-02-03',
            'annual_leave_per_year' => '10',
            'sick_leave_per_year' => '10',
            'mobile' => '123456789',
        ];
        Employee::updateOrCreate(['id'=>1],$employee_data);

        $user_data = [
            'id'=>2,
            'name' => 'Admin',
            'email' => 'admin@sherifshalaby.tech',
            'password' => Hash::make('123456'),
             'is_superadmin' => 0,
             'is_admin' => 1,
             'is_detault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $user = User::updateOrCreate(['id'=>2],$user_data);
        $employee_data = [
            'id'=>2,
            'user_id' => 2,
            'employee_name' => 'Admin',
            'date_of_start_working' => Carbon::now(),
            'date_of_birth' => '1995-02-03',
            'annual_leave_per_year' => '10',
            'sick_leave_per_year' => '10',
            'mobile' => '123456789',
        ];

        Employee::updateOrCreate(['id'=>2],$employee_data);

        $modules = User::modulePermissionArray();
        $module_settings = [];
        foreach ($modules as $key => $value) {
            $module_settings[$key] = 1;
        }

        $system_data=
        [
            ['id'=>1,'key' => 'sender_email', 'value' => 'admin@gmail.com', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>2,'key' => 'time_format', 'value' => 24, 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>3,'key' => 'timezone', 'value' => 'Asia/Qatar', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>4,'key' => 'language', 'value' => 'en', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>5,'key' => 'logo', 'value' => 'sharifshalaby.png', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>6,'key' => 'site_title', 'value' => 'sherifsalaby.tech', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>7,'key' => 'system_type', 'value' => 'noon', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>8,'key' => 'tutorial_guide_url', 'value' => 'https://noon.sherifshalaby.tech', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>9,'key' => 'show_the_window_printing_prompt', 'value' => '1', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>10,'key' => 'currency', 'value' => "119", 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>11,'key' => 'numbers_length_after_dot', 'value' => '2', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>12,'key' => 'module_settings', 'value' => json_encode($module_settings), 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>13,'key' => 'dollar_exchange', 'value' => '132', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>14,'key' => 'watsapp_numbers', 'value' => '123456789', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>15,'key' => 'tax', 'value' => '33', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id'=>16,'key' => 'default_payment_type', 'value' => 'cash', 'created_by' => 1, 'date_and_time' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ];
        foreach ($system_data as $item) {
            System::updateOrCreate(['id' => $item['id']],$item);
        }
        CustomerType::updateOrCreate(['id'=>1],[
            'id'=>1,
            'name' => 'Walk in',
            'created_by' => 1,
        ]);

        Customer::updateOrCreate(['id'=>1],[
            'id'=>1,
            'name' => 'Walk-in-customer',
            'customer_type_id' => 1,
            'phone' => '12345678',
            'address' => '',
            'email' => null,
            'added_balance'=>0,
            'deposit_balance'=>0,
            'created_by' => 1,
        ]);


        $store = Store::updateOrCreate(['id'=>1],[
            'id'=>1,
            'name' => 'Default Store',
            'location' => '',
            'phone_number' => '',
            'email' => '',
            'manager_name' => 'superadmin',
            'manager_mobile_number' => '',
            'details' => '',
            'created_by' => 1
        ]);
        JobType::insert(
            [
                ['title' => 'Cashier', 'date_of_creation' => Carbon::now(), 'created_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['title' => 'Deliveryman', 'date_of_creation' => Carbon::now(), 'created_by' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            ]
        );


        //call the permission and currencies seeder
        $this->call([
            PermissionTableSeeder::class,
            CurrenciesTableSeeder::class,
            CategorySeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
