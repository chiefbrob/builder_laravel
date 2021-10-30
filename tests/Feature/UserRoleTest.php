<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanHaveRole()
    {
        $role = Role::create([
            'name' => 'driver',
            'description' => 'Can Drive'
        ]);

        $user = User::factory()->create();

        $this->assertEquals(false, $user->hasRole($role));

        $this->assertEquals([], $user->rolesList);

        $this->assertEquals(true, $user->assignRole($role));

        $this->assertEquals(true, $user->hasRole($role));

        $role2 = Role::create([
            'name' => 'rider',
            'description' => 'Can Ride'
        ]);

        

        $this->assertEquals(['driver'], $user->rolesList);

        $this->assertEquals(true, $user->assignRole($role2));

        $this->assertEquals(['driver', 'rider'], $user->rolesList);

        $this->assertEquals(true, $user->removeRole($role));

        $this->assertEquals(false, $user->hasRole($role));

        $this->assertEquals(['rider'], $user->rolesList);
    }
}
