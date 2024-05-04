<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsIndexControllerTest extends TestCase
{

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
        $variant1 = ProductVariant::factory()->create([
            'product_id' => $product->id,
            'name' => 'Green Dress',
            'quantity' => 10,
        ]);
        $variant2 = ProductVariant::factory()->create([
            'product_id' => $product->id,
            'name' => 'Pink Dress',
            'quantity' => 3,
        ]);
        $variant8 = ProductVariant::factory()->create([
            'product_id' => $product->id,
            'name' => 'Maroon',
            'quantity' => 0,
        ]);
        $product1 = Product::factory()->create([
            'name' => 'Roman Dress',
        ]);
        $variant4 = ProductVariant::factory()->create([
            'product_id' => $product1->id,
            'name' => 'Metallic Dress',
            'quantity' => 20,
        ]);
        $variant5 = ProductVariant::factory()->create([
            'product_id' => $product1->id,
            'name' => 'Arrow Dress',
            'quantity' => 7,
        ]);
        $variant6 = ProductVariant::factory()->create([
            'product_id' => $product1->id,
            'variant_id' => $variant5->id,
            'name' => 'Spear',
            'quantity' => 7,
        ]);
        $product2 = Product::factory()->create([
            'name' => 'Skater Dress',
        ]);
        $variant7 = ProductVariant::factory()->create([
            'product_id' => $product2->id,
            'name' => 'Yellow',
            'quantity' => 0,
        ]);

        $response = $this->get(route('v1.product.index'))->assertOk();

        $response->assertStatus(200)->assertJson([
            'data' => [
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

    public function testFeaturedProducts()
    {
        
        $this->actingAsRandomUser();
        $product = Product::factory()->create(['featured'=> false]);
        $variant1 = ProductVariant::factory()->create([
            'product_id' => $product->id,
            'name' => 'Green Dress',
            'quantity' => 10,
        ]);
        $variant2 = ProductVariant::factory()->create([
            'product_id' => $product->id,
            'name' => 'Pink Dress',
            'quantity' => 3,
        ]);

        $product1 = Product::factory()->create(['featured' => true]);

        $variant1 = ProductVariant::factory()->create([
            'product_id' => $product1->id,
            'name' => 'Red Dress',
            'quantity' => 19,
        ]);
        $variant2 = ProductVariant::factory()->create([
            'product_id' => $product1->id,
            'name' => 'Black Dress',
            'quantity' => 30,
        ]);

        $product2 = Product::factory()->create(['featured' => false]);
        $variant1 = ProductVariant::factory()->create([
            'product_id' => $product2->id,
            'name' => 'Maroon Dress',
            'quantity' => 60,
        ]);
        $variant2 = ProductVariant::factory()->create([
            'product_id' => $product2->id,
            'name' => 'Teal Dress',
            'quantity' => 13,
        ]);

        // dd(Product::where('featured', true)->count());

        $this->get(route('v1.product.index', ['featured' => true]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson(
                [
                    'data' => [
                        [
                            'id' => $product1->id
                        ]
                    ]
                ]
            );

    }

    public function testProductCategory()
    {
        $this->actingAsRandomUser();
        $product = Product::factory()->create();

        $productCat = ProductCategory::factory()->create(['product_id' => $product->id]);

        $response = $this->get(route('v1.product.index', ['id' => $product->id]))->assertOk();

        $response->assertStatus(200)->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'description' => $product->description,
            'photo' => null,
            'product_categories' => [
                [
                    'id' => $productCat->id,
                    'product_id' => $product->id,
                    'category_id' => $productCat->category_id,
                    'category' => [
                        'name' => $productCat->category->name
                    ]
                ]
            ]
        ]);
    }
}
