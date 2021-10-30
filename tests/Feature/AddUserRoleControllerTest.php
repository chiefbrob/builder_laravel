<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddUserRoleControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAssignRole()
    {
        $this->actingAsAdmin();
        $user = User::factory()->create(['email' => 'foo1@gmail.com']);
        $role = Role::create(['name' => 'example']);
        
        $this->post(route('user-role.create', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]))->assertCreated()->assertJson([
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('user_roles', [
            'user_id' => $user->id,
            'role_id' => $role->id
        ]);
        
    }
}
