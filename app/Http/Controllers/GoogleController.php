<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    //

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /** cần sử lại cái lấy giá trị session hiển thị ở thông thông tin client. */
    public function handleGoogleCallback()
    {
        try {
            /** socialite là library của laravel được composer về */
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('provider_id', $googleUser->getId())->first();


            /** sau khi đã có auth thì sẽ đăng nhập bth không cần phải tạo account nửa */
            if ($user) {
                Auth::login($user);
                return redirect()->route('website-main');
            } else {
                /** khi mà click đăng nhập google thì trên google Auth PlatForm sẽ trả về các dữ liệu mà google-email đăng nhập và newUser
                 * sẽ bắt lại các trường dữ liệu và lưu vào database
                 * vì trời data password không nên phải lưu tạm một password là "google-auth-user"
                 * để trách lỗi create user mà không có trời password.
                 */
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt('google-auth-user'), // Giá trị tạm để không bị lỗi null password
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                ]);

                // Client::create([
                //     'user_id' => $newUser->id,
                //     'client_name' => $newUser->name,
                // ]);


                Auth::login($newUser);
                return redirect()->route('website-main');
            }
        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect('/role/login')->with('google-error', 'Đăng nhập thất bại: ' . $e->getMessage());
        }
    }
}