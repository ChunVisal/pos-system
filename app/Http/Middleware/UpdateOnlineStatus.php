<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UpdateOnlineStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Cache user as online for 1 minute
            Cache::put('user-online-'.$user->id, true, now()->addMinutes(1));
        }

        return $next($request);
    }
}
