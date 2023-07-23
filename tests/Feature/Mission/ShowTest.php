<?php

namespace Tests\Feature\Mission;

use App\Models\Mission;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('has a mission page', function () {
    $mission = Mission::factory()->create();

    actingAs(User::factory()->create())->get(route('mission.show', ['id' => $mission->id]))->assertOk();
});

it('has a list missions page', function () {
    actingAs(User::factory()->create([
        'role' => 'freelance',
    ]));

    $this->get(route('mission.list'))->assertOk();
});
