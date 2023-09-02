<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ParentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Category::factory(5)
        ->create(['category_id' => ParentCategory::all('id')->random()]);
    }
}
