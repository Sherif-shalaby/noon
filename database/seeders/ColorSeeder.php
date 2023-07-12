<?php

namespace Database\Seeders;

use App\Models\Color;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Color::truncate();
        // color
        $data = [
            [
                'name' => strtolower('red'),
                'slug' => str::slug(strtolower('red')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => strtolower('sayan'),
                'slug' => str::slug(strtolower('sayan')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => strtolower('pink'),
                'slug' => str::slug(strtolower('pink')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => strtolower('green'),
                'slug' => str::slug(strtolower('green')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => strtolower('skyblue'),
                'slug' => str::slug(strtolower('skyblue')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => strtolower('gray'),
                'slug' => str::slug(strtolower('gray')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => strtolower('white'),
                'slug' => str::slug(strtolower('white')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => strtolower('black'),
                'slug' => str::slug(strtolower('black')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => strtolower('yellow'),
                'slug' => str::slug(strtolower('yellow')),
                'created_at' => Carbon::now()->toDateTimeString()
            ],
        ];
        Color::insert($data);
    }
}
