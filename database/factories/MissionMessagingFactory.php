<?php

namespace Database\Factories;

use App\Models\Mission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MissionMessaging>
 */
class MissionMessagingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mission_id' => Mission::factory(),
            'mission_user_id' => User::factory(),
            'user_id' => User::factory(),
            'status' => 'open',
        ];
    }
}
