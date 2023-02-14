<?php

namespace Tests\Feature\Team;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddUserToTeamControllerTest extends TestCase
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

        $this->actingAsAdmin();

        $this->actingAs($this->user0)->post(route('v1.teams.adduser', $team->id), ['user_id' => $this->user0->id])
            ->assertOk();

        $this->assertCount(1, $team->teamUsers);

        $this->assertDatabaseHas('team_users', [
            'user_id' => $this->user0->id,
            'team_id' => $team->id
        ]);
    }
}
