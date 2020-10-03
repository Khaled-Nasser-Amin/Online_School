<?php

namespace App\Http\Middleware;

use App\Traits\GetCurrentGuard;
use App\Traits\RedirectAfterVerified;
use Closure;

class CheckSubject
{
    use GetCurrentGuard,RedirectAfterVerified;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      switch ($this->getGuard()){
            case 'school':
                 return auth()->guard('school')->user()->subject_name == NULL ?
                        redirect()->route($this->redirect_after_verified()) : $next($request);

            case 'student':
            case 'teacher':
                return auth()->guard($this->getGuard())->user()->subject == NULL ?
                        redirect()->route($this->redirect_after_verified()) : $next($request) ;

           case 'parents': return $next($request);
      }
    }
}
