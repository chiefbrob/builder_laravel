<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory()->create()->id,
            'variant_id' => null,
            'name' => $this->faker->name,
            'description' => $this->faker->sentences(5),
            'photo' => null,
            'quantity' => rand(0, 100),
            'product_size_id' => ProductSize::first()->id,
        ];
    }
}
