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
        Product::create(['name' => 'برتقال','category_id'=>1,'image' => '1.jpg','unit_id'=>1]);
        Product::create(['name' => 'مانجا','category_id'=>1,'image' => '2.jpg','unit_id'=>1]);
        Product::create(['name' => 'شاورما','category_id'=>2,'image' => '3.jpg','unit_id'=>2]);
        Product::create(['name' => 'كباب','category_id'=>2,'image' => '4.jpg','unit_id'=>2]);
        Product::create(['name' => 'فليه','category_id'=>3,'image' => '5.jpg','unit_id'=>3]);
        Product::create(['name' => 'جمبري','category_id'=>3,'image' => '6.jpg','unit_id'=>3]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
