<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestoreProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testDeletedProductCanBeRestored(): void
    {
        $this->actingAsAdmin();
        $product = Product::factory()->create();
        $product->delete();
        $this->patch(route('v1.product.restore', ['product_id' => $product->id]))
            ->assertOk()
            ->assertJson([
                'message' => 'success'
            ]);
    }
}
