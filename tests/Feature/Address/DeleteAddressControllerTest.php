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
        $address = Address::factory()->create();
        $this->actingAs($address->user)
            ->delete(route('v1.address.delete', ['address_id' => $address->id]))
            ->assertOk()
            ->assertJson(['message' => 'Address Deleted']);

        $address->refresh();

        $this->assertNotNull($address->deleted_at);
    }
}
