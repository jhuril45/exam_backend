<?php

namespace App\GraphQL\Mutations;

use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;

class CreateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createTask',
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
            ],
            'status' => [
                'name' => 'status',
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = Auth::user();
        $task = new Task();
        $task->title = $args['title'];
        $task->user_id = $user->id;
        $task->description = $args['description'] ?? '';
        $task->status = $args['status'];
        $task->save();

        return $task;
    }
}
