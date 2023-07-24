<?php

namespace Tests\Feature\Mission;

use App\Models\Mission;
use App\Models\MissionMessaging;
use App\Models\MissionProposal;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

it('client pass proposal to negotiated', function () {
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
        'status' => 'waiting',
    ]);

    $response = actingAs($user)
        ->put(
            uri: route('mission.updateProposal', ['id' => $proposal->id]),
            data: [
                'action' => 'negotiated',
            ]
        );

    assertDatabaseCount('mission_messagings', 1);

    $messaging = MissionMessaging::first();

    $response->assertRedirectToRoute('messaging.show', ['id' => $messaging->id]);

    $treatedProposal = MissionProposal::first();

    expect($messaging->mission_id)->toBe($mission->id);
    expect($messaging->mission_user_id)->toBe($user->id);
    expect($messaging->user_id)->toBe($userFreelance->id);
    expect($messaging->status)->toBe('open');
    expect($treatedProposal->status)->toBe('negotiated');
});

it('client refuse proposal', function () {
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
        'status' => 'waiting',
    ]);
    $messaging = MissionMessaging::factory()->create([
        'mission_id' => $mission->id,
        'mission_user_id' => $user->id,
        'user_id' => $userFreelance->id,
        'status' => 'open',
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.updateProposal', ['id' => $proposal->id]),
            data: [
                'action' => 'refuse',
            ]
        );

    $treatedMessaging = MissionMessaging::first();
    $treatedProposal = MissionProposal::first();

    expect($treatedMessaging->status)->toBe('closed');
    expect($treatedProposal->status)->toBe('refused');
});

it('client accept proposal', function () {
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
    $otherMessagings = MissionMessaging::factory(2)->create([
        'mission_id' => $mission->id,
        'mission_user_id' => $user->id,
        'user_id' => User::factory()->create([
            'role' => 'freelance',
        ]),
        'status' => 'open',
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.updateProposal', ['id' => $proposal->id]),
            data: [
                'action' => 'accept',
            ]
        );

    $treatedMessaging = MissionMessaging::where('user_id', $userFreelance->id)->get();
    $treatedOtherMessaging = MissionMessaging::whereNot('user_id', $userFreelance->id)->get();
    $treatedProposal = MissionProposal::first();
    $treatedMission = Mission::first();

    expect($treatedMission->status)->toBe('granted');
    expect($treatedProposal->status)->toBe('accepted');
    expect($treatedMessaging[0]['status'])->toBe('open');
    expect($treatedOtherMessaging[0]['status'])->toBe('closed');
    expect($treatedOtherMessaging[1]['status'])->toBe('closed');
});

it('client cancel proposal', function () {
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
        'status' => 'accepted',
    ]);

    actingAs($user)
        ->put(
            uri: route('mission.updateProposal', ['id' => $proposal->id]),
            data: [
                'action' => 'cancel',
            ]
        );

    $treatedProposal = MissionProposal::first();
    $treatedMission = Mission::first();

    expect($treatedMission->status)->toBe('open');
    expect($treatedProposal->status)->toBe('waiting');
});
