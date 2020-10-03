<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;

Trait  GetCurrentGuard
{
    protected function getGuard(){
        if(Auth::guard('school')->check()){
            return 'school';
        }
        elseif(Auth::guard('student')->check()){
            return 'student';
        }
        elseif(Auth::guard('teacher')->check()){
            return 'teacher';
        }
        elseif(Auth::guard('parents')->check()){
            return 'parents';
        }else{
            return false;
        }
    }
}
