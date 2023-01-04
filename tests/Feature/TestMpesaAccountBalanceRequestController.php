<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestMpesaAccountBalanceRequestController extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetMpesaBalance()
    {
        $this->actingAsAdmin();

        $this->get(route('v1.mpesa.balance'))->assertOk()
            ->assertJson(
                [
                    'balance' => 50.00,
                ]
            );

    }
}
