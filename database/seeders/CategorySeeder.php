<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Agriculture',
                'description' => 'Farming, livestock, agribusiness, and agricultural technology opportunities.',
                'icon' => 'tractor',
                'is_active' => true,
            ],
            [
                'name' => 'Construction',
                'description' => 'Building, infrastructure, engineering, and construction management roles.',
                'icon' => 'hammer',
                'is_active' => true,
            ],
            [
                'name' => 'Logistics',
                'description' => 'Transportation, warehousing, supply chain, and distribution positions.',
                'icon' => 'truck',
                'is_active' => true,
            ],
            [
                'name' => 'Hospitality',
                'description' => 'Hotels, restaurants, tourism, and customer service opportunities.',
                'icon' => 'utensils-crossed',
                'is_active' => true,
            ],
            [
                'name' => 'Healthcare',
                'description' => 'Medical, nursing, healthcare administration, and allied health professions.',
                'icon' => 'heart-pulse',
                'is_active' => true,
            ],
            [
                'name' => 'Education',
                'description' => 'Teaching, training, educational administration, and academic roles.',
                'icon' => 'graduation-cap',
                'is_active' => true,
            ],
            [
                'name' => 'Technology',
                'description' => 'Software development, IT support, digital marketing, and tech roles.',
                'icon' => 'laptop',
                'is_active' => true,
            ],
            [
                'name' => 'Finance',
                'description' => 'Banking, accounting, financial services, and investment opportunities.',
                'icon' => 'wallet',
                'is_active' => true,
            ],
            [
                'name' => 'Manufacturing',
                'description' => 'Production, quality control, industrial engineering, and manufacturing roles.',
                'icon' => 'factory',
                'is_active' => true,
            ],
            [
                'name' => 'Retail',
                'description' => 'Sales, customer service, retail management, and merchandising positions.',
                'icon' => 'shopping-cart',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category
            );
        }
    }
}
