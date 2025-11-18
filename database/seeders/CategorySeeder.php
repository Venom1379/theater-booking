<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Import DB
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define categories with their respective subcategories
        $categories = [
            'Restaurants' => ['Fine Dining', 'Fast Food', 'Cafés & Coffee Shops', 'Buffets', 'Family Restaurants'],
            'Plumbers' => ['Residential Plumbing', 'Commercial Plumbing', 'Pipe Repair & Installation', 'Water Heater Services', 'Emergency Plumbing'],
            'Electricians' => ['Residential Electrical Services', 'Commercial Electrical Services', 'Lighting Installation', 'Wiring & Rewiring', 'Solar Panel Installation'],
            'HVAC Contractors' => ['AC Installation & Repair', 'Heating System Maintenance', 'Ventilation Services', 'Duct Cleaning', 'Energy Efficiency Consultation'],
            'Real Estate Agents' => ['Residential Real Estate', 'Commercial Real Estate', 'Rental Property Agents', 'Real Estate Consultants', 'Luxury Property Agents'],
            'Hotels' => ['Luxury Hotels', 'Budget Hotels', 'Boutique Hotels', 'Resorts', 'Business Hotels'],
            'Gyms' => ['CrossFit Gyms', 'Yoga & Pilates Studios', 'Strength Training Gyms', 'Personal Training Studios', 'Martial Arts & Boxing Gyms'],
            'Hospitals' => ['General Hospitals', 'Specialty Hospitals', 'Children’s Hospitals', 'Maternity Hospitals', 'Rehabilitation Centers'],
            'Dentists' => ['General Dentistry', 'Orthodontics', 'Cosmetic Dentistry', 'Pediatric Dentistry', 'Oral Surgery'],
            'Lawyers' => ['Criminal Lawyers', 'Family Lawyers', 'Corporate Lawyers', 'Personal Injury Lawyers', 'Immigration Lawyers'],
            'Automobile Repair' => ['Engine Repair', 'Transmission Services', 'Brake Repair', 'Tire & Wheel Services', 'Auto Body Repair'],
            'Cleaning Services' => ['Residential Cleaning', 'Commercial Cleaning', 'Carpet & Upholstery Cleaning', 'Window Cleaning', 'Deep Cleaning Services'],
            'Beauty Salons' => ['Hair Salons', 'Nail Salons', 'Skincare & Facial Treatment', 'Bridal Makeup Salons', 'Men’s Grooming'],
            'Spas' => ['Wellness Spas', 'Medical Spas', 'Thai Massage Spas', 'Ayurveda Spas', 'Luxury Spas'],
            'Daycares' => ['Infant Daycare', 'Toddler Daycare', 'Preschool Programs', 'After-School Care', 'Special Needs Daycare'],
        ];

        // Insert subcategories into the database
        foreach ($categories as $categoryName => $subcategories) {
            // Get the category ID
            $category = DB::table('categories')->where('name', $categoryName)->first();

            if ($category) {
                foreach ($subcategories as $subCategoryName) {
                    DB::table('sub_categories')->insert([
                        'name' => $subCategoryName,
                        'slug' => Str::slug($subCategoryName),
                        'category_id' => $category->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
