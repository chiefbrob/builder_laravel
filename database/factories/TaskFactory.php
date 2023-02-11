<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(rand(3, 4)),
            'description' => $this->faker->sentence(rand(6, 10)),
            'team_id' => Team::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'assigned_to' => User::factory()->create()->id,
            'status' => Task::OPEN,
        ];
    }
}
