<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Shop;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::all('id')->random();
        return [
            'shop_id' => Shop::all('id')->random(),
            'name' => fake('en_PH')->company(),
            'brand' => fake('en_PH')->company(),
            'description' => fake('en_PH')->realText(),
            'quantity' => fake()->randomNumber(),
            'price' => fake()->randomFloat(2, 0, 8),
            'prev_price' => fake()->randomFloat(2, 0, 8),
            'category_id' => $category,
            'subcategory_id' => SubCategory::select('id')->where('id', $category->id)->get()->random()
        ];
    }
}
