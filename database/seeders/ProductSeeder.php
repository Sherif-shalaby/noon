<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        Product::create(['name' => 'برتقال','category_id'=>1,'image' => '1.jpg']);
        Product::create(['name' => 'مانجا','category_id'=>1,'image' => '2.jpg']);
        Product::create(['name' => 'شاورما','category_id'=>2,'image' => '3.jpg']);
        Product::create(['name' => 'كباب','category_id'=>2,'image' => '4.jpg']);
        Product::create(['name' => 'فليه','category_id'=>3,'image' => '5.jpg']);
        Product::create(['name' => 'جمبري','category_id'=>3,'image' => '6.jpg']);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
