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
    public function testAdminCreateRoles()
    {
        $user = User::factory()->create(['email' => 'foobar@example.com']);
        $this->actingAsAdmin();
        $this->assertEquals(false, $user->isAdmin());
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
