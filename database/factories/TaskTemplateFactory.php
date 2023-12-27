<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskTemplate>
 */
class TaskTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $team = Team::factory()->create();
        $task = Task::factory()->create();
        $task = Task::factory()->create(['team_id' => $team->id]);
        $subtask1 = Task::factory()->create(['task_id' => $task->id]);
        $subtask2 = Task::factory()->create(['task_id' => $task->id]);
        $subtask21 = Task::factory()->create(['task_id' => $subtask2->id]);
        
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->sentence(10),
            'config' => $task->toArray(),
            'team_id' => $team->id,
        ];
    }
}
