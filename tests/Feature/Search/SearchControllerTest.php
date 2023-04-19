<?php

namespace Tests\Feature\Search;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    private Blog $blog1;
    private Blog $blog2;

    private Team $team1;
    private Team $team2;

    private Task $task1;
    private Task $task2;

    private Product $product1;
    private Product $product2;

    public function setUp(): void
    {
        parent::setUp();
        $this->blog1 = Blog::factory()->create([
            'title' => 'ABC DEF GHK'
        ]);

        $this->blog2 = Blog::factory()->create([
            'title' => 'Another Blog'
        ]);

        $this->team1 = Team::factory()->create([
            'name' => 'Team ABC'
        ]);

        $this->team2 = Team::factory()->create([
            'name' => 'Team DEF GHK'
        ]);

        $this->product1 = Product::factory()->create([
            'name' => 'Product ABC'
        ]);

        $this->product2 = Product::factory()->create([
            'name' => 'New Product'
        ]);

        $this->task1 = Task::factory()->create([
            'title' => 'Task ABCDEF'
        ]);

        $this->task2 = Task::factory()->create([
            'title' => 'New Task'
        ]);

    }
    /**
     * A basic feature test example.
     */
    public function testGuestCanSearch(): void
    {
        $this->post(route('v1.search', ['query' => 'ABC']))
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonCount(1, 'products')
            ->assertJsonCount(1, 'blogs')
            ->assertJson([
                'products' => [
                    [
                        'id' => $this->product1->id,
                        'name' => $this->product1->name,
                    ]
                ],
                'blogs' => [
                    [
                        'id' => $this->blog1->id,
                        'title' =>  $this->blog1->title,
                    ]
                ],
            ]);
    }

    public function testLoggedUserSearch(): void
    {
        $this->actingAsRandomUser();
        $this->team1->addUser($this->user);
        $this->task1->team->addUser($this->user);
        $this->post(route('v1.search', ['query' => 'ABC']))
            ->assertOk()
            ->assertJsonCount(4)
            ->assertJsonCount(1, 'products')
            ->assertJsonCount(1, 'blogs')
            ->assertJsonCount(1, 'teams')
            ->assertJsonCount(1, 'tasks')
            ->assertJson([
                'products' => [
                    [
                        'id' => $this->product1->id,
                        'name' => $this->product1->name,
                    ]
                ],
                'blogs' => [
                    [
                        'id' => $this->blog1->id,
                        'title' =>  $this->blog1->title,
                    ]
                ],
                'teams' => [
                    [
                        'id' => $this->team1->id,
                        'name' => $this->team1->name,
                    ]
                ],
                'tasks' => [
                    [
                        'id' => $this->task1->id,
                        'title' => $this->task1->title
                    ]
                ]
            ]);
    }

    public function testLoggedUserSearchNoAccess(): void
    {
        $this->actingAsRandomUser();
        $this->post(route('v1.search', ['query' => 'ABC']))
            ->assertOk()
            ->assertJsonCount(4)
            ->assertJsonCount(1, 'products')
            ->assertJsonCount(1, 'blogs')
            ->assertJsonCount(0, 'teams')
            ->assertJsonCount(0, 'tasks')
            ->assertJson([
                'products' => [
                    [
                        'id' => $this->product1->id,
                        'name' => $this->product1->name,
                    ]
                ],
                'blogs' => [
                    [
                        'id' => $this->blog1->id,
                        'title' =>  $this->blog1->title,
                    ]
                ],
                'teams' => [],
                'tasks' => []
            ]);
    }
}
