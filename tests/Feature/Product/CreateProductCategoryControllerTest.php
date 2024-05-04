<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductCategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateProductVariant(): void
    {
        $this->actingAsAdmin();

        $product = Product::factory()->create();

        $category = Category::factory()->create();

        $data = ['product_id' => $product->id, 'category_id' => $category->id];

        $this->post(route('v1.product-categories.create'), $data)
            ->assertCreated()
            ->assertJson($data);

        $this->assertDatabaseHas('product_categories', $data);
    }
}
