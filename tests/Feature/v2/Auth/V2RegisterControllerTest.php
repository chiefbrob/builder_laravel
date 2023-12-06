<?php

namespace Tests\Feature\v2\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class V2RegisterControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testCanRegisterViaApi(): void
    {
        $data = [
            'name' => 'john doe',
            'email' => 'jon.doe@example.com',
        ];
        
        $this->post(
            route(
                'v2.register', 
                array_merge($data, ['password' => 'password123'])
            )
        )
            ->assertCreated()
            ->assertJson($data);
        
        $this->assertDatabaseHas('users', $data);

        $this->post(route('v2.login', [
            'email' => $data['email'],
            'password' => 'password123'
        ]))->assertOk()
        ->assertJsonStructure([
            'access_token',
            'token_type',
            'user' => [
                'id',
                'username',
                'name',
            ]
        ]);
    }
}
