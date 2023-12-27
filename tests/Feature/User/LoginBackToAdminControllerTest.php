<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class LoginBackToAdminControllerTest extends TestCase
{
    public function testAdminCanLoginToAnyUserAccountAndGoback()
    {
        $this->actingAsAdmin();

        $user = User::factory()->create();

        $this->post(route('v1.admin.users.loginAs', ['user_id' => $user->id]))->assertOk();

        $this->get(route('admin.users'))->assertForbidden();

        $this->post(route('v1.user.loginBackToAdmin', ['admin' => true]))
            ->assertOk()
            ->assertJson([
                'message' => 'Login back to admin success',
            ]);

        $this->get(route('admin.users'))->assertOk();
    }
}
