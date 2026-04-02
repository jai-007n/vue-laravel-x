<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    //
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    protected function authenticate()
    {
        $this->user = \App\Models\User::factory()->create();
        $this->actingAs($this->user);

        return $this->user;
    }
}
