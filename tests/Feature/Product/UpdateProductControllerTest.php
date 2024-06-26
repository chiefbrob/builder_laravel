<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateProductControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();

        Product::factory()->create();

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanUpdateProduct()
    {
        Storage::fake('local');
        $product = Product::factory()->create();
        $data = [
            'name' => 'Product Update',
            'price' => 800,
            'slug' => 'thiog-joy',
            'description' => 'Contents of an updated product',

        ];
        $data1 = [
            'name' => 'Product Update2',
            'slug' => 'this-is-an-update',
            'price' => 400,
            'description' => 'Contents of an updated product again!',

        ];
        $this->post(
            route(
                'v1.product.update',
                ['id' => $product->id]
            ),
            array_merge(
                $data,
                ['photo' => UploadedFile::fake()->image('profile.jpg')]
            )
        )->assertOk();

        $product->refresh();

        $oldImage = $product->photo;

        Storage::disk('local')
            ->assertExists('public/images/products/'.$oldImage);

        $this->post(
            route(
                'v1.product.update',
                ['id' => $product->id]
            ),
            array_merge(
                $data1,
                ['photo' => UploadedFile::fake()->image('new.jpg')]
            )
        )->assertOk();

        $product->refresh();

        Storage::disk('local')
            ->assertExists('public/images/products/'.$product->default_image);
        Storage::disk('local')->assertMissing("public/images/products/$oldImage");
    }

    public function testUpdateCategories() {

        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $data = [
            'name' => 'Product Update',
            'price' => 800,
            'slug' => 'thiog-joy',
            'description' => 'Contents of an updated product',
            'categories' => [$category->id]
        ];

       
        $this->post(
            route(
                'v1.product.update',
                ['id' => $product->id]
            ),
           $data
        )->assertOk()
        ->assertJson([
            'product_categories' => [
                [
                    'category_id' => $category->id,
                    'product_id' => $product->id,
                    'category' => [
                        'name' => $category->name,
                    ]
                ]
            ]
        ]);

        $product->refresh();

        $this->assertDatabaseHas('product_categories', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);

        $category1 = Category::factory()->create();
        $data['categories'] = [$category->id, $category1->id];

        $this->post(
            route(
                'v1.product.update',
                ['id' => $product->id]
            ),
           $data
        )->assertJson([
            'product_categories' => [
                [
                    'category_id' => $category->id,
                    'product_id' => $product->id,
                    'category' => [
                        'name' => $category->name,
                    ]
                ],
                [
                    'category_id' => $category1->id,
                    'product_id' => $product->id,
                    'category' => [
                        'name' => $category1->name,
                    ]
                ],

            ]
        ]);

        $this->assertDatabaseHas('product_categories', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('product_categories', [
            'product_id' => $product->id,
            'category_id' => $category1->id,
        ]);

    }
}
