<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Todo;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test todos index api response
     */
    public function test_todos_index_api(): void
    {
        $user = User::factory()->create();
        Todo::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/todos');
        $response->assertOk();

        $response->assertJsonCount(5, 'data');
    }

    /**
     * Test todos store api
     */
    public function test_todos_store_api(): void
    {
        $user = User::factory()->create();
        $todoData = ['description' => 'Test Todo', 'is_completed' => false];

        $response = $this->actingAs($user)->postJson('/api/todos', $todoData);
        $response->assertCreated();

        $this->assertDatabaseHas('todos', ['description' => 'Test Todo']);
    }

    /**
     * Test todos show api
     */
    public function test_todos_show_json_data()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson("/todos/{$todo->id}");
        $response->assertOk();

        $response->assertJson(['id' => $todo->id]);
    }

    /**
     * Test todos update api
     */
    public function test_todos_update_api()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);
        $updatedData = ['is_completed' => true];

        $response = $this->actingAs($user)->putJson("/api/todos/{$todo->id}", $updatedData);
        $response->assertOk();

        $this->assertDatabaseHas('todos', ['id' => $todo->id, 'is_completed' => true]);
    }

    /**
     * Test todos destroy api
     */
    public function test_todos_destroy_api()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/api/todos/{$todo->id}");
        $response->assertOk();

        $this->assertModelMissing($todo);
    }
}
