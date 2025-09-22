<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'categoryId' => 'cat_001',
                'name' => 'Entrées',
                'imageUrl' => 'https://example.com/images/categories/entrees.jpg'
            ],
            [
                'categoryId' => 'cat_002',
                'name' => 'Plats principaux',
                'imageUrl' => 'https://example.com/images/categories/plats.jpg'
            ],
            [
                'categoryId' => 'cat_003',
                'name' => 'Desserts',
                'imageUrl' => 'https://example.com/images/categories/desserts.jpg'
            ],
            [
                'categoryId' => 'cat_004',
                'name' => 'Boissons',
                'imageUrl' => 'https://example.com/images/categories/boissons.jpg'
            ],
            [
                'categoryId' => 'cat_005',
                'name' => 'Apéritifs',
                'imageUrl' => 'https://example.com/images/categories/aperitifs.jpg'
            ],
            [
                'categoryId' => 'cat_006',
                'name' => 'Végétarien',
                'imageUrl' => 'https://example.com/images/categories/vegetarien.jpg'
            ],
            [
                'categoryId' => 'cat_007',
                'name' => 'Végan',
                'imageUrl' => 'https://example.com/images/categories/vegan.jpg'
            ],
            [
                'categoryId' => 'cat_008',
                'name' => 'Sans gluten',
                'imageUrl' => 'https://example.com/images/categories/sans-gluten.jpg'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
