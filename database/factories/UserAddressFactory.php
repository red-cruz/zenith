<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'street' => fake('en_PH')->streetAddress(),
          'city' => fake('en_PH')->municipality(),
          'state' => fake('en_PH')->province(),
          'zip_code' => fake()->randomNumber(4)
        ];
    }
}
