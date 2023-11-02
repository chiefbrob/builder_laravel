<?php

namespace Tests\Feature\Address;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateAddressControllerTest extends TestCase
{
    public Address $address;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAsRandomUser();

        $data = [
            'first_name' => 'John',
            'street_address' => 'Somewhere south'
        ];

        $this->post(route('v1.address.store'), $data)->assertCreated();

        $this->address = Address::first();
    }
    /**
     * A basic feature test example.
     */
    public function testUserUpdateAddress(): void
    {
        $newData = [
            'first_name' => 'Foo Bare',
            'street_address' => 'Somewhere south east'

        ];
        $this->put(
            route('v1.address.update', ['address_id' => $this->address->id]), 
            $newData
        )->assertOk()
            ->assertJson($newData);

        $this->assertDatabaseHas('addresses', $newData);
    }

    public function testAnotherUserCannotUpdateYourAddresses()
    {
        $user2 = User::factory()->create();

        $newData = [
            'first_name' => 'Foo OBare',
            'street_address' => 'Somewhere north east'

        ];

        $this->actingAs($user2)
            ->put(
                route('v1.address.update', ['address_id' => $this->address->id]), 
                $newData
            )
            ->assertUnprocessable();

        $this->assertDatabaseMissing('addresses', $newData);
    }
}
