<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreateProductVariantControllerTest extends TestCase
{
    public function testCreateProductVariant(): void
    {
        $this->actingAsAdmin();

        $product = Product::factory()->create();

        $this->post(
            route(
                'v1.product-variant.create', 
                [
                    'product_id' => $product->id,
                    'name' => 'variant-2',
                    'description' => 'details on variant 2',
                    'quantity' => 200,
                ]
            )
        )
            ->assertCreated()
            ->assertJson([
                
                'product_id' => $product->id,
                'name' => 'variant-2',
                'description' => 'details on variant 2',
                'quantity' => 200,
                
            ]);

        $this->assertDatabaseHas(
            'product_variants', 
            [
                'product_id' => $product->id,
                'name' => 'variant-2',
                'description' => 'details on variant 2',
                'quantity' => 200,
            ]
        );
    }
}
