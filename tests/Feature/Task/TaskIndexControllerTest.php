<?php

namespace Tests\Feature\Task;

use App\Models\Role;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskIndexControllerTest extends TestCase
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

        $this->actingAsAdmin()->post(route('v1.teams.create', ['name' => 'Another Team', 'email' => 'hello@team.mail']))
            ->assertCreated();

        $this->team2 = Team::where('name', 'Another Team')->first();

        $this->actingAs($this->user)->post(route('v1.tasks.create'), [
            'team_id' => $this->team2->id,
            'title' => 'Work',
            'status' => Task::OPEN,

        ])->assertCreated();

    }

    public function testUserCanViewTasksByProject()
    {
        $this->actingAs($this->user0)->get(
            route('v1.tasks.index', ['team_id' => $this->team->id])
        )
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertjson(
                [
                    'data' => [
                        [
                            'title' => 'Do something else'
                        ],
                        [
                            'title' => 'Do something'
                        ]
                    ],
                    'total' => 2,
                ]
            );


    }

    public function testUserCanFilterByTaskStatus()
    {
        $this->actingAs($this->user0)->get(
            route(
                'v1.tasks.index',
                [
                    'team_id' => $this->team->id,
                    'status' => Task::READY
                ]
            )
        )
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertjson(
                [
                    'data' => [
                        [
                            'title' => 'Do something else'
                        ]
                    ],
                    'total' => 1,
                ]
            );
    }

    public function testViewTasksAssignedToUser()
    {
        $this->actingAs($this->user0)->get(
            route(
                'v1.tasks.index',
                [
                    'team_id' => $this->team->id,
                    'assigned_to' => $this->user0->id
                ]
            )
        )
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertjson(
                [
                    'data' => [
                        [
                            'title' => 'Do something else'
                        ]
                    ],
                    'total' => 1,
                ]
            );
    }

    public function testViewSingleTask()
    {
        $this->actingAs($this->user0)->get(
            route(
                'v1.tasks.index',
                [
                    'team_id' => $this->team->id,
                    'status' => Task::READY,
                    'task_id' => $this->task1->id,
                ]
            )
        )
            ->assertOk()
            ->assertjson(
                [
                    'id' => $this->task1->id,
                    'title' => 'Do something'
                ]
            );
    }
}
