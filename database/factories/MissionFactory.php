<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mission>
 */
class MissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence,
            'description' => fake()->text,
            'remuneration' => fake()->randomNumber(5, false),
            'proposal_count' => fake()->randomDigit,
            'remote' => fake()->boolean,
            'postalcode' => fake()->regexify('\d{5}'),
            'city' => fake()->city,
        ];
    }
}
