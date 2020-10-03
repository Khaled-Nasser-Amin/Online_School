<?php

namespace App\Http\Controllers;
use App\Http\Requests\SchoolRequests;
use App\Http\Requests\ValidateSubject;
use App\Models\School;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class School_Operations extends Controller
{
    public function Sign_Up_School(){
        return view('school.SignUp_School');
    }

    public function Register(SchoolRequests $request){
        $email=filter_var($request->input('email'),517);
        $name=filter_var($request->input('firstname'),513) ." "
                .filter_var($request->input('midname'),513)." "
                .filter_var($request->input('lastname'),513);
        $localaddress=filter_var($request->input('localaddress'),513);
        $phone=(string)$request->input('phone');
        $password=Hash::make($request->input('password'));
        do{
            $str="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $student_registration_code=substr(str_shuffle($str),0,13);
            $parent_registration_code=substr(str_shuffle($str),0,13);
            $teacher_registration_code=substr(str_shuffle($str),0,13);
            $Check_code=School::where('st_reg_code', '=', $student_registration_code)
                ->orWhere('te_reg_code','=', $student_registration_code)
                ->orWhere('par_reg_code' ,'=', $student_registration_code)->exists();
        }while($Check_code);

       $user= School::create([
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'location' => $localaddress,
            'password' => $password,
            'par_reg_code' => $parent_registration_code,
            'st_reg_code' => $student_registration_code,
            'te_reg_code' => $teacher_registration_code,
            'image' => 'school.jpg'
        ]);
        Auth::guard('school')->login($user);
        return redirect()->route('SendEmail');
    }

    public function Set_Subjects(ValidateSubject $request){
        $subjects=$request->input('name.*');
        if($subjects != null) {
            $subjects = filter_var_array($subjects, FILTER_SANITIZE_STRING);
            if (count($subjects) == count(array_unique($subjects))) {
                $str = implode('/', $subjects);
                School::where('ID', Auth::guard('school')->user()->ID)->update(['subject_name' => $str]);
                return redirect('/homee');
            } else {
                return redirect()->back()->with(['message' => 'Please don\'t duplicate the name of subject']);
            }
        }else{
            return redirect()->back()->with(['message' => 'Please, set at least one Subject']);
        }

    }
    public function View_Set_Subjects(){
        return auth()->guard('school')->user()->subject_name == NULL ?
            view('school.Set_Subjects') : redirect(RouteServiceProvider::HOME)->with(['message' => 'You already have subjects, if you wanna change them u gotta go to Edit then subject']);
    }



}
