<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class TestStatefulApi extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStatefulApiWorks()
    {
        $this->actingAs(User::factory()->create());
        $this->get(route('v1.status'))->assertOk()->assertJson(['status' => 'OK']);
    }
}
