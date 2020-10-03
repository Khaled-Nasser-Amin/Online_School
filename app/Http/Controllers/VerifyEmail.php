<?php

namespace App\Http\Controllers;
use App\Traits\GetCurrentGuard;
use App\Traits\RedirectAfterVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifyEmail extends Controller
{
    use GetCurrentGuard,RedirectAfterVerified;

     public function verifyEmail(Request $request){
         $token=$request->input('_token');
         if(hash_equals(session()->token(), $token)){
             $user=Auth::guard($this->getGuard())->user();
             $userId=Auth::guard($this->getGuard())->user()->ID;
             $type=$this->getGuard();
             if($user->verified == 0)
                 DB::table($type)->where('ID','=',$userId)->update(['verified' => 1]);

             return redirect()->route($this->redirect_after_verified());
         }
         return redirect()->route('CheckEmail');
     }

}
