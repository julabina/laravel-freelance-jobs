<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

it('has a welcome page', function () {
    $this->get('/')->assertOk();
});
