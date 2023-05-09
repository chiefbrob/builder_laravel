<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GraphQlWebControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testGuestUser(): void
    {
        $this->get(route('v1.graphql-web'))
            ->assertRedirect('/login');
    }

    public function testRandomUser(): void
    {
        $this->actingAsRandomUser()->get(route('v1.graphql-web'))
            ->assertRedirect('/home');

    }

    public function testAdminAccess(): void
    {
        $this->actingAsAdmin()->get(route('v1.graphql-web'))
            ->assertOk()
            ->assertViewIs('vendor.graphiql.index');

    }
}
