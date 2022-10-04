<?php

namespace Tests\Feature\Blog;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogDeleteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSoftDeletesBlog()
    {
        $this->actingAsAdmin();
        $blog = Blog::factory()->create();
        $this->get(route('v1.blog.index'))
            ->assertOk()->assertJsonCount(1, 'data');
        $this->delete(route('v1.blog.delete', ['id' => $blog->id]))->assertOk();

        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id,
        ]);

        $this->get(route('v1.blog.index'))
            ->assertOk()->assertJsonCount(0, 'data');
    }
}
