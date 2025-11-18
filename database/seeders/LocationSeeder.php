<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks to avoid constraint issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('countries')->truncate();
        DB::table('states')->truncate();
        DB::table('cities')->truncate();
        // DB::table('statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // List of Countries
        $countries = [
            ['name' => 'United States', 'code' => 'USA'],
            ['name' => 'Canada', 'code' => 'CAN'],
            ['name' => 'United Kingdom', 'code' => 'UK'],
            ['name' => 'Australia', 'code' => 'AUS'],
            ['name' => 'India', 'code' => 'IND']
        ];

        $countryIds = [];

        // Insert Countries and Store IDs
        foreach ($countries as $country) {
            $countryIds[$country['code']] = DB::table('countries')->insertGetId([
                'name' => $country['name'],
                'code' => $country['code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // List of States per Country
        $states = [
            ['name' => 'California', 'country_code' => 'USA'],
            ['name' => 'Texas', 'country_code' => 'USA'],
            ['name' => 'Ontario', 'country_code' => 'CAN'],
            ['name' => 'British Columbia', 'country_code' => 'CAN'],
            ['name' => 'England', 'country_code' => 'UK'],
            ['name' => 'New South Wales', 'country_code' => 'AUS'],
            ['name' => 'Victoria', 'country_code' => 'AUS'],
            ['name' => 'Maharashtra', 'country_code' => 'IND'],
            ['name' => 'Karnataka', 'country_code' => 'IND'],
        ];

        $stateIds = [];

        // Insert States and Store IDs
        foreach ($states as $state) {
            $stateIds[$state['name']] = DB::table('states')->insertGetId([
                'name' => $state['name'],
                'country_id' => $countryIds[$state['country_code']],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Compulsory Cities List and their corresponding states
        $cities = [
            'New York' => 'New York', 'Los Angeles' => 'California', 'Chicago' => 'Illinois',
            'Houston' => 'Texas', 'Phoenix' => 'Arizona', 'Philadelphia' => 'Pennsylvania',
            'San Antonio' => 'Texas', 'San Diego' => 'California', 'Dallas' => 'Texas',
            'San Jose' => 'California', 'Austin' => 'Texas', 'Jacksonville' => 'Florida',
            'Fort Worth' => 'Texas', 'Columbus' => 'Ohio', 'Charlotte' => 'North Carolina',
            'Indianapolis' => 'Indiana', 'San Francisco' => 'California', 'Seattle' => 'Washington',
            'Denver' => 'Colorado', 'Washington' => 'Washington D.C.', 'Boston' => 'Massachusetts',
            'El Paso' => 'Texas', 'Nashville' => 'Tennessee', 'Detroit' => 'Michigan',
            'Oklahoma City' => 'Oklahoma', 'Atlanta' => 'Georgia', 'Miami' => 'Florida',
            'Orlando' => 'Florida', 'Tampa' => 'Florida', 'Las Vegas' => 'Nevada',
            'Minneapolis' => 'Minnesota', 'Sacramento' => 'California', 'Portland' => 'Oregon',
            'Kansas City' => 'Missouri', 'Raleigh' => 'North Carolina'
        ];

        // Insert Cities
        foreach ($cities as $city => $stateName) {
            $stateId = $stateIds[$stateName] ?? null;

            if ($stateId) {
                DB::table('cities')->insert([
                    'name' => $city,
                    'slug' => Str::slug($city),
                    'state_id' => $stateId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        
    }
}
