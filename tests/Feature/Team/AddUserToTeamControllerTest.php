<?php

namespace Tests\Feature\Team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddUserToTeamControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddUserToTeam()
    {
        Team::factory()->create();
        Team::factory()->create();
        User::factory()->create();
        User::factory()->create();
        User::factory()->create();

        $team = Team::factory()->create();
        $user = User::factory()->create();

        $this->actingAsAdmin();

        $this->post(route('v1.teams.adduser', $team->id), ['user_id' => $user->id])
            ->assertOk();

        $this->assertCount(1, $team->teamUsers);

        $this->assertDatabaseHas('team_users', [
            'user_id' => $user->id,
            'team_id' => $team->id
        ]);
    }
}
