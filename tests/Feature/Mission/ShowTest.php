<?php

namespace Tests\Feature\Mission;

use App\Models\Mission;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('has a mission page', function () {
    $mission = Mission::factory()->create();

    actingAs(User::factory()->create());

    $this->get(route('mission.show', ['id' => $mission->id]))->assertOk();
});
