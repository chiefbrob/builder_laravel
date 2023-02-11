<?php

namespace Tests\Feature\Team;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTeamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanCreateTeam()
    {
        $this->actingAsAdmin();

        $team = [
            'name' => 'Example',
            'email' => 'team@teams.com',
            'description' => 'a Foo team'
        ];

        $this->post(route('v1.teams.create', $team))
            ->assertCreated()->assertJson($team);

        $this->assertDatabaseHas('teams', $team);

        $team = Team::where('name', 'Example')->first();

        $this->assertDatabaseHas('team_users', [
            'team_id' => $team->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function testUserCannotCreateTeam()
    {
        $this->actingAsRandomUser();

        $team = [
            'name' => 'Example',
            'email' => 'team@teams.com',
            'description' => 'a Foo team'
        ];

        $this->post(route('v1.teams.create', $team))
            ->assertForbidden();

        $this->assertDatabaseMissing('teams', $team);
    }

    public function testUsersWithManagerRoleCanCreateTeam()
    {
        //$this->actingAsRandomUser();
        $user = User::factory()->create();

        $role = Role::firstOrCreate(['name' => 'manager']);


        $this->actingAsAdmin()->post(route('user-role.create', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]))->assertCreated();


        $team = [
            'name' => 'Example Team1',
            'email' => 'team-1@teams.com',
            'description' => 'a Bar team'
        ];


        $this->actingAs($user)->post(route('v1.teams.create', $team))
            ->assertCreated()->assertJson($team);

        $this->assertDatabaseHas('teams', $team);

    }
}
