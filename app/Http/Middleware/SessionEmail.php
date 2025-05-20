<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionEmail
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->isMethod('post')) {
            // Nếu không phải POST thì redirect về login
            return redirect()->route('wayLogin', ['page' => 'login']);
        }
        return $next($request);
    }
}