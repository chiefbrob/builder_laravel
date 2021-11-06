<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminGetUsersControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminGetUsers()
    {
        $this->actingAsAdmin();

        $this->get(route('admin.users'))->assertOk()->assertJson([
            'data' => [
                [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ]
            ],
            'current_page' => 1,
            'last_page' => 1,
            'from' => 1,
            'to' => 1,
            'total' => 1,
            'path' => "/admin/users"
        ])->assertJsonCount(1, 'data');
    }
}
