<?php

namespace Tests\Feature\Shop;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmptyCartControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testEmptyCart(): void
    {
        $product = Product::factory()->create();
        $variant1 = ProductVariant::factory()->create(
            ['name' => 'abc', 'quantity' => 5, 'product_id' => $product->id]
        );

        $originalQuantity = $variant1->quantity;

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $variant1->id,
            'quantity' => 2,
        ])->assertOk();

        $this->get(route('v1.cart'))->assertOk()->assertJson(
            [
                'cart' => [
                    [
                        'id' => $variant1->id,
                        'quantity' => 2,
                    ],
                ],
            ]
        );

        $this->delete(route('v1.cart.empty'))->assertOk()
            ->assertJson([]);

        $this->get(route('v1.cart'))->assertOk()->assertJson(['cart' => [],])
            ->assertJsonCount(0, 'cart');
    }
}
