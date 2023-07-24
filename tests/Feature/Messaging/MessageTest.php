<?php

namespace Tests\Feature\Messaging;

use App\Models\Message;
use App\Models\Mission;
use App\Models\MissionMessaging;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

it('create a new message', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
        'title' => fake()->sentence,
        'description' => fake()->text,
        'remuneration' => fake()->randomNumber(5, false),
        'remote' => true,
    ]);
    $messaging = MissionMessaging::factory()->create([
        'mission_id' => $mission->id,
        'mission_user_id' => $user->id,
        'user_id' => User::factory()->create([
            'role' => 'freelance',
        ]),
        'status' => 'open',
    ]);

    actingAs($user)
        ->post(
            uri: route('messaging.create', ['id' => $messaging->id]),
            data: [
                'message' => 'test',
            ]
        );

    assertDatabaseCount('messages', 1);

    $message = Message::first();

    expect($message->user_id)->toBe($user->id);
    expect($message->mission_messaging_id)->toBe($mission->id);
    expect($message->message)->toBe('test');
});
