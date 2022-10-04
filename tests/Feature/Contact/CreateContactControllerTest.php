<?php

namespace Tests\Feature\Contact;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanContactAdmins()
    {
        $this->post(route('v1.contact.create'), [
            'title' => '403 Error',
            'email' => 'jack@foobar.com',
        ])->assertCreated()->assertJson([
            'title' => '403 Error',
        ]);

        $this->assertDatabaseHas('contacts', [
            'title' => '403 Error',
            'email' => 'jack@foobar.com',
        ]);
    }

    public function testCanContactWithPhone()
    {
        $this->post(route('v1.contact.create'), [
            'title' => '404 Error',
            'phone_number' => '254739231873',
        ])->assertCreated()->assertJson([
            'title' => '404 Error',
        ]);

        $this->assertDatabaseHas('contacts', [
            'title' => '404 Error',
            'phone_number' => '254739231873',
        ]);
    }

    public function testCanContactWhenLoggedIn()
    {
        $this->actingAsRandomUser();
        $this->post(route('v1.contact.create'), [
            'title' => '404 Error',
            'contents' => 'sample contact',
            'url' => 'foo.bar',
        ])->assertCreated()->assertJson([
            'title' => '404 Error',
            'contents' => 'sample contact',
            'url' => 'foo.bar',
        ]);

        $this->assertDatabaseHas('contacts', [
            'title' => '404 Error',
            'contents' => 'sample contact',
            'url' => 'foo.bar',
        ]);
    }

    public function testImageUpload()
    {
        Storage::fake('local');

        $response = $this->post(route('v1.contact.create'), [
            'title' => 'Img Error',
            'default_image' => UploadedFile::fake()->image('avatar.jpg'),
            'phone_number' => '3442932932933',
        ])->assertCreated()->assertJson([
            'title' => 'Img Error',
            'phone_number' => '3442932932933',
        ]);

        $contact = $response->baseResponse->original->toArray();

        $this->assertDatabaseHas('contacts', [
            'title' => 'Img Error',
            'phone_number' => '3442932932933',
            'default_image' => $contact['default_image'],
        ]);

        Storage::disk('local')
            ->assertExists('public/images/contacts/'.$contact['default_image']);
    }
}
