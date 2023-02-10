<?php

namespace Tests\Feature\Team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoveUserFromTeamControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRemoveUserToTeam()
    {
        $this->actingAsAdmin();

        Team::factory()->create();
        Team::factory()->create();
        User::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $this->user->id
        ]);
        $user = User::factory()->create();

        $team->addUser($user);
        $team->addUser($user1);
        $team->addUser($user2);

        $this->assertCount(3, $team->teamUsers);

        $this->assertDatabaseHas('team_users', [
            'user_id' => $user1->id,
            'team_id' => $team->id
        ]);

        $this->assertDatabaseHas('team_users', [
            'user_id' => $user->id,
            'team_id' => $team->id
        ]);



        $this->delete(route('v1.teams.removeuser', $team->id), ['user_id' => $user->id])
            ->assertOk();

        $team->refresh();

        $this->assertCount(2, $team->teamUsers);

        $this->assertDatabaseMissing('team_users', [
            'user_id' => $user->id,
            'team_id' => $team->id
        ]);
    }
}
