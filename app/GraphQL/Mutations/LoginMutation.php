<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Auth;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'login',
    ];

    public function type(): Type
    {
        return Type::nonNull(Type::string());
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (Auth::attempt(['email' => $args['email'], 'password' => $args['password']])) {
            $user = Auth::user();
            $token = $user->createToken('auth-token');
            return json_encode([
                'token' =>  $token->plainTextToken,
                'user' =>  $user,
            ]);
        }

        return 'Invalid credentials';
    }
}
