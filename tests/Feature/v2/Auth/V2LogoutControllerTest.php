<?php

namespace Tests\Feature\v2\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class V2LogoutControllerTest extends TestCase
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
    public function testLogoutUser()
    {
        $this->actingAsRandomApiUser();

        $this->post(route('v2.logout'))
            ->assertOk()
            ->assertJson(['message' => 'logged out']);
    }
}
