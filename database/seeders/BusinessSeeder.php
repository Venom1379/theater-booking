<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use App\Models\Business;


class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = Category::pluck('id')->toArray();
        $cities = City::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        $logos = [
            'https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg',
            'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg',
            'https://upload.wikimedia.org/wikipedia/commons/4/44/McDonalds_logo.svg',
            'https://upload.wikimedia.org/wikipedia/commons/0/0e/Apple_logo_black.svg',
            'https://upload.wikimedia.org/wikipedia/commons/4/41/Amazon_PNG20.png',
            'https://upload.wikimedia.org/wikipedia/commons/1/1b/Coca-Cola_logo.svg',
            'https://upload.wikimedia.org/wikipedia/commons/f/fa/Starbucks_Corporation_Logo_2011.svg',
            'https://upload.wikimedia.org/wikipedia/commons/4/4e/Facebook_Logo_2023.png',
            'https://upload.wikimedia.org/wikipedia/commons/a/ab/Adidas_Logo.svg',
            'https://upload.wikimedia.org/wikipedia/commons/3/3e/Twitter_Logo_Blue.svg'
        ];

        for ($i = 1; $i <= 50; $i++) {
            Business::create([
                'user_id' => $users[array_rand($users)],
                'name' => "Business $i",
                'slug' => Str::slug("Business $i"),
                'description' => "Description for Business $i.",
                'category_id' => $categories[array_rand($categories)],
                'sub_category_id' => $categories[array_rand($categories)],
                'country_id' => 1, // Assuming USA has ID 1 in the countries table
                'state_id' => rand(1, 8), // Assuming states exist in the states table
                'city_id' => $cities[array_rand($cities)],
                'address' => "123 Main St, " . City::find($cities[array_rand($cities)])->name,
                'phone' => '+1 ' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999),
                'phone_2' => '+1 ' . rand(100, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999),
                'email' => "business$i@example.com",
                'website' => "https://www.business$i.com",
                'logo' => $logos[array_rand($logos)],
                'rating' => rand(30, 50) / 10, // Random rating between 3.0 and 5.0
                'status' => array_rand(['pending' => 'pending', 'approved' => 'approved', 'rejected' => 'rejected'])
            ]);
        }
    }
}
