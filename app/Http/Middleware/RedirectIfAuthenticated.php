<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Traits\GetCurrentGuard;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    use GetCurrentGuard;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($this->getGuard())->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }
        return $next($request);

    }
}
