<?php

namespace Tests\Feature\Shop;

use App\Models\Address;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shop\Variants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    private $product1;

    private $product2;

    private $product3;

    public function setUp(): void
    {
        parent::setUp();

        $this->product1 = Product::factory()->create(['price' => 100]);
        $this->createVariants($this->product1, ['A', 'B', 'C']);

        $this->product2 = Product::factory()->create(['price' => 500]);
        $this->createVariants($this->product2, ['E', 'F', 'G', 'K']);

        $this->product3 = Product::factory()->create(['price' => 850]);
        $this->createVariants($this->product1, ['X']);
    }

    private function createVariants(Variants $v, array $names)
    {
        foreach ($names as $name) {
            if (get_class($v) === 'App\Models\Product') {
                ProductVariant::create(
                    [
                        'product_id' => $v->id,
                        'name' => 'Variant '.$name,
                        'quantity' => rand(5, 20),
                    ]
                );
            } else {
                ProductVariant::create(
                    [
                        'product_id' => $v->product->id,
                        'variant_id' => $v->id,
                        'name' => 'Variant '.$name,
                        'quantity' => rand(5, 20),
                    ]
                );
            }
        }
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGuestUserCanCheckout()
    {
        $variant1 = ProductVariant::inRandomOrder()->first();

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

        $response = $this->post(route('v1.checkout'), [
            'first_name' => 'Brian',
            'phone_number' => '254732938104',
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
        ])->assertOk()->assertJson([
            'invoice' => [
                'tax' => 0,
            ],
        ]);

        $invoice = $response->baseResponse->original;
        $variant1->refresh();

        $this->assertEquals($originalQuantity - 2, $variant1->quantity);

        $this->assertDatabaseHas('users', [
            'phone_number' => '254732938104',
            'name' => 'Brian',
        ]);

        $this->assertDatabaseHas('addresses', [
            'first_name' => 'Brian',
        ]);
    }

    public function testAuthUserCanCheckout()
    {
        $this->actingAsRandomUser();

        $variants = $this->product1->productVariants;

        $variant1 = $variants[0];
        $variant2 = $variants[1];

        $originalQuantity1 = $variant1->quantity;
        $originalQuantity2 = $variant2->quantity;

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $variant1->id,
            'quantity' => 2,
        ])->assertOk();

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $variant2->id,
            'quantity' => 3,
        ])->assertOk();

        $this->get(route('v1.cart'))->assertOk()->assertJson(
            [
                'cart' => [
                    [
                        'id' => $variant1->id,
                        'quantity' => 2,
                    ],
                    [
                        'id' => $variant2->id,
                        'quantity' => 3,
                    ],
                ],
            ]
        );

        $address = Address::factory()->create(['user_id' => $this->user->id]);

        $response = $this->post(route('v1.checkout'), [
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            'address_id' => $address->id
        ])->assertOk()->assertJson([
            'invoice' => [
                'tax' => 0,
            ],
        ]);

        $variant1->refresh();
        $variant2->refresh();

        $this->assertEquals($originalQuantity1 - 2, $variant1->quantity);
        $this->assertEquals($originalQuantity2 - 3, $variant2->quantity);
    }
}
