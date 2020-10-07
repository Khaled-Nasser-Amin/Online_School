<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequests;
use App\Http\Requests\ValidateSubject;
use App\Models\Student;
use App\Models\Teacher;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\School;


class Student_Operations extends Controller
{
    public function Sign_Up_Student(){
        return view('student.SignUp_Student');
    }
    public function Register(StudentRequests $request){
        $first_name=filter_var($request->input('firstname'),513)." ".
                    filter_var($request->input('midname'),513);
        $last_name=filter_var($request->input('lastname'),513);
        $email=filter_var($request->input('email'),517);
        $password=Hash::make($request->input('password'));
        $phone=(string)$request->input('phone');
        $st_reg_code=filter_var($request->input('schoolcode'),513);
        $gender=filter_var($request->input('gender'),513);
        $grade=filter_var($request->input('grade'),513);
        $loacal_address=filter_var($request->input('localaddress'),513);
        $birthday=$request->input('day')."/"
                .$request->input('mon')."/"
                .$request->input('year');
        $school_name=filter_var($request->input('schoolname'),513);
        $image=($gender == "male") ? "student_male.jpg" : "student_female.jpg";
        do{
            $str="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $parent_code=substr(str_shuffle($str),0,13);
            $check_if_exist=Student::where('parent_code',$parent_code)->first();
        }while($check_if_exist);

        $student=Student::create([
            'first_name'=> $first_name,
            'last_name'=> $last_name,
            'email'=> $email,
            'password'=> $password,
            'phone'=> $phone,
            'image'=> $image,
            'st_reg_code'=> $st_reg_code,
            'local_address'=> $loacal_address,
            'gender'=> $gender,
            'grade'=> $grade,
            'parent_code'=> $parent_code,
            'birthday'=> $birthday,
            'school_name'=> $school_name,
        ]);
        $school=School::where('st_reg_code',$st_reg_code)->first();
        //$school->student()->save($student);
        $student->school()->associate($school->ID)->save();
        Auth::guard('student')->login($student);
        return redirect()->route('SendEmail');
    }
    public function Choose_Subject(ValidateSubject $request){
        $subjects=$request->input('name.*');
        if($subjects != null){
            $subjects=filter_var_array($subjects,FILTER_SANITIZE_STRING);
            if (count($subjects) == count(array_unique($subjects)))
            {
                $user=Auth::guard('student')->user();
                $str=implode('/',$subjects);
                Student::where('ID',$user->ID)->update(['subject' => $str]);
                $teachers=Teacher::select('ID','subject','grade')->where('school_id',$user->school->ID)->get();
                foreach ($teachers as $teacher){
                    if(in_array($teacher['subject'],$subjects) && $teacher['grade'] == $user->grade){
                        $user->teacher()->syncWithoutDetaching([$teacher['ID'] => ['subject' => $teacher['subject']]]);
                    }
                }

                return redirect('/homee');
            }else{
                return redirect()->back()->with(['message' => 'Please don\'t duplicate the name of subject']);
            }
        }else{
            return redirect()->back()->with(['message' => 'Please, choose at least one Subject']);
        }

    }
    public function View_Choose_Subject(){
        return auth()->guard('student')->user()->subject == NULL ?
         view('student.Choose_Subject') : redirect(RouteServiceProvider::HOME)->with(['message' => 'You already have subject, if you wanna change it u gotta go to Edit then subject']);
    }
}
