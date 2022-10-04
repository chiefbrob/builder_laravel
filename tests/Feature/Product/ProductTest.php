<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProduct()
    {
        $product = Product::factory()->create();
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price * 100,
            'description' => $product->description,
            'photo' => null,
        ]);
    }
}
