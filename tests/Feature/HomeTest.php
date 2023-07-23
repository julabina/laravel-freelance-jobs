<?php

namespace Tests\Feature;

use App\Models\User;
use function Pest\Laravel\actingAs;

//use Illuminate\Foundation\Testing\RefreshDatabase;

it('has a home page', function () {
    actingAs(User::factory()->create());

    $this->get('/')->assertOk();
});
