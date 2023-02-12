<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStateChange>
 */
class TaskStateChangeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $task = Task::factory()->create();
        return [
            'task_id' => $task->id,
            'status' => Task::DOING,
            'user_id' => $task->user->id,
            'comments' => $this->faker->sentence(),
        ];
    }
}
