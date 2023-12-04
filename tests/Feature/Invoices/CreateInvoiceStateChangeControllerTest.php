<?php

namespace Tests\Feature\Invoices;

use App\Models\Invoice;
use App\Models\InvoiceState;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Tests\TestCase;

class CreateInvoiceStateChangeControllerTest extends TestCase
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
                'name' => 'variant bar 1',
                'quantity' => 5
            ]
        );
        $this->variant2 = ProductVariant::create(
            [
                'product_id' => $this->product->id,
                'name' => 'variant xim 2',
                'quantity' => 3
            ]
        );

        $this->product2 = Product::factory()->create(['name' => 'bar']);
        $this->variant3 = ProductVariant::create(
            [
                'product_id' => $this->product2->id,
                'name' => 'variant xim 22',
                'quantity' => 10
            ]
        );
        $this->variant4 = ProductVariant::create(
            [
                'product_id' => $this->product2->id,
                'name' => 'variant foobar 33',
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
                'first_name' => 'Chief',
                'phone_number' => '254732928373',
                'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            ]
        )->assertOk();
        $this->user = User::first();
        
    }

    public function testAdminCanUpdateInvoiceState(): void
    {
        $this->actingAsAdmin();
        $invoice = Invoice::first();
        $invoiceState = [
            'invoice_id' => $invoice->id,
            'status' => InvoiceState::STATUS_PROCESSING,
            'notes' => 'foo bar',
            'previous_status' => 'PENDING'
        ];
        $this->post(
            route(
                'v1.invoices.createstate', 
                [
                    'reference' => $invoice->reference,
                    'invoice_id' => $invoice->id,
                    'status' => InvoiceState::STATUS_PROCESSING,
                    'notes' => 'foo bar'
                ]
            )
        )->assertCreated()
            ->assertJson($invoiceState);

        $this->assertDatabaseHas('invoice_states', $invoiceState);

        $invoice->refresh();

        $this->assertEquals($invoice->status, $invoiceState['status']);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => $invoiceState['status']
        ]);
    }

    public function testOtherUserCannotUpdateInvoiceState(): void
    {
        $this->actingAsRandomUser();
        $invoice = Invoice::first();
        $this->post(
            route(
                'v1.invoices.createstate', 
                [
                    'reference' => $invoice->reference,
                    'invoice_id' => $invoice->id,
                    'status' => InvoiceState::STATUS_PROCESSING,
                    'notes' => 'foo xim'
                ]
            )
        )->assertStatus(403);
    }
}
