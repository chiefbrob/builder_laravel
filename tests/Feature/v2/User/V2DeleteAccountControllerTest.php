<?php

namespace Tests\Feature\v2\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class V2DeleteAccountControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    public function testApiDeleteUser(): void
    {
        $this->actingAsRandomApiUser();

        $this->delete(route('v2.user.delete'))
            ->assertOk();

        $this->user->refresh();

        $this->assertNotNull($this->user->deleted_at);
    }
}
