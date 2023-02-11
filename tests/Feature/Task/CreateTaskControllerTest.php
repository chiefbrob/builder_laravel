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

    public function testCannotCreateTaskIfNotTeamMember()
    {

        $this->actingAs($this->user2)->post(route('v1.tasks.create'), [
            'team_id' => $this->team->id,
            'title' => 'Do something else',
            'status' => Task::DONE
        ])->assertRedirect();


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
        //
    }
}
