<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UpdateLastLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard()->check()) {
            auth()->guard()->user()->update([
                'last_login' => now(),
            ]);
        }

        return $next($request);
    }
}
