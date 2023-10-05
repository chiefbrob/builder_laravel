<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;
    use CreatesApplication;

    public $user;

    /**
     * Logs in a random user into the application.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function actingAsRandomUser(array $attributes = [])
    {
        $this->user = User::factory()->create($attributes);

        return $this->actingAs($this->user);
    }

    /**
     * Logs in a admin into the application.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function actingAsAdmin(array $attributes = [])
    {
        $admin = User::factory()->create($attributes);
        $role = Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole($role);
        $this->user = $admin;

        return $this->actingAs($admin);
    }

    public function assignRole(User $user, string $role)
    {
        $role = Role::firstOrCreate(['name' => $role]);
        $userRole = UserRole::firstOrCreate(
            [
                'user_id' => $user->id,
                'role_id' => $role->id
            ]
        );
        return $userRole;
    }

    public function roundUpToAny($n, $x=5)
    {
        return (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
    }

    public function actingAsRandomApiUser(array $attributes = [])
    {
        $this->user = User::factory()->create($attributes);


        $tokenResult = $this->user->createToken('Personal Access Token');

        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(4);

        $token->save();

        $this->withHeader('Authorization', 'Bearer ' . $tokenResult->accessToken);
    }
}
