<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskTemplateControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testTeamMemberCanCreateATaskTemplate(): void
    {
        $this->actingAsRandomUser();
        $task = Task::factory()->create(['user_id' => $this->user->id]);
        $task->team->addUser($this->user); 
        $this->assignRole($this->user, 'manager');

        $this->post(
            route(
                'v1.task-template.create', 
                [
                    'title' => 'Workflow for new Client',
                    'task_id' => $task->id
                ]
            )
        )
            ->assertCreated()
            ->assertJson(
                [
                    'title' => 'Workflow for new Client',
                    'config' => [
                        'id' => $task->id,
                        'title' => $task->title,
                    ]
                ]
            );

        $this->assertDatabaseHas(
            'task_templates', [
                'title' =>'Workflow for new Client',

            ]
        );

    }
}
