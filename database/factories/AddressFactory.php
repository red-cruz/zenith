<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' => User::all('id')->random()
            'street' => fake('en_PH')->barangay(),
            'city' => fake('en_PH')->municipality(),
            'state' => fake('en_PH')->province(),
            'zip_code' => fake()->randomNumber(4)
        ];
    }
}
