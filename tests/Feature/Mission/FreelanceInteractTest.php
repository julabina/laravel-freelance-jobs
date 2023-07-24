<?php

namespace Tests\Feature\Mission;

use App\Models\Message;
use App\Models\Mission;
use App\Models\MissionLike;
use App\Models\MissionMessaging;
use App\Models\MissionProposal;
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
        );

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
        );

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
        );

    assertDatabaseCount('mission_likes', 1);

    $like = MissionLike::first();

    expect($like->user_id)->toBe($user->id);
    expect($like->mission_id)->toBe($mission->id);
});

it('remove proposal', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);
    $userFreelance = User::factory()->create([
        'role' => 'freelance',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
    ]);
    $proposal = MissionProposal::factory()->create([
        'mission_id' => $mission->id,
        'user_id' => $userFreelance->id,
        'message' => fake()->text,
        'status' => 'negotiated',
    ]);
    $messaging = MissionMessaging::factory()->create([
        'mission_id' => $mission->id,
        'mission_user_id' => $user->id,
        'user_id' => $userFreelance->id,
        'status' => 'open',
    ]);
    $messages = Message::factory(3)->create([
        'mission_messaging_id' => $messaging->id,
        'user_id' => $user->id,
        'message' => fake()->sentence(6),
    ]);

    actingAs($userFreelance)
        ->delete(
            uri: route('mission.remove', ['id' => $mission->id]),
        );

    assertDatabaseCount('mission_messagings', 0);
    assertDatabaseCount('mission_proposals', 0);
    assertDatabaseCount('messages', 0);
});
