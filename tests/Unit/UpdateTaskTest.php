<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class UpdateTaskTest extends TestCase
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


        $task = new Task();
        $task->title = 'title';
        $task->user_id = $user->id;
        $task->description ='description';
        $task->status = 'todo';
        $task->save();

        $response = $this->postJson('/graphql', [
            'query' => '
                mutation ($id: Int!, $title: String!, $description: String, $status: String!) {
                    updateTask(id: $id, title: $title, description: $description, status: $status) {
                    id
                    title
                    description
                    status
                    }
                }
            ',
            'variables' => [
                'id' => $task->id,
                'title' => 'Hello, GraphQL!',
                'description' => 'Hello, GraphQL!',
                'status' => 'todo'
            ]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Hello, GraphQL!',
            'description' => 'Hello, GraphQL!',
            'status' => 'todo'
        ]);
    }

}
