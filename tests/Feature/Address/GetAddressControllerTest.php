<?php

namespace Tests\Feature\Address;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAddressControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCanGetMyAddresses(): void
    {
        $this->actingAsRandomUser();
        $address1 = Address::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $address2 = Address::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $address3 = Address::factory()->create();

        $this->get(route('v1.address.index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => [
                    ['id' => $address2->id],
                    ['id' => $address1->id],
                ]
            ]);

    }
}
