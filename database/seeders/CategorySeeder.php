<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Action',
            'Aventure',
            'Comédie',
            'Drame',
            'Thriller',
            'Science-fiction',
            'Fantasy',
            'Horreur',
            'Romance',
            'Animation'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'cover' => 'category-covers/default.jpg' // Vous devrez ajouter une image par défaut
            ]);
        }
    }
}
