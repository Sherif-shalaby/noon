<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{


    public function run()
    {
        $clothes =
        Category::create(['name' => 'ملابس', 'cover' => 'ملابس.jpg', 'status' => true, 'parent_id' => null]);
        Category::create(['name' => 'Women\'s T-Shirts', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Men\'s T-Shirts', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Dresses', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Novelty socks', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Women\'s sunglasses', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        Category::create(['name' => 'Men\'s sunglasses', 'cover' => 'clothes.jpg', 'status' => true, 'parent_id' => $clothes->id]);
        $electronics =
        Category::create(['name' => 'الكترونيات', 'cover' => 'الكترونيات.jpg', 'status' => true]);
        Category::create(['name' => 'smart-tv', 'cover' => 'smart-tv.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'labtop', 'cover' => 'labtop.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'Headphone', 'cover' => 'Headphone.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'smart-phone', 'cover' => 'smart-phone.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'camira', 'cover' => 'camira.jpg', 'status' => true, 'parent_id' => $electronics->id]);
        Category::create(['name' => 'playstation-5', 'cover' => 'playstation-5.jpg', 'status' => true, 'parent_id' => $electronics->id]);
    }

}
