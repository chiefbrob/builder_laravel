<?php

namespace Tests\Feature\Admin\Categories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminCreateCategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testAdminCreateCategory(): void
    {
        $this->actingAsAdmin();
        
        $data = [
            'name' => 'Foodstuff meals 123',
            'slug' => 'foodstuff-meals-123'
        ];

        $this->post(route('v1.admin.categories.create'), ['name' => 'Foodstuff meals 123'])
            ->assertCreated()
            ->assertJson($data);

        $this->assertDatabaseHas('categories', $data);
    }
}

