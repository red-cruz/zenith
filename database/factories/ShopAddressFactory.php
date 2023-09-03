<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShopAddress>
 */
class ShopAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'shop_id' => Shop::factory(),
          'street' => fake('en_PH')->streetAddress(),
          'city' => fake('en_PH')->municipality(),
          'state' => fake('en_PH')->province(),
          'zip_code' => fake()->randomNumber(4)
        ];
    }
}
