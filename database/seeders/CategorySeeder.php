<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $labels = [
            'Hotel', 'Business Owner', 'Service Provider', 'Banks',
            'Drugs', 'Army', 'Electricity', 'Inventions',
            'Police', 'Restaurant', 'Filling Station', 'Civil Servants',
            'Building Control', 'Individuals', 'Roads', 'Streets',
        ];

        foreach ($labels as $label) {
            Category::create([
                'label' => $label,
                'slug' => Str::slug($label),
                'image' => '/assets/categories/'.Str::slug($label).'.jpg',
            ]);
        }
    }
}