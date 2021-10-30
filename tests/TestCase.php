<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Logs in a random user into the application.
     * @param  array  $attributes
     *
     * @return $this
     */
    public function actingAsRandomUser(array $attributes = [])
    {
        return $this->actingAs(User::factory()->create($attributes));
    }

    /**
     * Logs in a admin into the application.
     * @param  array  $attributes
     *
     * @return $this
     */
    public function actingAsAdmin(array $attributes = [])
    {
        $admin = User::factory()->create($attributes);
        $role = Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole($role);
        return $this->actingAs($admin);
    }
}
