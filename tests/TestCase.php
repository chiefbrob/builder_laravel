<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
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
}
