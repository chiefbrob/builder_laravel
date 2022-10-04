<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDeleteUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminSoftDeleteUser()
    {
        $this->actingAsAdmin();
        $user = User::factory()->create();
        $this->assertCount(2, User::all());
        $this->delete(route('admin.users.delete', [
            'user_id' => $user->id,
        ]))->assertStatus(200);
        $this->assertCount(1, User::all());
        $this->assertDatabaseCount('users', 2);
    }
}
