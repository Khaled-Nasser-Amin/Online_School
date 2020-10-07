<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequests;
use App\Models\Student;
use App\Models\School;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class Teacher_Operations extends Controller
{
    public function Sign_Up_Teacher(){
        return view('teacher.SignUp_Teacher');
    }
    public function Register(TeacherRequests $request){
        $first_name=filter_var($request->input('firstname'),513)." ".
            filter_var($request->input('midname'),513);
        $last_name=filter_var($request->input('lastname'),513);
        $email=filter_var($request->input('email'),517);
        $password=Hash::make($request->input('password'));
        $phone=(string)$request->input('phone');
        $te_reg_code=filter_var($request->input('schoolcode'),513);
        $gender=filter_var($request->input('gender'),513);
        $grade=filter_var($request->input('grade'),513);
        $loacal_address=filter_var($request->input('localaddress'),513);
        $birthday=$request->input('day')."/"
            .$request->input('mon')."/"
            .$request->input('year');
        $school_name=filter_var($request->input('schoolname'),513);
        $image=($gender == "male") ? "teacher_male.png" : "teacher_female.jpg";
        $teacher=Teacher::create([
            'first_name'=> $first_name,
            'last_name'=> $last_name,
            'email'=> $email,
            'password'=> $password,
            'phone'=> $phone,
            'image'=> $image,
            'gender' => $gender,
            'grade' => $grade,
            'local_address' => $loacal_address,
            'school_name' => $school_name,
            'birthday' => $birthday,
            'tea_reg_code' => $te_reg_code,
        ]);
        $school=School::where('te_reg_code',$te_reg_code)->first();
        //$school->teacher()->save($teacher);
        $teacher->school()->associate($school->ID)->save();
        Auth::guard('teacher')->login($teacher);
        return redirect()->route('SendEmail');
    }
    public function View_Choose_Subject(){
        return auth()->guard('teacher')->user()->subject == NULL ?
         view('teacher.Choose_Your_Subject'): redirect(RouteServiceProvider::HOME)->with(['message' => 'You already have subject, if you wanna change it u gotta go to Edit then subject']);
    }
    public function Choose_Your_Subject(Request $request){
        $user=auth()->guard('teacher')->user();
        $subject_name=filter_var($request->input('name'),513);
        Teacher::where('ID',$user->ID)->update(['subject' => $subject_name]);
        $students=Student::select('ID','subject','grade')->Where('school_id',$user->school->ID)->get()->toArray();
        foreach ($students as $student){
            if(in_array($subject_name,explode('/',$student['subject'])) && $student['grade'] == $user->grade){
                $user->student()->syncWithoutDetaching([$student['ID'] => ['subject' => $subject_name]]);
            }
        }
        return redirect('/homee');

    }


}
