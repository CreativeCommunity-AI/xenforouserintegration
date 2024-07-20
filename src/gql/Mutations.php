<?php
namespace CreativeCommunityAI\xenforouserintegration\gql;

use GraphQL\Type\Definition\Type;
use craft\gql\base\Mutation;
use CreativeCommunityAI\xenforouserintegration\gql\resolvers\UserResolver;

class Mutations extends Mutation
{
    public static function getMutations(): array
    {
        return [
            'login' => [
                'name' => 'login',
                'args' => [
                    'username' => Type::nonNull(Type::string()),
                    'password' => Type::nonNull(Type::string()),
                ],
                'type' => Type::boolean(),
                'resolve' => [UserResolver::class, 'resolve'],
                'description' => 'Logs a user in using XenForo credentials.',
            ],
        ];
    }
}