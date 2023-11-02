<?php

namespace Tests\Feature\Address;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateAddressControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateAddress(): void
    {
        $this->actingAsRandomUser();
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'street_address' => 'Foo bar 04.48',
            'street_address_2' => 'abcd',
            'country' => 'Kenya',
            'city' => 'Nairobi',
            'county' => 'Nairobi',
            'post_code' => '00100',
            'phone_number' => '254722222222',
        ];
        $response = $this->post(route('v1.address.store'), $data)
            ->assertCreated()
            ->assertJson($data);

        $this->user->refresh();

        $this->assertNotNull($this->user->defaultAddress);

        $address_id = $response->baseResponse->original['id'];

        $this->assertEquals($this->user->default_address_id, $address_id);

        $this->assertDatabaseHas('addresses', $data);

        $data2 = [
            'first_name' => 'Foo',
            'street_address' => 'Bar foo xim'
        ];

        $response = $this->post(route('v1.address.store'), $data2)
            ->assertCreated()
            ->assertJson($data2);

        $address_id = $response->baseResponse->original['id'];

        $this->assertNotEquals($this->user->default_address_id, $address_id);
    }
    
}
