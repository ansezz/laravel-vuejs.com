<?php

namespace LaravelVueJs\Http\GraphQL\Queries;

use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Login
{
    /**
     * Return a value for the field.
     *
     * @param null $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param array $args The arguments that were passed into the field.
     * @param GraphQLContext|null $context Arbitrary data that is shared between all fields of a single query.
     * @param ResolveInfo $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     *
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {

        if (!Auth::attempt(['email' => $args['email'], 'password' => $args['password']])) {
            return null;
        }

        $user = auth()->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if (isset($args['remember_me'])) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return [
            'access_token' => $tokenResult->accessToken,
            'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ];
    }
}
