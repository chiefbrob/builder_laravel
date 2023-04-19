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

    private Team $team;

    private User $user0;
    private User $user1;

    private Task $task1;

    private Team $team2;

    public function setUp(): void
    {
        parent::setUp();

        $this->user0 = User::factory()->create();

        $role = Role::firstOrCreate(['name' => 'manager']);


        $this->actingAsAdmin()->post(route('user-role.create', [
            'user_id' => $this->user0->id,
            'role_id' => $role->id,
        ]))->assertCreated();

        $team = [
            'name' => 'Example Team1',
            'email' => 'team-1@teams.com',
            'description' => 'a Bar team'
        ];


        $this->actingAs($this->user0)->post(route('v1.teams.create', $team))
            ->assertCreated()->assertJson($team);

        $this->team = Team::where('name', $team['name'])->first();

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

        $this->user1 = User::factory()->create();

        $this->actingAsAdmin()->post(route('user-role.create', [
            'user_id' => $this->user1->id,
            'role_id' => $role->id,
        ]))->assertCreated();

        $this->actingAs($this->user1)
            ->post(route('v1.teams.create', ['name' => 'Another Team', 'email' => 'hello@team.mail']))
            ->assertCreated();

        $this->team2 = Team::where('name', 'Another Team')->first();

        $this->actingAs($this->user1)->post(route('v1.tasks.create'), [
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
                    'status' => [Task::READY]
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

        $this->actingAs($this->user0)->post(
            route('v1.tasks.create'),
            [
                'team_id' => $this->team['id'],
                'title' => 'Do something unique',
                'status' => Task::CANCELLED
            ]
        )->assertCreated();



        $this->actingAs($this->user0)->get(
            route(
                'v1.tasks.index',
                [
                    'team_id' => $this->team->id,
                    'status' => [Task::READY, TASK::OPEN]
                ]
            )
        )
                ->assertOk()
                ->assertJsonCount(2, 'data')
                ->assertjson(
                    [
                        'data' => [
                            [
                                'title' => 'Do something else',
                                'status' => Task::READY
                            ],
                            [
                                'title' => 'Do something',
                                'status' => Task::OPEN
                            ]
                        ],
                        'total' => 2,
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
                    'assigned_to' => [$this->user0->id]
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

    public function testTaskWithSubtasks()
    {
        $this->actingAs($this->user0)
            ->post(route('v1.tasks.create'), [
                'team_id' => $this->team->id,
                'title' => 'Subtask',
                'status' => Task::OPEN,
                'task_id' => $this->task1->id
            ])
            ->assertCreated()->assertJson(
                [
                    'data' => [
                        'title' => 'Subtask',
                        'team_id' => $this->team->id,
                        'user_id' => $this->user0->id,
                        'status' => Task::OPEN,
                        'task_id' => $this->task1->id
                    ]
                ]
            );

        $this->actingAs($this->user0)->get(
            route(
                'v1.tasks.index',
                [
                    'team_id' => $this->team->id,
                    'status' => [Task::READY],
                    'task_id' => $this->task1->id,
                ]
            )
        )
            ->assertOk()
            ->assertjson(
                [
                    'id' => $this->task1->id,
                    'title' => 'Do something',
                    'openTasks' => [
                        [
                            'title' => 'Subtask'
                        ]
                    ]
                ]
            );
    }
}
