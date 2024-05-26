<?php

namespace App\GraphQL\Mutations;

use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UpdateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateTask',
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int()),
            ],
            'user_id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int()),
            ],
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
            ],
            'status' => [
                'name' => 'status',
                'type' => Type::string(),
                'rules' => [Rule::in(['todo', 'done'])],
            ],
        ];
    }


    public function resolve($root, $args)
    {
        $task = Task::findOrFail($args['id']);
        $user = Auth::user();
        if ($task->user_id !== $user->id) {
            throw new UnauthorizedHttpException('Basic', 'Unauthorized');
        }

        if (isset($args['title'])) {
            $task->title = $args['title'];
        }
        if (isset($args['description'])) {
            $task->description = $args['description'];
        }
        if (isset($args['status'])) {
            $task->status = $args['status'];
        }

        $task->save();

        return $task;
    }
}
