<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProductVariantControllerTest extends TestCase
{
    public ProductVariant $variant;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();

        $product = Product::factory()->create();

        $this->variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Foo Bar',
            'description' => 'A foo bar product variant',
            'quantity' => 3
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function testAdminCanUpdateProductVariant(): void
    {
        $oldpic = $this->variant->photo;
        $this->post(
            route(
                'v1.product-variant.update', [
                    'product_id' => $this->variant->product->id,
                    'product_variant_id' => $this->variant->id,
                    'name' => 'Bar Foo',
                    'quantity' => 19
                ]
            )
        )->assertOk()
        ->assertJson([
            'name' => 'Bar Foo',
            'quantity' => 19
        ]);

        $this->assertDatabaseHas('product_variants', [
            'name' => 'Bar Foo',
            'quantity' => 19
        ]);
    }
}
