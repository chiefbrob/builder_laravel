<?php

namespace Tests\Feature\Invoices;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoicesIndexControllerTest extends TestCase
{
    public Product $product;
    public Product $product2;

    public ProductVariant $variant1;
    public ProductVariant $variant2;

    public ProductVariant $variant3;
    public ProductVariant $variant4;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create(['name' => 'foo']);
        $this->variant1 = ProductVariant::create(
            [
                'product_id' => $this->product->id,
                'name' => 'variant foo 1',
                'quantity' => 5
            ]
        );
        $this->variant2 = ProductVariant::create(
            [
                'product_id' => $this->product->id,
                'name' => 'variant foo 2',
                'quantity' => 3
            ]
        );

        $this->product2 = Product::factory()->create(['name' => 'bar']);
        $this->variant3 = ProductVariant::create(
            [
                'product_id' => $this->product2->id,
                'name' => 'variant bar 22',
                'quantity' => 10
            ]
        );
        $this->variant4 = ProductVariant::create(
            [
                'product_id' => $this->product2->id,
                'name' => 'variant bar 33',
                'quantity' => 0
            ]
        );

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $this->variant1->id,
            'quantity' => 2,
        ])->assertOk();

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $this->variant2->id,
            'quantity' => 3,
        ])->assertOk();

        $this->post(route('v1.cart.add'), [
            'product_variant_id' => $this->variant3->id,
            'quantity' => 10,
        ])->assertOk();

        $this->get(route('v1.cart'))->assertOk()->assertJson(
            [
                'cart' => [
                    [
                        'id' => $this->variant1->id,
                        'quantity' => 2,
                    ],
                    [
                        'id' => $this->variant2->id,
                        'quantity' => 3,
                    ],
                    [
                        'id' => $this->variant3->id,
                        'quantity' => 10,
                    ],
                ],
            ]
        );

        $this->post(
            route('v1.checkout'), 
            [
                'first_name' => 'Brian',
                'phone_number' => '254732938104',
                'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            ]
        )->assertOk();
        $this->user = User::first();
        $this->actingAs($this->user);
    }
    

    public function testCanGetPaginatedInvoices(): void
    {
        
        $this->get(route('v1.invoices.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson(
                [
                    'data' => [
                        [
                            'cart' => [
                                [
                                    'id' => $this->variant1->id,
                                ],
                                [
                                    'id' => $this->variant2->id,
                                ],
                                [
                                    'id' => $this->variant3->id,
                                ]
                            ]
                        ]
                    ]
                ]
            );
    }
}
