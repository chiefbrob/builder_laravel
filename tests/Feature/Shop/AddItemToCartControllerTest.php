<?php

namespace Tests\Feature\Shop;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddItemToCartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddProductToCart()
    {
        $product = Product::factory()->create();
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'variant 1',
            'quantity' => 3,
        ]);
        $this->get(route('v1.cart'))->assertOk()->assertJson([

            'cart' => [],

        ]);

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ])->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $variant->id,
                    'quantity' => 2,
                ],
            ],

        ]);

        $this->get(route('v1.cart'))->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $variant->id,
                    'quantity' => 2,
                ],
            ],

        ]);

        $this->delete(route('v1.cart.delete'), [
            'product_variant_id' => $variant->id,
            'quantity' => 1,
        ])->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $variant->id,
                    'quantity' => 1,
                ],
            ],

        ]);

        $this->delete(route('v1.cart.delete'), [
            'product_variant_id' => $variant->id,
            'quantity' => 1,
        ])->assertOk()->assertJson([

            'cart' => [],

        ]);

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ])->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $variant->id,
                    'quantity' => 2,
                ],
            ],

        ]);

        $this->get(route('v1.cart'))->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $variant->id,
                    'quantity' => 2,
                ],
            ],

        ]);

        $this->delete(route('v1.cart.empty'))->assertOk()->assertJson([

            'cart' => [],

        ]);

        $this->get(route('v1.cart'))->assertOk()->assertJson([

            'cart' => [],

        ]);
    }
}
