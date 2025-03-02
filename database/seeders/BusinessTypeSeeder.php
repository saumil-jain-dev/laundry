<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $businessTypes = [
            ['name' => 'DC', 'slug' => 'dc'],
            ['name' => 'Laundry', 'slug' => 'laundry']
        ];

        $timestamp = now();

        DB::table('business_types')->insert(array_map(fn($business) => [
            'name' => $business['name'],
            'slug' => $business['slug'],
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ], $businessTypes));
    }
}
