<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private Team $team;
    private Team $team2;
    private User $user0;
    private User $user1;
    private User $user2;
    private User $user7;
    private User $user8;

    public function setUp(): void
    {
        parent::setUp();

        Team::factory()->create();
        User::factory()->create();
        User::factory()->create();
        $this->user0 = User::factory()->create();

        $this->team = Team::factory()->create(['user_id' => $this->user0->id]);
        $this->team->addUser($this->user0);

        $this->user1 = User::factory()->create();
        $this->team->addUser($this->user1);
        $this->user2 = User::factory()->create();

        $this->user7 = User::factory()->create();
        $this->team->addUser($this->user7);

        $this->user8 = User::factory()->create();

        $this->team2 = Team::factory()->create(['shortcode' => 'BAR']);
        $this->team2->addUser($this->user8);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateTask()
    {


        $this->actingAs($this->user0)->post(route('v1.tasks.create'), [
            'team_id' => $this->team->id,
            'title' => 'Do something',
            'status' => Task::OPEN
        ])->assertCreated()->assertJson(
            [
                'data' => [
                    'title' => 'Do something',
                    'team_id' => $this->team->id,
                    'user_id' => $this->user0->id,
                    'status' => Task::OPEN,
                ]
            ]
        );

        $this->assertDatabaseHas('tasks', [
            'title' => 'Do something',
            'team_id' => $this->team->id,
            'user_id' => $this->user0->id,
            'status' => Task::OPEN,
        ]);

    }

    public function testShortcode()
    {
        $response = $this->actingAs($this->user8)->post(route('v1.tasks.create'), [
            'team_id' => $this->team2->id,
            'title' => 'Do crazy',
            'status' => Task::DONE
        ])->assertCreated()->assertJson(
            [
                'data' => [
                    'title' => 'Do crazy',
                    'team_id' => $this->team2->id,
                    'user_id' => $this->user8->id,
                    'status' => Task::DONE
                ]
            ]
        );


        $this->assertDatabaseHas('tasks', [
            'title' => 'Do crazy',
            'team_id' => $this->team2->id,
            'user_id' => $this->user8->id,
            'status' => Task::DONE,
            'shortcode' => 'BAR-'.$response['data']['id']
        ]);
    }

    public function testCannotCreateTaskIfNotTeamMember()
    {

        $this->actingAs($this->user2)->post(route('v1.tasks.create'), [
            'team_id' => $this->team->id,
            'title' => 'Do something else',
            'status' => Task::DONE
        ])->assertUnprocessable();


        $this->assertDatabaseMissing('tasks', [
            'title' => 'Do something else',
            'team_id' => $this->team->id,
            'user_id' => $this->user2->id,
            'status' => Task::DONE,
        ]);


    }
    public function testAssigningTask()
    {
        $this->actingAs($this->user0)->post(route('v1.tasks.create'), [
            'team_id' => $this->team->id,
            'title' => 'Work',
            'status' => Task::OPEN,
            'assigned_to' => $this->user7->id,
        ])->assertCreated()->assertJson(
            [
                'data' => [
                    'title' => 'Work',
                    'team_id' => $this->team->id,
                    'user_id' => $this->user0->id,
                    'status' => Task::OPEN,
                    'assigned_to' => $this->user7->id,
                ]
            ]
        );

        $this->assertDatabaseHas('tasks', [
            'title' => 'Work',
            'team_id' => $this->team->id,
            'user_id' => $this->user0->id,
            'status' => Task::OPEN,
            'assigned_to' => $this->user7->id,
        ]);

    }
    public function testCannotAssignToNonTeamMember()
    {
        $this->actingAs($this->user0)->post(route('v1.tasks.create'), [
            'team_id' => $this->team->id,
            'title' => 'Again Again',
            'status' => Task::DONE,
            'assigned_to' => $this->user8->id,
        ])->assertUnprocessable();


        $this->assertDatabaseMissing('tasks', [
            'title' => 'Again Again',
            'assigned_to' => $this->user8->id,
            'team_id' => $this->team->id,
            'user_id' => $this->user0->id,
            'status' => Task::DONE,
        ]);

    }

    public function testCreateSubTask()
    {
        $workTitle = 'Work123';
        $workTitle2 = 'Work456';
        $this->actingAs($this->user0)->post(route('v1.tasks.create'), [
            'team_id' => $this->team->id,
            'title' => $workTitle,
            'status' => Task::OPEN,
            'assigned_to' => $this->user7->id,
        ])->assertCreated()->assertJson(
            [
                'data' => [
                    'title' => $workTitle,
                    'team_id' => $this->team->id,
                ]
            ]
        );

        $task = Task::where('title', $workTitle)->first();

        $this->actingAs($this->user0)->post(route('v1.tasks.create'), [
            'team_id' => $this->team->id,
            'title' => $workTitle2,
            'status' => Task::OPEN,
            'assigned_to' => $this->user7->id,
            'task_id' => $task->id
        ])->assertCreated()->assertJson(
            [
                'data' => [
                    'title' => $workTitle2,
                    'team_id' => $this->team->id,
                    'task_id' => $task->id
                ]
            ]
        );

        $this->assertDatabaseHas('tasks', [
            'title' => $workTitle2,
            'team_id' => $this->team->id,
            'user_id' => $this->user0->id,
            'task_id' => $task->id,
            'status' => Task::OPEN,
            'assigned_to' => $this->user7->id,
        ]);

        //
    }
}
