<?php

namespace Tests\Feature\Shop;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddItemToCartControllerTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;
    private ProductVariant $variant;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
        $this->variant = ProductVariant::factory()->create([
            'product_id' => $this->product->id,
            'name' => 'variant 1',
            'quantity' => 3,
        ]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddProductToCart()
    {

        $this->get(route('v1.cart'))->assertOk()->assertJson([

            'cart' => [],

        ]);

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $this->variant->id,
            'quantity' => 2,
        ])->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $this->variant->id,
                    'quantity' => 2,
                    'product' => [
                        'id' => $this->variant->product->id,
                        'name' => $this->variant->product->name,
                    ],
                    'product_variant' => [
                        'id' => $this->variant->id
                    ]
                ],
            ],

        ]);

        $this->get(route('v1.cart'))->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $this->variant->id,
                    'quantity' => 2,
                ],
            ],

        ]);

        $this->delete(route('v1.cart.delete'), [
            'product_variant_id' => $this->variant->id,
            'quantity' => 1,
        ])->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $this->variant->id,
                    'quantity' => 1,
                ],
            ],

        ]);

        $this->delete(route('v1.cart.delete'), [
            'product_variant_id' => $this->variant->id,
            'quantity' => 1,
        ])->assertOk()->assertJson([

            'cart' => [],

        ]);

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $this->variant->id,
            'quantity' => 2,
        ])->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $this->variant->id,
                    'quantity' => 2,
                ],
            ],

        ]);

        $this->get(route('v1.cart'))->assertOk()->assertJson([

            'cart' => [
                [
                    'id' => $this->variant->id,
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

    public function testCantAddMoreThanAvailableToCart()
    {
        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $this->variant->id,
            'quantity' => 6,
        ])->assertUnprocessable();
    }
}
