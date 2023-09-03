<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(7)
          ->has(
              Variation::factory()->count(2)
                ->has(
                    VariationOption::factory()->count(3)
                )
          )
          ->create();
    }
}
