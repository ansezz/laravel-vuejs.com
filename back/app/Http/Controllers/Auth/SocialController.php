<?php

namespace LaravelVueJs\Http\Controllers\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use LaravelVueJs\Http\Controllers\Controller;
use LaravelVueJs\Models\LinkedSocialAccount;
use LaravelVueJs\Models\User;

class SocialController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param string $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param string $provider
     *
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $account = LinkedSocialAccount::where('provider_id', $user->id)
            ->where('provider_name', $provider)
            ->first();

        if ($account) {
            $authUser = $account->user;
        } else {
            $authUser = User::where('email', $user->email)->first();

            if (!$authUser) {
                $authUser = User::create([
                    'name'     => $user->getName(),
                    'email'    => $user->getEmail(),
                    'avatar'   => $user->getAvatar(),
                    'nickname' => $user->getNickname(),
                ]);
            }
            LinkedSocialAccount::create([
                'provider_id'   => $user->getId(),
                'provider_name' => $provider,
                'user_id'       => $authUser->id,
                'data'          => json_encode($user),
            ]);
        }


        Auth::login($authUser);


        $user = auth()->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();

        return redirect('/?token=' . $tokenResult->accessToken);
    }
}
