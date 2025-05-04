<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Faq::insert([
            [
                'question' => 'What services does your laundry offer?',
                'answer' => 'We offer washing, ironing, dry cleaning, and express delivery.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'How long does laundry service take?',
                'answer' => 'Regular service takes 24-48 hours, express service is done in 6-12 hours.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Do you provide home pickup and drop?',
                'answer' => 'Yes, we offer free pickup and drop for orders above a minimum value.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'How can I pay for my order?',
                'answer' => 'We accept cash on delivery and online payments.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Are your cleaning products safe?',
                'answer' => 'Yes, we use eco-friendly and fabric-safe detergents.',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
