<?php

namespace App\Http\Controllers;
use App\Traits\GetCurrentGuard;
use App\Traits\RedirectAfterVerified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;



class SendEmailToVerifyAccount extends Controller
{
    use GetCurrentGuard,RedirectAfterVerified;

    public function SendEmail()
    {
        $user = Auth::guard($this->getGuard())->user();
        $email = $user->email;
        $name = $this->getUserName();
        if ($user->verified == 0) {
            $data = ['name' => $name];
            Mail::send('common.MailView', $data, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Verify Your Account')
                    ->from('khalednasser546@gmail.com', 'Online School');
            });
            return view('common.Verification', [
                'success' => 'Please Check your Inbox to verify Your Account.',
                'email' => $email]);
        } else {
            return redirect()->route($this->redirect_after_verified())->with(['danger' => 'You already verified Your Account before']);
        }
    }
    public function Check_Verified_Email(){
        $user = Auth::guard($this->getGuard())->user();
        if($user->verified == 0){
           return view('common.Verification', [
                'danger' => 'Your Account is not Verified.Please Verify Your account to continue',
                'email' => $user->email]);
        }
        else{
            return redirect()->route($this->redirect_after_verified())->with(['danger' => 'You already verified Your Account before']);
        }
    }

    public function getUserName(){
        if($this->getGuard() == 'school')
            return Auth::guard('school')->user()->name;
        else
            return  Auth::guard($this->getGuard())->user()->firstname;
    }

}
