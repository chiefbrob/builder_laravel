<?php

namespace Database\Factories;

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
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->sentence(10),
            'config' => [
                'title' => 'Loremp ipsum dolor',
                'tasks' => [
                    [
                        'title' => 'Foo Bar'
                    ]
                ]
            ],
        ];
    }
}
