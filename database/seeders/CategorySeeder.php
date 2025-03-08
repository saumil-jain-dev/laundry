<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $timestamp = now();

        $categories = [
            'Men' => ['T-shirt', 'Shirt', 'Jeans', 'Short'],
            'Women' => ['T-shirt', 'Shirt', 'Jacket'],
            'Children' => ['T-shirt', 'Shirt', 'Jeans', 'Bath Robe'],
        ];

        foreach ($categories as $mainCategory => $subCategories) {
            // Insert main category
            $mainCategoryId = DB::table('categories')->insertGetId([
                'title' => $mainCategory,
                'slug' => Str::slug($mainCategory),
                'parent' => null,
                'status' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);

            // Insert subcategories
            foreach ($subCategories as $subCategory) {
                DB::table('categories')->insert([
                    'title' => $subCategory,
                    'slug' => Str::slug($subCategory),
                    'parent' => $mainCategoryId,
                    'status' => 1,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ]);
            }
        }
    }
}
