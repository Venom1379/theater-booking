<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Str;



class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix',
            'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose',
            'Austin', 'Jacksonville', 'Fort Worth', 'Columbus', 'Charlotte',
            'Indianapolis', 'San Francisco', 'Seattle', 'Denver', 'Washington',
            'Boston', 'El Paso', 'Nashville', 'Detroit', 'Oklahoma City',
            'Atlanta', 'Miami', 'Orlando', 'Tampa', 'Las Vegas',
            'Minneapolis', 'Sacramento', 'Portland', 'Kansas City', 'Raleigh'
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name' => $city,
                'slug' => Str::slug($city),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
