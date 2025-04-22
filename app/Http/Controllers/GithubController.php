<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GithubController extends Controller
{
    //

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    // Handle the GitHub callback
    public function handleProviderCallback()
    {

        $socialUser = Socialite::driver('github')->user();

        // $socialUser->getNickname() → trích từ "login" → luôn có → bạn thấy dùng được là đúng.

        // Tạo hoặc tìm user
        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getNickname(),
                'password' => Hash::make('default-github'),
                'provider' => 'github',
                'provider_id' => $socialUser->getId(),
            ]
        );

        // Client::create([
        //     'user_id' => $user->id,
        //     'client_name' => $socialUser->getNickname(),
        // ]);

        auth::login($user);
        return redirect()->route('website-main');
    }
}