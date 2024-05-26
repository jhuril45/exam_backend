<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function testNewTaskMutation(): void
    {
        $this->assertTrue(true);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/graphql', [
            'query' => '
                mutation ($title: String!, $description: String, $status: String!) {
                    createTask(title: $title, description: $description, status: $status) {
                    id
                    title
                    description
                    status
                    }
                }
            ',
            'variables' => [
                'title' => 'Hello, GraphQL!',
                'description' => 'Hello, GraphQL!',
                'status' => 'todo'
            ]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Hello, GraphQL!',
            'user_id' => $user->id,
            'description' => 'Hello, GraphQL!',
            'status' => 'todo'
        ]);
    }

}
