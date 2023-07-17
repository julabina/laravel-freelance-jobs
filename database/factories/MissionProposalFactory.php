<?php

namespace Database\Factories;

use App\models\Mission;
use App\models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MissionProposal>
 */
class MissionProposalFactory extends Factory
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
            'user_id' => User::factory(),
            'message' => fake()->text,
            'status' => 'waiting',
        ];
    }
}
