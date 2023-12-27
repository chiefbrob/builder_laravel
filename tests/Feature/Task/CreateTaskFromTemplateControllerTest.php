<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskTemplate;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskFromTemplateControllerTest extends TestCase
{
    
    public function testUserCanCreateATaskFromTaskTemplate(): void
    {
        $this->actingAsRandomUser();

        $team = Team::factory()->create(['shortcode' => 'MECH']);
        $team->addUser($this->user);

        $tt = TaskTemplate::factory()->create(
            [
                'team_id' => $team->id,
                'title' => 'Car Service',
                'config' => [
                    [
                        'title' => 'Engine Oil Service',
                        'status' => Task::DOING,
                        'tasks' => [
                            [
                                'title' => 'Drain Engine Oil',
                                'tasks' => [
                                    [
                                        'title' => 'Check for engine wear'
                                    ]
                                ]
                            ],
                            [
                                'title' => 'Change Oil filter'
                            ],
                            [
                                'title' => 'Refill oil'
                            ],
                        ]
                    ],
                    [
                        'title' => 'Change Air Filters',
                    ],
                    [
                        'title' => 'Check Braking System',
                    ]
                ]
            ]
        );

        $this->post(
            route(
                'v1.task-template.use', 
                [
                    'task_template_id' => $tt->id,
                    'team_id' => $team->id,
                ]
            ), [
                'task_template_id' => $tt->id
            ]
        )
            ->assertCreated()
            ->assertJson(
                [
                    'title' => 'Car Service'
                ]
            );

        $this->assertEquals(8, Task::count());
        
        $carService = Task::where('title', 'Car Service')->firstOrFail();
        $oilService = Task::where('title', 'Engine Oil Service')->firstOrFail();
        $drainOil = Task::where('title', 'Drain Engine Oil')->firstOrFail();
        $engineWear = Task::where('title', 'Check for engine wear')->firstOrFail();
        $airFilter = Task::where('title', 'Change Air Filters')->firstOrFail();

        $this->assertEquals($oilService->task_id, $carService->id);
        $this->assertEquals($oilService->status, Task::DOING);
        $this->assertEquals($drainOil->task_id, $oilService->id);
        $this->assertEquals($engineWear->task_id, $drainOil->id);
        $this->assertEquals($airFilter->task_id, $carService->id);
    }
}
