<?php

namespace Tests\Feature\Team;

use App\Models\Team;
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
}
