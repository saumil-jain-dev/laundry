<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CmsPage::create([
            'slug' => 'privacy-policy',
            'title' => 'Privacy Policy',
            'content' => 'This Privacy Policy explains how we collect, use, and protect your personal data when using our laundry services.',
            'status' => true,
        ]);
    }
}
