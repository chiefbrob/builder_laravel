<?php

namespace Tests\Feature\Team;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTeamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanUpdateTeam()
    {
        $this->actingAsAdmin();

        $team = Team::factory()->create(['user_id' => $this->user->id]);

        $newTeam = [
            'name' => 'Foo Team',
            'email' => 'foo@foo.com',
            'description' => 'just foo',
        ];

        $this->post(route('v1.teams.update', $team->id), $newTeam)
            ->assertOk()->assertJson($newTeam);

        $this->assertDatabaseHas('teams', $newTeam);
    }
}
