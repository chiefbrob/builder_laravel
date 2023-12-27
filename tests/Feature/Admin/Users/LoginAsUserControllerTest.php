<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Tests\TestCase;

class LoginAsUserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanLoginAsAnyOtherUser()
    {
        $this->actingAsAdmin();

        $this->get(route('admin.users'))->assertOk();

        $user = User::factory()->create();

        $this->post(route('v1.admin.users.loginAs', ['user_id' => $user->id]))
            ->assertOk()
            ->assertJson(['message' => 'Account Switch success']);

        $this->get(route('admin.users'))->assertForbidden();
    }
}
