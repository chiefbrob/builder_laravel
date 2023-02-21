<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateContactControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminChangeStatus()
    {
        $this->post(route('v1.contact.create', [
            'title' => 'Example1',
            'email' => 'someone@some.com'
        ]))->assertCreated();


        $contact = Contact::where('title', 'Example1')->first();

        $this->actingAsRandomUser()
            ->put(route('v1.contact.update', [
                'status' => Contact::STATUS_COMPLETE,
                'contact_id' => $contact->id,
            ]))->assertForbidden();

        $this->actingAsAdmin()
            ->put(route('v1.contact.update', [
                'status' => Contact::STATUS_COMPLETE,
                'contact_id' => $contact->id,
            ]))->assertOk()
                ->assertJson([
                    'title' => 'Example1',
                    'status' => Contact::STATUS_COMPLETE
                ]);
    }
}
