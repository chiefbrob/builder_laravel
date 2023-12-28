<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskTemplate;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTaskTemplatesControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetTaskTemplates(): void
    {
        $this->actingAsRandomUser();

        $this->get(route('v1.task-templates.index'))
            ->assertOk()
            ->assertJson(
                [
                    'total' => 0
                ]
            )
            ->assertJsonCount(0, 'data');

        $generalTaskTemplate = TaskTemplate::create(
            [
                'title' => 'General TT',
                'config' => [
                    'title' => 'Loremp ipsum'
                ]
            ]
        );

        $this->get(route('v1.task-templates.index'))
            ->assertOk()
            ->assertJson(
                [
                    'total' => 1,
                    'data' => [
                        [
                            'id' => $generalTaskTemplate->id,
                            'title' => $generalTaskTemplate->title,
                        ]
                    ]
                ]
            )
            ->assertJsonCount(1, 'data');

        $task = Task::factory()->create(['user_id' => $this->user->id]);
        $task->team->addUser($this->user);

        $this->assignRole($this->user, 'manager');

        $this->post(
            route(
                'v1.task-template.create', 
                [
                    'title' => 'Workflow for new Client',
                    'task_id' => $task->id,
                    'team_id' => $task->team_id
                ]
            )
        )->assertCreated();

        $this->get(route('v1.task-templates.index'))
            ->assertOk()
            ->assertJson(
                [
                    'data' => [
                        [
                            'title' => 'Workflow for new Client',
                            'config' => [
                                'title' => $task->title
                            ]
                        ],
                        [
                            'title' => $generalTaskTemplate->title
                        ]
                    ]
                ]
            )
            ->assertJsonCount(2, 'data');

        $this->get(route('v1.task-templates.index', ['team_id' => $task->team_id]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson(
                [
                    'data' => [
                        [
                            'title' => 'Workflow for new Client',
                            'config' => [
                                'title' => $task->title
                            ]
                        ]
                    ]
                ]
            );
        $tt = TaskTemplate::where('title', 'Workflow for new Client')->first();

        $this->get(route('v1.task-templates.index', ['task_template_id' => $tt->id]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson(
                [
                    'data' => [
                        [
                            'title' => 'Workflow for new Client',
                            'config' => [
                                'title' => $task->title
                            ]
                        ]
                    ]
                ]
            );

        $anotherUser = User::factory()->create();

        $this->actingAs($anotherUser)
            ->get(route('v1.task-templates.index', ['team_id' => $task->team_id]))
            ->assertOk()
            ->assertJsonCount(0, 'data');

        $this->actingAs($anotherUser)
            ->get(route('v1.task-templates.index', ['task_template_id' => $tt->id]))
            ->assertOk()
            ->assertJsonCount(0, 'data');
        
    }
}
