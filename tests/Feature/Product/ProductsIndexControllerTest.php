<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            "id" => $product->id,
            "name" => $product->name,
            "slug" => $product->slug,
            "price" => $product->price,
            "description" => $product->description,
            "photo" => null,
        ]);
    }

    public function testGetProducts()
    {
        $this->actingAsRandomUser();
        $product = Product::factory()->create();
        $product1 = Product::factory()->create();

        $response = $this->get(route('v1.product.index'))->assertOk();

        $response->assertStatus(200)->assertJson([
            'data' => [
                [
                    "id" => $product->id,
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "price" => $product->price,
                    "description" => $product->description,
                    "photo" => null,
                ],
                [
                    "id" => $product1->id,
                    "name" => $product1->name,
                    "slug" => $product1->slug,
                    "price" => $product1->price,
                    "description" => $product1->description,
                    "photo" => null,
                ]
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
                    "id" => $product1->id,
                    "name" => $product1->name,
                    "slug" => $product1->slug,
                    "price" => $product1->price,
                    "description" => $product1->description,
                    "photo" => null,
                ]
                ],
                'total' => 1,
        ]);
    }
}
