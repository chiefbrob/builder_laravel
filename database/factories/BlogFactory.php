<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'subtitle' => $this->faker->sentence(10),
            'user_id' => User::factory()->create()->id,
            'contents' => $this->faker->paragraph(19),
            'default_image' => 'image001.png',
        ];
    }
}
