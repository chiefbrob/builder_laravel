<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
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
            'email' => $this->faker->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'user_id' => User::factory()->create()->id,
            'contents' => $this->faker->paragraph(rand(1, 20)),
            'default_image' => 'image001.png',
            'url' => $this->faker->url(),
            'status' => Contact::STATUSES[rand(0, count(Contact::STATUSES)-1)]
        ];
    }
}
