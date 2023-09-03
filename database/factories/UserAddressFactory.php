<?php

namespace Database\Factories;

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
          'address' => fake('en_PH')->streetAddress(),
          'street' => fake('en_PH')->streetName(),
          'city' => fake('en_PH')->municipality(),
          'state' => fake('en_PH')->province(),
          'zip_code' => fake()->randomNumber(4),
          'phone_number' => fake('en_PH')->phoneNumber()
        ];
    }
}
