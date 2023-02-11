<?php

namespace Tests\Feature\Team;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamIndexControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFetchTeamDetails()
    {
        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();
        $user4 = User::factory()->create();
        $user5 = User::factory()->create();
        $user6 = User::factory()->create();


        $team1->addUser($user1);
        $team1->addUser($user2);
        $team1->addUser($user3);

        $team2->addUser($user1);
        $team2->addUser($user3);
        $team2->addUser($user4);
        $team2->addUser($user5);

        $this->assertCount(3, $team1->teamUsers);
        $this->assertCount(4, $team2->teamUsers);

        $this->actingAs($user1)->get(route('v1.teams.index', ['team_id' => $team1->id]))
            ->assertOk()
            ->assertjson(
                [
                    'id' => $team1->id,
                    'name' => $team1->name,
                    'description' => $team1->description,
                    'email' => $team1->email,
                    'team_users' => [
                        [
                            'user_id' => $user1->id,
                            'user' => [
                                'name' => $user1->name
                            ]
                        ],
                        [
                            'user_id' => $user2->id,
                            'user' => [
                                'name' => $user2->name
                            ]
                        ],
                        [
                            'user_id' => $user3->id,
                            'user' => [
                                'name' => $user3->name
                            ]
                        ]
                    ]
                ]
            );

        $this->actingAs($user5)->get(route('v1.teams.index', ['team_id' => $team1->id]))
            ->assertUnprocessable();

        $this->actingAsAdmin()->get(route('v1.teams.index', ['team_id' => $team2->id]))
            ->assertOk()
            ->assertjson(
                [
                    'id' => $team2->id,
                    'name' => $team2->name,
                    'description' => $team2->description,
                    'email' => $team2->email,
                    'team_users' => [
                        [
                            'user_id' => $user1->id,
                            'user' => [
                                'name' => $user1->name
                            ]
                        ],
                        [
                            'user_id' => $user3->id,
                            'user' => [
                                'name' => $user3->name
                            ]
                        ],
                        [
                            'user_id' => $user4->id,
                            'user' => [
                                'name' => $user4->name
                            ]
                        ]
                    ]
                ]
            );

    }

    public function testGetListOfTeams()
    {
        $user = User::factory()->create();
        $team1 = Team::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        $team2 = Team::factory()->create();

        $user1 = User::factory()->create();

        $team1->addUser($user);
        $team1->addUser($user1);



        $this->actingAs($user1)->get(route('v1.teams.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson(
                [
                    'data' => [
                        [
                            'id' => $team1->id,
                            'name' => $team1->name,
                            'email' => $team1->email,
                        ]
                    ],
                    'total' => 1
                ]
            );
        $this->actingAs($user1)->get(route('v1.teams.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson(
                [
                    'data' => [
                        [
                            'id' => $team1->id,
                            'name' => $team1->name,
                        ]
                    ],
                    'total' => 1
                ]
            );
        $this->actingAsRandomUser()->get(route('v1.teams.index'))
            ->assertOk()
            ->assertJsonCount(0, 'data');

        $this->actingAsAdmin()->get(route('v1.teams.index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJson(
                [
                    'data' => [
                        [
                            'id' => $team2->id,
                            'name' => $team2->name,
                        ],
                        [
                            'id' => $team1->id,
                            'name' => $team1->name,
                        ]
                    ],
                    'total' => 2
                ]
            );

        $this->actingAsAdmin()->get(route('v1.teams.index', ['admin' => true]))
            ->assertOk()
            ->assertJsonCount(0, 'data');


        $this->actingAs($user)->get(route('v1.teams.index', ['admin' => true]))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson(
                [
                    'data' => [
                        [
                            'id' => $team1->id,
                            'name' => $team1->name,
                            'user_id' => $user->id
                        ]
                    ],
                    'total' => 1
                ]
            );

        $this->actingAs($user1)->get(route('v1.teams.index', ['admin' => true]))
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

}
