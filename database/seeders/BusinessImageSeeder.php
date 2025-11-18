<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Str;

class BusinessImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business_images')->insert([
            [
                'business_id' => 1,
                'image_url' => 'https://example.com/images/plumbing.jpg',
                'alt_text' => 'Plumbing Services',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => 2,
                'image_url' => 'https://example.com/images/spa.jpg',
                'alt_text' => 'Green Leaf Spa',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
