<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserProfileUpdateControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateUserProfile()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'name' => 'Mark',
            'phone_number' => 323232332383
        ]);
        $this->actingAs($user);
        $this->patch(route('v1.user.update', ['user_id' => $user->id,]), [
            'name' => 'Makori',
            'phone_number' => 3232423233
        ])->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => 'Makori',
            'phone_number' => 3232423233,
            'phone_number_verified_at' => null
        ]);
    }
}
