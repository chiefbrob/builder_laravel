<?php

namespace Tests\Feature\Blog;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateBlogControllerTest extends TestCase
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
    public function testAdminCanUpdateBlog()
    {
        Storage::fake('local');
        $blog = Blog::factory()->create();
        $data = [
            'title' => ' Blog Update',
            'subtitle'  => 'thiog joy',
            'user_id' => $this->user->id,
            'contents' => 'Contents of a new blog',
            
            'blog_category_id' => 1,
        ];
        $data1 = [
            'title' => ' Blog Update2',
            'subtitle'  => 'this is an update ',
            'user_id' => $this->user->id,
            'contents' => 'Contents of a coveted blog',
            
            'blog_category_id' => 1,
        ];
        $this->post(
            route(
                'v1.blog.update', 
                ['id' => $blog->id]
            ), 
            array_merge(
                $data, 
                ['default_image' => UploadedFile::fake()->image('profile.jpg')]
            )
        )->assertOk();

        $blog->refresh();

        $oldImage = $blog->default_image;

        Storage::disk('local')
            ->assertExists("public/images/blog/".$oldImage);


        $this->post(
            route(
                'v1.blog.update', 
                ['id' => $blog->id]
            ), 
            array_merge(
                $data1, 
                ['default_image' => UploadedFile::fake()->image('new.jpg')]
            )
        )->assertOk();

        $blog->refresh();

        // dd([$blog->default_image, $oldImage]);

        Storage::disk('local')
            ->assertExists("public/images/blog/".$blog->default_image);
        Storage::disk('local')->assertMissing("public/images/blog/$oldImage");
    }
}
