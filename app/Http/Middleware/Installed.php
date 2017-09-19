<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class Installed
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
        if (User::count() >= 1) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
