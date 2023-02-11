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
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateTask()
    {
        Team::factory()->create();
        User::factory()->create();
        User::factory()->create();
        $user = User::factory()->create();

        $team = Team::factory()->create(['user_id' => $user->id]);
        $team->addUser($user);

        $user1 = User::factory()->create();
        $team->addUser($user1);
        $user2 = User::factory()->create();


        $this->actingAs($user)->post(route('v1.tasks.create'), [
            'team_id' => $team->id,
            'title' => 'Do something',
            'status' => Task::OPEN
        ])->assertCreated()->assertJson(
            [
                'data' => [
                    'title' => 'Do something',
                    'team_id' => $team->id,
                    'user_id' => $user->id,
                    'status' => Task::OPEN,
                ]
            ]
        );

        $this->assertDatabaseHas('tasks', [
            'title' => 'Do something',
            'team_id' => $team->id,
            'user_id' => $user->id,
            'status' => Task::OPEN,
        ]);

        $this->actingAs($user2)->post(route('v1.tasks.create'), [
            'team_id' => $team->id,
            'title' => 'Do something else',
            'status' => Task::DONE
        ])->assertUnprocessable();


        $this->assertDatabaseMissing('tasks', [
            'title' => 'Do something else',
            'team_id' => $team->id,
            'user_id' => $user2->id,
            'status' => Task::DONE,
        ]);

    }
}
