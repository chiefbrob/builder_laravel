<?php

namespace Tests\Feature\v2\Contact;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class V2GetContactsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testApiGetMyContacts(): void
    {
        $this->actingAsRandomApiUser();

        $this->post(route('v1.contact.create'), [
            'title' => '422 Error',
            'email' => $this->user->email,
        ])->assertCreated();

        $this->get(route('v2.contact.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson(['data' => [
                [
                    'title' => '422 Error'
                ]
            ]]);
    }
}
