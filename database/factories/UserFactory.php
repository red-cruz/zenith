<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'femamle']);
        $password = fake()->password();
        return [
            'name' => fake('en_PH')->name($gender),
            'gender' => $gender,
            'phone_number' => fake()->numberBetween(100000000, 999999999),
            'birthdate' => fake()->date('Y-m-d', '-18 years'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'plain_pass' => $password,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'remember_token' => Str::random(10),
            'address_id' => Address::factory()->create()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
