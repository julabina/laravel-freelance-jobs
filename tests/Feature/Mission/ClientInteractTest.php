<?php

namespace Tests\Feature\Mission;

use App\Models\Mission;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('update the mission status to closed', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
        'status' => 'open',
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.updateStatus', ['id' => $mission->id]),
        );

    $mission = Mission::first();

    expect($mission->status)->toBe('closed');
});

it('update the mission status to open', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
        'status' => 'closed',
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.updateStatus', ['id' => $mission->id]),
        );

    $mission = Mission::first();

    expect($mission->status)->toBe('open');
});

it('update the mission status to granted', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
        'status' => 'open',
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.updateGrantedStatus', ['id' => $mission->id]),
        );

    $mission = Mission::first();

    expect($mission->status)->toBe('granted');
});

it('update the granted mission status to open', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
        'status' => 'granted',
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.updateGrantedStatus', ['id' => $mission->id]),
        );

    $mission = Mission::first();

    expect($mission->status)->toBe('open');
});
