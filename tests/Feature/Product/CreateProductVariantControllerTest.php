<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreateProductVariantControllerTest extends TestCase
{
    public Product $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
        $this->product = Product::factory()->create();
    }

    private function createProductVariant()
    {
        return $this->post(
            route(
                'v1.product-variant.create', 
                [
                    'product_id' => $this->product->id,
                    'name' => 'variant-2',
                    'description' => 'details on variant 2',
                    'quantity' => 200,
                ]
            )
        );
    }

    public function testCreateProductVariant(): void
    {
        $this->createProductVariant()
            ->assertCreated()
            ->assertJson(
                [
                    'product_id' => $this->product->id,
                    'name' => 'variant-2',
                    'description' => 'details on variant 2',
                    'quantity' => 200,
                ]
            );

        $this->assertDatabaseHas(
            'product_variants', 
            [
                'product_id' => $this->product->id,
                'name' => 'variant-2',
                'description' => 'details on variant 2',
                'quantity' => 200,
            ]
        );
    }

    public function testCreateVariantOfProductVariant(): void
    {
        $this->post(
            route(
                'v1.product-variant.create', 
                [
                    'product_id' => $this->product->id,
                    'name' => 'variant-2',
                    'description' => 'details on variant 2',
                    'quantity' => 200,
                ]
            )
        )
            ->assertCreated()
            ->assertJson(
                [
                    'product_id' => $this->product->id,
                    'name' => 'variant-2',
                    'description' => 'details on variant 2',
                    'quantity' => 200,
                ]
            );

        $this->assertDatabaseHas(
            'product_variants', 
            [
                'product_id' => $this->product->id,
                'name' => 'variant-2',
                'description' => 'details on variant 2',
                'quantity' => 200,
            ]
        );
    }
}
