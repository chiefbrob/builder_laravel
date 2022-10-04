<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRoleDaved()
    {
        $role = Role::create(['name' => 'user', 'description' => 'Anyone registered']);
        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => 'user', 'description' => 'Anyone registered']);
    }
}
