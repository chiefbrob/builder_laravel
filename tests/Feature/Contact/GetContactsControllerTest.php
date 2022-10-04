<?php

namespace Tests\Feature\Contact;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetContactsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Contact::create(
            [
                'title' => 'foo title',
                'email' => 'foo@ar.com',
                'phone_number' => '254782329233',
                'user_id' => User::factory()->create()->id,
                'contents' => 'just a test',
                'status' => Contact::STATUS_IN_PROGRESS,
            ]
        );
    }

    public function testAdminGetAllContacts()
    {
        $this->actingAsAdmin();
        $this->post(route('v1.contact.create'), [
            'title' => 'Similar Error',
            'contents' => 'fix this too',
            'url' => 'xim.bar',
        ])->assertCreated();

        $this->get(route('v1.contact.index', [
            'statuses' => ['PENDING', 'IN_PROGRESS'],
        ]))
            ->assertOk()
            ->assertJson([
                'total' => 2,
                'data' => [
                    [
                        'title' => 'Similar Error',
                    ],
                    [
                        'title' => 'foo title',
                    ],
                ],
            ]);

        $this->get(route('v1.contact.index', [
            'statuses' => ['IN_PROGRESS'],
        ]))
            ->assertOk()
            ->assertJson([
                'total' => 1,
                'data' => [
                    [
                        'title' => 'foo title',
                    ],
                ],
            ]);
    }

    public function testUserGetsOnlyTheirContacts()
    {
        $this->actingAsRandomUser();

        $this->post(route('v1.contact.create'), [
            'title' => 'Eg Error',
            'contents' => 'fix this',
            'url' => 'foo.bar',
        ])->assertCreated();

        $this->post(route('v1.contact.create'), [
            'title' => 'Similar Error',
            'contents' => 'fix this too',
            'url' => 'xim.bar',
        ])->assertCreated();

        $this->get(route('v1.contact.index'))
            ->assertOk()
            ->assertJson([
                'total' => 2,
                'data' => [
                    [
                        'title' => 'Similar Error',
                    ],
                    [
                        'title' => 'Eg Error',
                    ],
                ],
            ]);
    }
}
