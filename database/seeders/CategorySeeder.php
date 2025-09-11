<?php

namespace Database\Seeders;

use App\Enums\CategoryEnum;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (array_column(CategoryEnum::cases(), 'value') as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
