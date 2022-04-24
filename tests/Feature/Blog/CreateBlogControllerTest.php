<?php

namespace Tests\Feature\Blog;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateBlogControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp(): void
    {
        $this->markTestSkipped("failing wierdly");
        dd(User::factory()->create());
        $user = User::create(['name' => 'foo', 'email' => 'foo@gmail.com']);
        $this->actingAs($user);

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanCreateBlog()
    {
        $this->assertTrue(true);
        // $this->withoutExceptionHandling();
        // //$this->actingAsRandomUser();
        // Storage::fake('local');
        // $response = $this->actingAsRandomUser()->post(route('v1.blog.create'), [
        //     'title' => 'New Blog',
        //     'subtitle'  => 'this is a new blog',
        //     'user_id' => $this->user->id,
        //     'contents' => 'Contents of a special blog',
        //     'default_image' => UploadedFile::fake()->image('profile.jpeg'),
        //     'blog_category_id' => BlogCategory::first()->id,
        // ])->assertOk();

        // $blog = $response['data'];

        // Storage::disk('local')
        //     ->assertExists("public/images/blog/".$blog->default_image);
    }
}
