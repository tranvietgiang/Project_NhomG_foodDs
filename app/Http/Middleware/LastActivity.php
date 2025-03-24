<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache; // Thêm import
use Illuminate\Support\Facades\Log;   // Thêm import

class LastActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        // if (Auth::check()) {
        //     $user = Auth::user();

        //     Log::info('User class: ' . get_class($user));

        //     $cacheKey = 'last_activity_updated_' . $user->id;

        //     if (!Cache::has($cacheKey)) {
        //         $user->last_activity = Carbon::now();
        //         $user->save();

        //         Log::info('Updated last_activity for user: ' . $user->id . ' at ' . $user->last_activity);
        //         Cache::put($cacheKey, true, now()->addMinutes(5));
        //     }
        // }

        // return $next($request);
    }
}