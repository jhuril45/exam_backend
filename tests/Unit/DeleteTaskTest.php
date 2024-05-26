<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class DeleteTaskTest extends TestCase
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
                mutation ($id: Int!) {
                    deleteTask(id: $id) {
                    id
                    }
                }
            ',
            'variables' => [
                'id' => $task->id
            ]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

}
