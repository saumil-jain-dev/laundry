<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
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
