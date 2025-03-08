<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $services = [
            'Washing',
            'Iron',
            'Dry Clean',
            'Carpet Clean',
            'Shoe Clean',
            'Bed Sheet'
        ];

        $timestamp = now();

        $data = array_map(fn($service) => [
            'name' => $service,
            'slug' => Str::slug($service),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ], $services);

        DB::table('services')->insert($data);
    }
}
