<?php
namespace CreativeCommunityAI\xenforouserintegration\gql\resolvers;

use Craft;
use craft\gql\base\Resolver;
use CreativeCommunityAI\xenforouserintegration\XenForoUserIntegration;
use GraphQL\Type\Definition\ResolveInfo;

class UserResolver extends Resolver
{
    public static function resolve($source, array $arguments, $context, ResolveInfo $resolveInfo): mixed
    {
        $username = $arguments['username'];
        $password = $arguments['password'];

        $user = XenForoUserIntegration::$plugin->xenForoService->authenticateUser($username, $password);

        if ($user) {
            // Generate a token or session for the authenticated user if needed
            return true;
        }

        return false;
    }
}