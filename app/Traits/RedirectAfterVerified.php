<?php
namespace App\Traits;
Trait  RedirectAfterVerified
{
    //return route name
    use GetCurrentGuard;
    protected function redirect_after_verified(){
        if($this->getGuard() == 'school')
            return 'View_Set_Subjects';
        elseif ($this->getGuard() == 'student')
            return 'View_Choose_Subject';
        elseif ($this->getGuard() == 'teacher')
            return 'View_Choose_Your_Subject';
        elseif ($this->getGuard() == 'parents')
            return 'home_logged';
    }
}
