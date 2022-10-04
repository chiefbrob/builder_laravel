<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateRoleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRoles()
    {
        $user = User::factory()->create(['email' => 'brianobare@gmail.com']);
        $this->actingAS($user);
        $this->assertEquals(true, $user->isAdmin());
        $this->assertDatabaseHas('roles', [
            'name' => 'admin',
        ]);

        $this->post(route('roles.create', [
            'name' => 'test',
            'description' => 'Sample testing role',
        ]))->assertOk();

        $this->assertDatabaseHas('roles', [
            'name' => 'test',
        ]);
    }
}
