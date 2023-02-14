<?php

namespace Tests\Feature\Team;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTeamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user0 = User::factory()->create();

        $role = Role::firstOrCreate(['name' => 'manager']);

        $this->actingAsAdmin()->post(route('user-role.create', [
            'user_id' => $this->user0->id,
            'role_id' => $role->id,
        ]))->assertCreated();
    }

    public function testCanUpdateTeam()
    {
        $team = [
            'name' => 'Example Team2',
            'email' => 'team-2@teams.com',
            'description' => 'a FooBar team'
        ];

        $this->actingAs($this->user0)->post(route('v1.teams.create', $team))
            ->assertCreated()->assertJson($team);

        $team = Team::factory()->create(['user_id' => $this->user0->id]);

        $newTeam = [
            'name' => 'Foo Team',
            'email' => 'foo@foo.com',
            'description' => 'just foo',
        ];

        $this->actingAs($this->user0)
            ->put(
                route('v1.teams.update', $team->id),
                $newTeam
            )
            ->assertOk()->assertJson($newTeam);

        $this->assertDatabaseHas('teams', $newTeam);
    }
}
