<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu chưa đăng nhập và đường dẫn hiện tại không phải là trang đăng nhập
        // chưa sử dụng

        if (!Auth::check()) {
            return redirect()->route('wayLogin', ['page' => 'login']);
        }

        if (Auth::user()->role == "user") {
            return redirect()->route('wayLogin', ['page' => 'login']);
        }

        return $next($request);
    }
}