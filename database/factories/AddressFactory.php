<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'street_address' => $this->faker->streetAddress,
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'county' => $this->faker->state,
            'post_code' => $this->faker->postcode,
            'phone_number' => $this->faker->phoneNumber,
        ];
    }
}
