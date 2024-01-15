<?php

namespace Tests\Feature\v2\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class V2UserProfileUpdateControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testUpdateProfile(): void
    {
        $oldData = [
            'name' => 'john snow',
            'username' => 'jon.snow',
            'phone_number' => '25478392032'
        ];

        $this->actingAsRandomApiUser($oldData);

        $newData = [
            'name' => 'mac doe',
            'username' => 'mac.doe',
            'phone_number' => '255729393203',
        ];

        $this->post(route('v2.user.update', $newData))->assertOk()
            ->assertJson($newData);

        $this->assertDatabaseHas('users', $newData);
        $this->assertDatabaseMissing('users', $oldData);

    }
}
