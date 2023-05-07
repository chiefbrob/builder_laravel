<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewLoginPage()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('home');
    }

    public function testUserCannotViewLoginPageWhenLoggedIn()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    public function testLoginWithCorrectCredentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function testCannotLoginWithWrongPassword()
    {
        $user = User::factory()->create([
            'password' => Hash::make('i-love-laravel'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'username' => $user->username,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function testDeactivatedAccountsActivatedAfterLogin()
    {
        $user = User::factory()->create([
            'password' => Hash::make($password = 'i-love-laravel'),
        ]);

        $user->deactivated_at = now();

        $user->save();

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        $user->refresh();

        $this->assertNull($user->deactivated_at);
    }
}
