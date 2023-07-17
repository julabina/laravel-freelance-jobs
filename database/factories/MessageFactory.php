<?php

namespace Database\Factories;

use App\Models\MissionMessaging;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mission_messaging_id' => MissionMessaging::factory(),
            'user_id' => User::factory(),
            'message' => fake()->sentence(7, false),
        ];
    }
}
