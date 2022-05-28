<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateProductControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();

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
            'slug'  => 'thiog-joy',
            'description' => 'Contents of an updated product',
        
        ];
        $data1 = [
            'name' => 'Product Update2',
            'slug'  => 'this-is-an-update',
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
            ->assertExists("public/images/products/".$oldImage);


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
            ->assertExists("public/images/products/".$product->default_image);
        Storage::disk('local')->assertMissing("public/images/products/$oldImage");
    }
}
