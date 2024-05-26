<?php

namespace App\GraphQL\Queries;

use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Facades\Auth;

class TasksQuery extends Query
{
    protected $attributes = [
        'name' => 'tasks',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Task'));
    }

    public function resolve($root, $args)
    {
        $user = Auth::user();

        return Task::where('user_id', $user['id'])->get();
    }
}
