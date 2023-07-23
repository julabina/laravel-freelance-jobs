<?php

namespace Tests\Feature\Mission;

use App\Models\Mission;
use App\Models\MissionLike;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

it('unlike a liked mission', function () {

    $user = User::factory()->create([
        'role' => 'freelance',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
    ]);
    MissionLike::factory()->create([
        'user_id' => $user->id,
        'mission_id' => $mission->id,
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.like', ['id' => $mission->id]),
        )->assertRedirectToRoute('mission.show', ['id' => $mission->id]);

    assertDatabaseCount('mission_likes', 0);
});

it('like a unliked mission', function () {
    $user = User::factory()->create([
        'role' => 'freelance',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.like', ['id' => $mission->id]),
        )->assertRedirectToRoute('mission.show', ['id' => $mission->id]);

    assertDatabaseCount('mission_likes', 1);

    $like = MissionLike::first();

    expect($like->user_id)->toBe($user->id);
    expect($like->mission_id)->toBe($mission->id);
});

it('like a unliked mission from mission card', function () {
    $user = User::factory()->create([
        'role' => 'freelance',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.like', ['id' => $mission->id]),
            data: [
                'card' => true,
            ]
        )->assertRedirectToRoute('mission.list');

    assertDatabaseCount('mission_likes', 1);

    $like = MissionLike::first();

    expect($like->user_id)->toBe($user->id);
    expect($like->mission_id)->toBe($mission->id);
});
