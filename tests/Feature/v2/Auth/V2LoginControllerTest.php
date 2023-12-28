<?php

namespace Tests\Feature\v2\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class V2LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginGetToken()
    {
        $user = User::factory()->create();

        $user->password = Hash::make('password');
        $user->save();

        $this->post(route('v2.login', [
            'email' => $user->email,
            'password' => 'password'
        ]))->assertOk()
        ->assertJsonStructure([
            'access_token',
            'token_type',
            'user' => [
                'id',
                'username',
                'name',
                'email',
                'phone_number',
                'photo',
                'language',
                'details',
                'team_id',
                'addresses'
            ]
        ]);
    }

    public function testLoginInvalidPassword()
    {
        $user = User::factory()->create();

        $user->password = Hash::make('password');
        $user->save();

        $this->post(route('v2.login', [
            'email' => $user->email,
            'password' => 'passwords'
        ]))->assertUnprocessable();
    }
}
