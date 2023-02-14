<?php

namespace Tests\Feature\Task;

use App\Models\Role;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStateChangeControllerTest extends TestCase
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

        $this->team = [
            'name' => 'Example Team1',
            'email' => 'team-1@teams.com',
            'description' => 'a Bar team'
        ];


        $this->actingAs($this->user0)->post(route('v1.teams.create', $this->team))
            ->assertCreated()->assertJson($this->team);

        $this->team = Team::where('name', $this->team['name'])->first();

        $this->actingAs($this->user0)->post(route('v1.tasks.create'), [
            'team_id' => $this->team['id'],
            'title' => 'Do something',
            'status' => Task::OPEN
        ])->assertCreated();

        $this->task1 = Task::where('title', 'Do something')->first();

        $this->actingAs($this->user0)->post(route('v1.tasks.create'), [
            'team_id' => $this->team['id'],
            'title' => 'Do something else',
            'status' => Task::READY,
            'assigned_to' => $this->user0->id
        ])->assertCreated();

        $this->task2 = Task::where('title', 'Do something else')->first();

        $this->user1 = User::factory()->create();

        $this->actingAsAdmin()->post(route('user-role.create', [
            'user_id' => $this->user1->id,
            'role_id' => $role->id,
        ]))->assertCreated();

        $this->actingAs($this->user1)->post(route('v1.teams.create', ['name' => 'Another Team', 'email' => 'hello@team.mail']))
            ->assertCreated();

        $this->team2 = Team::where('name', 'Another Team')->first();

        $this->actingAs($this->user1)->post(route('v1.tasks.create'), [
            'team_id' => $this->team2->id,
            'title' => 'Work',
            'status' => Task::OPEN,

        ])->assertCreated();

        $this->task3 = Task::where('title', 'Work')->first();

    }

    public function testUserCanChangeTaskState()
    {
        $newuser = User::factory()->create();
        $this->actingAs($this->user0)->post(
            route('v1.teams.adduser', $this->team->id),
            ['user_id' => $newuser->id]
        )
            ->assertOk();

        $this->actingAs($this->user0)->put(
            route(
                'v1.tasks.update',
                [
                    'title' => 'Work99',
                    'description' => 'loremp ipsum',
                    'task_id' => $this->task1->id,
                    'user_id' => $this->user0->id,
                    'status' => Task::READY,
                    'notes' => 'Week 22 Work',
                    'assigned_to' => $newuser->id,
                ]
            )
        )
            ->assertOk()
            ->assertjson(
                [
                    'title' => 'Work99',
                    'description' => 'loremp ipsum',
                    'assigned_to' => $newuser->id,
                    'status' => Task::READY,
                    'assigned_to' => $newuser->id,
                ]
            );

            $this->assertDatabaseHas('tasks', [
                'title' => 'Work99',
                'description' => 'loremp ipsum',
                'task_id' => $this->task1->id,
                'assigned_to' => $newuser->id,
                'status' => Task::READY,
                'assigned_to' => $newuser->id,
            ]);

            $this->assertDatabaseHas('task_state_changes', [
                'task_id' => $this->task1->id,
                'user_id' => $this->user0->id,
                'new_status' => Task::READY,
                'old_status' => Task::OPEN,
                'notes' => 'Week 22 Work',
            ]);
    }

    public function testOnlyTeamMembersCanAssigned()
    {
        $newuser = User::factory()->create();
        $this->actingAs($this->user0)->put(
            route(
                'v1.tasks.update',
                [
                    'title' => 'Work99',
                    'description' => 'loremp ipsum',
                    'task_id' => $this->task1->id,
                    'user_id' => $this->user0->id,
                    'status' => Task::READY,
                    'notes' => 'Week 22 Work',
                    'assigned_to' => $newuser->id,
                ]
            )
        )
            ->assertUnprocessable()
            ->assertJson(["message" => "Failed to update task"]);

        $this->assertDatabaseMissing('task_state_changes', [
            'task_id' => $this->task1->id,
            'user_id' => $this->user0->id,
            'new_status' => Task::READY,
            'old_status' => Task::OPEN,
            'notes' => 'Week 22 Work',
        ]);

    }
}
