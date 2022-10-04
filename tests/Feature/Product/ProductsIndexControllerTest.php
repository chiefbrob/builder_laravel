<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsIndexControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetSingleProduct()
    {
        $this->actingAsRandomUser();
        $product = Product::factory()->create();

        $response = $this->get(route('v1.product.index', ['id' => $product->id]))->assertOk();

        $response->assertStatus(200)->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'description' => $product->description,
            'photo' => null,
        ]);
    }

    public function testGetProducts()
    {
        $this->actingAsRandomUser();
        $product = Product::factory()->create([
            'name' => 'Turkey Dress',
        ]);
        $variant1 = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Green Dress',
            'quantity' => 10,
        ]);
        $variant2 = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Pink Dress',
            'quantity' => 3,
        ]);
        $variant8 = ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Maroon',
            'quantity' => 0,
        ]);
        $product1 = Product::factory()->create([
            'name' => 'Roman Dress',
        ]);
        $variant4 = ProductVariant::create([
            'product_id' => $product1->id,
            'name' => 'Metallic Dress',
            'quantity' => 20,
        ]);
        $variant5 = ProductVariant::create([
            'product_id' => $product1->id,
            'name' => 'Arrow Dress',
            'quantity' => 7,
        ]);
        $variant6 = ProductVariant::create([
            'product_id' => $product1->id,
            'variant_id' => $variant5->id,
            'name' => 'Spear',
            'quantity' => 7,
        ]);
        $product2 = Product::factory()->create([
            'name' => 'Skater Dress',
        ]);
        $variant7 = ProductVariant::create([
            'product_id' => $product2->id,
            'name' => 'Yellow',
            'quantity' => 0,
        ]);

        $response = $this->get(route('v1.product.index'))->assertOk();

        $response->assertStatus(200)->assertJson([
            'data' => [
                [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => round($product->price, 3),
                    'description' => $product->description,
                    'photo' => null,
                    'product_variants' => [
                        [
                            'id' => $variant1->id,
                            'product_id' => $product->id,
                            'name' => 'Green Dress',
                            'quantity' => 10,
                        ],
                        [
                            'id' => $variant2->id,
                            'product_id' => $product->id,
                            'name' => 'Pink Dress',
                            'quantity' => 3,
                        ],
                        [
                            'id' => $variant8->id,
                            'product_id' => $product->id,
                            'name' => 'Maroon',
                            'quantity' => 0,
                        ],
                    ],

                ],
                [
                    'id' => $product1->id,
                    'name' => $product1->name,
                    'slug' => $product1->slug,
                    'price' => round($product1->price, 1),
                    'description' => $product1->description,
                    'photo' => null,
                    'product_variants' => [
                        [
                            'id' => $variant4->id,
                            'product_id' => $product1->id,
                            'name' => 'Metallic Dress',
                            'quantity' => 20,
                        ],
                        [
                            'id' => $variant5->id,
                            'product_id' => $product1->id,
                            'name' => 'Arrow Dress',
                            'quantity' => 7,
                            'variants' => [
                                [
                                    'id' => $variant6->id,
                                    'product_id' => $product1->id,
                                    'variant_id' => $variant5->id,
                                    'name' => 'Spear',
                                    'quantity' => 7,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'total' => 2,
        ]);
    }

    public function testSearchProducts()
    {
        $this->actingAsRandomUser();
        $product = Product::factory()->create();
        $product1 = Product::factory()->create();

        $response = $this->get(route('v1.product.index', ['query' => $product1->name]))->assertOk();

        $response->assertStatus(200)->assertJson([
            'data' => [
                [
                    'id' => $product1->id,
                    'name' => $product1->name,
                    'slug' => $product1->slug,
                    'price' => $product1->price,
                    'description' => $product1->description,
                    'photo' => null,
                ],
            ],
            'total' => 1,
        ]);
    }
}
