<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Str;

class BusinessTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business_tags')->insert([
            [
                'business_id' => 1,
                'tag' => 'emergency plumbing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => 1,
                'tag' => 'drain cleaning',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => 2,
                'tag' => 'spa treatment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => 2,
                'tag' => 'massage therapy',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
