<?php

namespace Tests\Feature\Admin\Roles;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetRolesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->role1 = Role::create(['name' => 'foo']);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanGetRoles()
    {
        $this->actingAsAdmin()->get(route('v1.roles.index'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'name' => $this->role1->name
                    ]
                ]
            ]);
    }

    public function testAdminCanGetSingleRole()
    {
        $this->actingAsAdmin()->get(route('v1.roles.index', [
            'role_id' => $this->role1->id
        ]))
            ->assertOk()
            ->assertJson([

                'name' => $this->role1->name,

            ]);
    }
}
