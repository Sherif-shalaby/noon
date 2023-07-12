<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{


    public function run()
    {
        $clothes =
        Category::create(['name' => 'ملابس', 'cover' => 'categories/1.jpg', 'status' => true, 'parent_id' => null]);
        Category::create(['name' => 'Women\'s T-Shirts', 'cover' => 'categories/2.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Men\'s T-Shirts', 'cover' => 'categories/3.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Dresses', 'cover' => 'categories/4.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Novelty socks', 'cover' => 'categories/5.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Women\'s sunglasses', 'cover' => 'categories/6.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Men\'s sunglasses', 'cover' => 'categories/7.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        $electronics =
        Category::create(['name' => 'الكترونيات', 'cover' => 'categories/8.jpg', 'status' => true]);
        Category::create(['name' => 'smart-tv', 'cover' => 'categories/9.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'labtop', 'cover' => 'categories/10.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Headphone', 'cover' => 'categories/11.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'smart-phone', 'cover' => 'categories/12.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'camira', 'cover' => 'categories/13.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'playstation-5', 'cover' => 'categories/14.jpg', 'status' => true, 'parent_id' => $electronics->id]);
    }

}
