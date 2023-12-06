<?php

namespace Tests\Feature\Address;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteAddressControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testDeleteAddress(): void
    {
        $data = [
            'first_name' => 'moi junio',
            'street_address' => 'foo bar xim',
        ];
        $this->actingAsRandomUser()
            ->post(route('v1.address.store'), $data)
            ->assertCreated()
            ->assertJson($data);

            

        $address = Address::first();

        $this->user->refresh();

        $this->assertEquals($this->user->default_address_id, $address->id);

        $response = $this->actingAs($address->user)
            ->delete(route('v1.address.delete', ['address_id' => $address->id]))
            ->assertOk()
            ->assertJson(['message' => 'Address Deleted']);

        $address->refresh();
        $this->user->refresh();

        $this->assertNull($this->user->default_address_id);

        $address->user->refresh();

        $this->assertNotNull($address->deleted_at);
    }
}
