<?php

namespace Tests\Feature\User;

use Carbon\Traits\Date;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDeactivateControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserSelfDeactivateProfile()
    {
        $this->actingAsRandomUser();
        $this->delete(route('v1.user.delete', ['user_id' => $this->user->id]))->assertOk();
        $this->user->refresh();
        $this->assertNotNull($this->user->deactivated_at);
    }
}
