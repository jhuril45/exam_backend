<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;

class LogoutMutation extends Mutation
{
    protected $attributes = [
        'name' => 'logout',
    ];

    public function type(): Type
    {
        return Type::nonNull(Type::string());
    }

    public function resolve($root, $args)
    {
        $user = Auth::user();
        $user->token()->revoke();

        return 'Logged out successfully';
    }
}
