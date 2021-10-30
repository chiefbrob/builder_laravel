<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoveRoleControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteUseRole()
    {
        $this->withoutExceptionHandling();
        $this->actingAsAdmin();
        $r = Role::create(['name' => 'foo']);
        $u = User::factory()->create();
        $u->assignRole($r);
        $ur = $u->roles->where('role_id', $r->id)->first();
        $this->assertDatabaseHas('user_roles', [
            'user_id' => $u->id,
            'role_id' => $r->id
        ]);
        $this->delete(
            route('user-role.delete', ['user_role_id' => $ur->id])
        )->assertOk();
        $this->assertDatabaseMissing('user_roles', [
            'user_id' => $u->id,
            'role_id' => $r->id
        ]);
    }
}
