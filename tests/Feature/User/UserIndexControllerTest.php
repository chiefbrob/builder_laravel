<?php

namespace Tests\Feature\User;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserIndexControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFetchUsersNotInTeam()
    {

        $user = User::factory()->create(['name' => 'Mathew']);
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();



        $this->assignRole($user, 'manager');
        $this->assignRole($user3, 'admin');

        $team = Team::create(
            [
                'user_id' => $user->id,
                'name' => 'FooTeam',
                'email'=> 'sage@mail.com'
            ]
        );

        $team->addUser($user);

        $this->actingAs($user)->get(route('v1.user.index', ['team_id' => $team->id]))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $user2->id,
                    ],
                    [
                        'id' => $user3->id,
                    ]
                ]
            ]);

        $this->actingAs($user3)->get(route('v1.user.index', ['team_id' => $team->id]))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $user2->id,
                    ],
                    [
                        'id' => $user3->id,
                    ]
                ]
            ]);

        $this->actingAs($user2)->get(route('v1.user.index', ['team_id' => $team->id]))
            ->assertForbidden();
    }
}
