<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Str; 

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'business_id' => 1, // Assuming John's Plumbing Services ID is 1
                'user_id' => 3, // Assuming 'Customer User' ID is 3
                'rating' => 5.0,
                'comment' => 'Excellent service, highly recommended!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => 2, // Assuming Green Leaf Spa ID is 2
                'user_id' => 3,
                'rating' => 4.5,
                'comment' => 'Very relaxing experience, will come again!',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
