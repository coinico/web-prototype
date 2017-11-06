<?php

namespace App\Http\Middleware;

use Closure;

class Community
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user && ($user->role === 'admin' || $user->role === 'community')) {
            return $next($request);
        }

        return response('No authorized', 401);
    }
}
