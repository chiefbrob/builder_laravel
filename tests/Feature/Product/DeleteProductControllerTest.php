<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSoftDeletesProduct()
    {
        $this->actingAsAdmin();
        $product = Product::factory()->create();
        $variant = ProductVariant::create([
            'name' => $product->name,
            'product_id' => $product->id,
        ]);
        $this->get(route('v1.product.index'))
            ->assertOk()->assertJsonCount(1, 'data');
        $this->delete(route('v1.product.delete', ['id' => $product->id]))->assertOk();

        

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);

        $this->get(route('v1.product.index'))
            ->assertOk()->assertJsonCount(0, 'data');
    }
}
