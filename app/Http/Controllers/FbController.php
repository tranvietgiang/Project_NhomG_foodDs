<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FbController extends Controller
{
    //
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $user = User::where('provider_id', $facebookUser->getId())->first();

            $existingUser = User::where('email', $facebookUser->getEmail())->first();

            if ($existingUser) {
                $existingUser->update([
                    'provider' => 'facebook',
                    'provider_id' => $facebookUser->getId(),
                ]);
                Auth::login($existingUser);
                return redirect()->route('website-main');
            }


            if ($user) {
                Auth::login($user);
                return redirect()->route('website-main');
            } else {
                $newUser = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'password' => bcrypt('facebook-auth-user'),
                    'provider' => 'facebook',
                    'provider_id' => $facebookUser->getId(),
                ]);


                Auth::login($newUser);
                return redirect()->route('website-main');
            }
        } catch (\Exception $e) {
            Log::error('Facebook Login Error: ' . $e->getMessage());
            return redirect('/role/login')->with('facebook-error', 'Đăng nhập Facebook thất bại: ' . $e->getMessage());
        }
    }
}