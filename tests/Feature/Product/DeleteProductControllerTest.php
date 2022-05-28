<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSoftDeletesProduct()
    {
        $this->actingAsAdmin();
        $product = Product::factory()->create();
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
