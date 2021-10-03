<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->actingAsRandomUser([
            'email_verified_at' => now()
        ]);
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
