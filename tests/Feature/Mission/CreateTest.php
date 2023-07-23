<?php

namespace Tests\Feature\Mission;

use App\Models\Mission;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

it('has a create mission page', function () {
    actingAs(User::factory()->create([
        'role' => 'client',
    ]));

    $this->get(route('mission.create'))->assertOk();
});

it('can store a remote mission', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);

    actingAs($user)
        ->post(
            uri: route('mission.store'),
            data: [
                'user_id' => $user->id,
                'title' => $title = fake()->sentence,
                'description' => $description = fake()->text,
                'remuneration' => $remuneration = fake()->randomNumber(5, false),
                'remote' => true,
            ]
        )->assertRedirectToRoute('mission.show', ['id' => 1]);

    assertDatabaseCount('missions', 1);

    $mission = Mission::first();

    expect($mission->user_id)->toBe($user->id);
    expect($mission->title)->toBe($title);
    expect($mission->description)->toBe($description);
    expect($mission->remuneration)->toBe(strval($remuneration));
    expect($mission->remote)->toBe(true);
});

it('can store a local mission', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);

    actingAs($user)
        ->post(
            uri: route('mission.store'),
            data: [
                'user_id' => $user->id,
                'title' => $title = fake()->sentence,
                'description' => $description = fake()->text,
                'remuneration' => $remuneration = fake()->randomNumber(5, false),
                'remote' => false,
                'postalCode' => $postalcode = fake()->regexify('\d{5}'),
                'city' => $city = fake()->city,
            ]
        )->assertRedirectToRoute('mission.show', ['id' => 2]);

    assertDatabaseCount('missions', 1);

    $mission = Mission::first();

    expect($mission->user_id)->toBe($user->id);
    expect($mission->title)->toBe($title);
    expect($mission->description)->toBe($description);
    expect($mission->remuneration)->toBe(strval($remuneration));
    expect($mission->remote)->toBe(false);
    expect($mission->postalcode)->toBe($postalcode);
    expect($mission->city)->toBe($city);
});
