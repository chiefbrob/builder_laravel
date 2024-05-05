<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCategoriesControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testListProductCats(): void
    {
        $cat = Category::factory()->create(['name' => 'Xoo bar']);
        $cat1 = Category::factory()->create(['name' => 'Fim xi']);


        $this->get(route('v1.categories.index'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => $cat1->id,
                        'name' => $cat1->name,
                        'slug' => $cat1->slug
                    ],
                    [
                        'id' => $cat->id,
                        'name' => $cat->name,
                        'slug' => $cat->slug
                    ]
                ]
            ]);

    }
}
