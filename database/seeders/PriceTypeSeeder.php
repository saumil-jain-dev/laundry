<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $priceTypes = [
            ['name' => 'Price Per Kilogram', 'slug' => 'price-per-kilogram'],
            ['name' => 'Price Per Piece', 'slug' => 'price-per-piece']
        ];

        $timestamp = now();

        DB::table('price_types')->insert(array_map(fn($priceType) => [
            'name' => $priceType['name'],
            'slug' => $priceType['slug'],
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ], $priceTypes));
    }
}
