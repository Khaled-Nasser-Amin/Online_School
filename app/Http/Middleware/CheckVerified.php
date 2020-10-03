<?php

namespace App\Http\Middleware;

use App\Traits\GetCurrentGuard;
use Closure;

class CheckVerified
{
    use GetCurrentGuard;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return auth()->guard($this->getGuard())->user()->verified == 0 ?
                redirect('/Send_Email_Verification') : $next($request);
    }
}
