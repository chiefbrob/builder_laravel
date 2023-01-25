<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewRegisterPage()
    {
        $response = $this->get('/register');

        $response->assertSuccessful();
        $response->assertViewIs('home');
    }

    public function testUserCannotViewRegisterPageWhenLoggedIn()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/home');
    }

    public function testRegisterWithCorrectDetails()
    {
        $this->markTestIncomplete('registration failing');
        $email = 'peter@somewhere.com';

        $response = $this->post('/register', [
            'name' => 'Peter',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertCreated();

        $this->assertDatabaseHas('users',
            [
                'name' => 'Peter',
                'email' => 'peter@gmail.com',
            ]
        );

        $user = User::where('email', $email)->first();

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

}
