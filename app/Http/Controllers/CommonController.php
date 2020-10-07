<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\GetCurrentGuard;
class CommonController extends Controller
{
    use GetCurrentGuard;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function Index(){
        return view('common.Index');
    }
    public function About(){
        return view('common.about');
    }
    public function Contact(){
        return view('common.contact_us');
    }
    public function Support(){
        return view('common.support');
    }
    public function ViewLogin(){
        return view('common.LoginPage');
    }
    public function logout(){
        if(!$this->getGuard())
            return redirect()->back();
        Auth::guard($this->getGuard())->logout();
        return redirect('/Login');
    }

    public function login(Request $request){
        $password=$request->input('password');
        $credential=[];
        if(filter_var($request->input('username'),FILTER_VALIDATE_EMAIL))
        {
            $username=filter_var($request->input('username'),517);
            $credential=[
                'email' => $username,
                'password' => $password
            ];
        }elseif(is_numeric($request->input('username')))
        {
            $username=(string)$request->input('username');
            $credential=[
                'phone' => $username,
                'password' => $password
            ];
        }
        if(Auth::guard('school')->attempt($credential,1)){
            return redirect('/');
        }
        elseif(Auth::guard('student')->attempt($credential,1)){
            return redirect()->intended('/home');
        }
        elseif(Auth::guard('parents')->attempt($credential,1)){
            return redirect()->intended('/home');
        }
        elseif(Auth::guard('teacher')->attempt($credential,1)){
            return redirect()->intended('/home');
        }else{
            return redirect()->back()->with(['danger' => 'This Credential does not match in our records']);
        }
    }

}
