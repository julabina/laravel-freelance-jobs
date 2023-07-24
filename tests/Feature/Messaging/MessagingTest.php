<?php

namespace Tests\Feature\Messaging;

use App\Models\Mission;
use App\Models\MissionMessaging;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('messaging list page exist', function () {
    actingAs(User::factory()->create());

    $this->get(route('messaging.list'))->assertOk();
});

it('messaging page exist', function () {
    $user = User::factory()->create([
        'role' => 'client',
    ]);
    $mission = Mission::factory()->create([
        'user_id' => $user->id,
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

    actingAs($user);

    $this->get(route('messaging.show', ['id' => $messaging->id]))->assertOk();
});
