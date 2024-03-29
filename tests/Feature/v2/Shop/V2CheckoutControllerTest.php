<?php

namespace Tests\Feature\v2\Shop;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shop\Variants;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class V2CheckoutControllerTest extends TestCase
{
    private Product $product1;
    private Product $product2;
    private Product $product3;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');

        $this->product1 = Product::factory()->create(['price' => 2500]);
        $this->createVariants($this->product1, ['AA', 'BB', 'CC']);

        $this->product2 = Product::factory()->create(['price' => 3000]);
        $this->createVariants($this->product2, ['EEE', 'FFE', 'GHI', 'KLM', 'OST']);

        $this->product3 = Product::factory()->create(['price' => 5000]);
        $this->createVariants($this->product1, ['NOPE']);

        Mail::fake();
    }

    private function createVariants(Variants $v, array $names)
    {
        foreach ($names as $name) {
            if (get_class($v) === 'App\Models\Product') {
                ProductVariant::factory()->create(
                    [
                        'product_id' => $v->id,
                        'name' => 'Variant '.$name,
                        'quantity' => rand(5, 20),
                    ]
                );
            } else {
                ProductVariant::factory()->create(
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

    private function makeCart()
    {
        $variants = [
            $this->product1->productVariants[0], 
            $this->product2->productVariants[0],  
            $this->product2->productVariants[1]
        ];

        $cart = [];
        foreach ($variants as $variant) {
            $cart[] = [
                'id' => $variant->id,
                'quantity' => 2
            ];
        }
        return $cart;
    }

    public function testGuestApiCanCheckout(): void
    {
        $cart = $this->makeCart();
        $phoneNumber = '254722222222';
        $this->post(route('v2.checkout', [
            'phone_number' => $phoneNumber,
            'payment_method_id' => PaymentMethod::first()->id,
            'first_name' => 'Henry Doe',
            'cart' => $cart
        ]))
            ->assertOk()
            ->assertJson(
                [
                    'invoice' => [
                        'sub_total' => 17000,
                        'grand_total' => 17000,
                        'tax' => 0,
                        'user' =>  [
                            'name' => 'Henry Doe',
                            'phone_number' => $phoneNumber
                        ]
                    ]
                ]
            );

        $user = User::where('phone_number', $phoneNumber)->first();
        $this->assertDatabaseHas(
            'addresses', 
            [
                'user_id' => $user->id,
                'phone_number' => $phoneNumber
            ]
        );

        $this->assertDatabaseHas(
            'invoices', 
            [
                'user_id' => $user->id,
                'sub_total' => 1700000,
                'grand_total' => 1700000,
            ]
        );

        $invoice = Invoice::latest()->first();

        $this->assertEquals(count($invoice->cart), count($cart));
    }

    public function testApiUserCanCheckout():  void
    {
        $this->actingAsRandomApiUser();

        $address = Address::factory()->create(['user_id' => $this->user->id]);
        $cart = $this->makeCart();

        $this->post(route('v2.checkout'), [
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            'address_id' => $address->id,
            'cart' => $cart
        ])->assertOk()->assertJson([
            'invoice' => [
                'sub_total' => 17000,
                'grand_total' => 17000,
                'tax' => 0,
                'address_id' => $address->id,
            ],
        ]);
    }
}
