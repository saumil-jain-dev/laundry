<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,           // If roles are in a separate seeder
            BusinessTypeSeeder::class,   // Business types
            PriceTypeSeeder::class,      // Price types
            CategorySeeder::class,       //Category seeder
            ServiceSeeder::class,
            OfferSeeder::class,
            FaqSeeder::class,
        ]);

    }
}
