<?php

namespace App\Http\Controllers;
use App\Http\Requests\SchoolRequests;
use App\Http\Requests\ValidateSubject;
use App\Models\Events;
use App\Models\School;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


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
    public function SetEvent(Request $request){
        $rules=[
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:40',
            'start_date' => 'required|date|date_format:Y-m-d|after:yesterday',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
            'description' => 'required|string|max:100|min:20',
        ];
        $validator= Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('ViewEvents')->with(['action' => 'clickBtn'])->withErrors($validator);
        }
        $image=$request->file('image');
        $image_name=time()."_".$image->getClientOriginalName();
        $description=filter_var($request->input('description'),513);
        $title=filter_var($request->input('title'),513);
        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');
        $image->move('image/',$image_name);
        $event_data=[
            'image' => $image_name,
            'title' => $title,
            'description' => $description,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
        $file_name=time().'_'.auth()->guard('school')->user()->ID.'.json';
        $str=json_encode($event_data);
        file_put_contents('files/events/'.$file_name,$str);
        Events::create([
            'event_file_name'=>$file_name,
            'school_id' => auth()->guard('school')->user()->ID
        ]);
        return redirect()->route('ViewEvents')->with(['success' => 'The event added successfully']);
    }
    public function DeleteEvent($event_name,$event_id,$image_name){
        if (is_numeric($event_id) && auth()->guard('school')->check()){
            Events::where([['event_id',$event_id],['school_id',auth()->guard('school')->user()->ID]])->delete();
            unlink('files/events/'.$event_name);
            unlink('image/'.$image_name);
            return redirect()->route('ViewEvents')->with(['success' => 'The Event deleted successfully']);
        }else{
            return redirect()->route('ViewEvents');
        }
    }
}
