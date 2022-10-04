<?php

namespace Tests\Feature\Blog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateBlogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanCreateBlog()
    {
        Storage::fake('local');
        $response = $this->post(route('v1.blog.create'), [
            'title' => 'New Blog',
            'subtitle' => 'this is a new blog',
            'user_id' => $this->user->id,
            'contents' => 'Contents of a special blog',
            'default_image' => UploadedFile::fake()->image('profile.jpg'),
            'blog_category_id' => 1,
        ])->assertCreated();

        $blog = $response->baseResponse->original->toArray();

        unset($blog['created_at']);
        unset($blog['updated_at']);

        $this->assertDatabaseHas('blogs', $blog);

        Storage::disk('local')
            ->assertExists('public/images/blog/'.$blog['default_image']);
    }
}
