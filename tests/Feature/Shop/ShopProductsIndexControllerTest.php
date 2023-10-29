<?php

namespace Tests\Feature\Shop;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopProductsIndexControllerTest extends TestCase
{
    public Product $product1;
    public Product $product2;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();

        $this->product1 = Product::factory()->create(['name' => 'efg']);
        $this->product2 = Product::factory()->create(['name' => 'abc']);

        $this->product2->delete();
    }
    /**
     * A basic feature test example.
     */
    public function testAdminCanGetAllProducts(): void
    {
        $this->get(route('v1.shop.products.index', ['deleted' => true]))->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->product2->id,
                    ],
                    [
                        'id' => $this->product1->id,
                    ]
                ]
            ]);

            $this->get(route('v1.shop.products.index'))->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->product1->id,
                    ]
                ]
            ]);
    }
}
