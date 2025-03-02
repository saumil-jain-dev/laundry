<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = ['super_admin', 'customer', 'vendor', 'delivery_boy'];

        $timestamp = now();

        $data = array_map(fn($role) => [
            'name' => $role,
            'status' => 1,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ], $roles);

        DB::table('roles')->insert($data);
    }
}
