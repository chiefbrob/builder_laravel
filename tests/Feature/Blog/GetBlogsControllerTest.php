<?php

namespace Tests\Feature\Blog;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetBlogsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanViewBlogs()
    {
        $blog = Blog::factory()->create();
        $response = $this->get(route('v1.blog.index'))->assertOk()->assertJsonCount(1, 'data')
            ->assertJson(['data' => [
                [
                    'id' => $blog->id,
                ],
            ]]);

        $response->assertStatus(200);

        $response = $this->get(route('v1.blog.index', ['id' => $blog->id]))->assertOk()
            ->assertJson([
                'id' => $blog->id,
            ]);
    }
}
