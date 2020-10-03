<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParentRequest;
use App\Models\Parents;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Parent_Operations extends Controller
{
    public function Sign_Up_Parent(){
        return view('parent.SignUp_Parent');
    }
    public function Register(ParentRequest $request){
        $first_name=filter_var($request->input('firstname'),513)." ".
            filter_var($request->input('midname'),513);
        $last_name=filter_var($request->input('lastname'),513);
        $email=filter_var($request->input('email'),517);
        $password=Hash::make($request->input('password'));
        $phone=(string)$request->input('phone');
        $par_reg_code=filter_var($request->input('schoolcode'),513);
        $gender=filter_var($request->input('gender'),513);
        $loacal_address=filter_var($request->input('localaddress'),513);
        $birthday=$request->input('day')."/"
            .$request->input('mon')."/"
            .$request->input('year');
        $school_name=filter_var($request->input('schoolname'),513);
        $child_code=filter_var($request->input('child_code'),513);
        $image=($gender == "male") ? "man.png" : "woman.png";
        $user=Parents::create([
            'first_name' => $first_name,
            'last_name' => $last_name ,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
            'par_reg_code' => $par_reg_code,
            'gender' => $gender,
            'local_address' => $loacal_address,
            'image' => $image,
            'school_name' => $school_name,
            'birthday' => $birthday,
            ]);
        auth()->guard('parents')->login($user);
        $school=School::where(['par_reg_code' => $par_reg_code ,
                                'name'=>$school_name])->first();
        $user->school()->associate($school->ID)->save();

        $student=Student::where(['school_name' => $school_name , 'parent_code' => $child_code])->first();
        $user->student()->save($student);
        return redirect()->route('SendEmail');

    }
}
