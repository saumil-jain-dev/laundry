<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $offers = [
            ['name' => 'Summer Sale', 'image' => 'images/offer/file_1741483162.jpg', 'status' => 1],
            ['name' => 'New Year Discount', 'image' => 'images/offer/file_1741483163.jpg', 'status' => 1],
            ['name' => 'Festival Bonanza', 'image' => 'images/offer/file_1741483164.jpg', 'status' => 1],
            ['name' => 'Weekend Offer', 'image' => 'images/offer/file_1741483165.jpg', 'status' => 1],
            ['name' => 'First Order Discount', 'image' => 'images/offer/file_1741483166.jpg', 'status' => 1],
        ];

        foreach ($offers as $offer) {
            DB::table('offers')->insert([
                'name' => $offer['name'],
                'slug' => Str::slug($offer['name']),
                'image' => $offer['image'],
                'status' => $offer['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
