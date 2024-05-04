<?php

namespace Tests\Feature\Admin\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminUpdateCategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUpdateACategory(): void
    {
        $this->actingAsAdmin();

        $this->post(route('v1.admin.categories.create'), ['name' => 'Loremp ipsum'])
            ->assertCreated();

        $category = Category::where('slug', 'loremp-ipsum')->firstOrFail();

        $data = ['name' => 'Foo bar', 'slug' => 'foo-bar'];

        $this->put(route('v1.admin.categories.update', ['category_id' => $category->id]), $data)
            ->assertOk()
            ->assertJson($data);
            
        $this->assertDatabaseHas('categories', $data);

        $this->assertDatabaseMissing('categories',  ['name' => 'Loremp ipsum']);
    }
}
