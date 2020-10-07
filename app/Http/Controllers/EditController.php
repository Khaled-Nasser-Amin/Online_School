<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateSubject;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\GetCurrentGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    use GetCurrentGuard;
    public function ViewEdit(){
        return view('commonLogged.Edit')->with(['tabPane','image']);
    }
    public function EditImage(Request $request){
        $file=$request->file('imageProfile');
        $rules=['imageProfile' =>'required|mimes:jpeg,png,jpg,gif,svg|max:2048'];
        $validate=Validator::make($request->all(),$rules);
        if($validate->fails()){
            return redirect()->back()->with(['tabPane' => 'image'])->withErrors($validate);
        }
        $fileName=time().$file->getClientOriginalName();
        $file->move('image/',$fileName);
        $image_name=auth()->guard($this->getGuard())->user()->image;
        unlink('image/'.$image_name);
        DB::table($this->getGuard())->where('ID',$this->getId())->update(['image' => $fileName]);
        return redirect()->back()->with(['tabPane' => 'image','success' => 'The image uploaded successfully']);
    }
    public function EditName(Request $request){
        $rules=[
            'firstname' =>'required|string|max:15|min:2',
            'lastname' =>'required|string|max:15|min:2',
            'midname' =>'required|string|max:15|min:2',
        ];
        $validator= Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect('Edit')->with(['tabPane' => 'name'])->withErrors($validator);
        }
        $first_name=filter_var($request->input('firstname'),513)." ".
            filter_var($request->input('midname'),513);
        if ($this->getGuard()== "school"){
            $name = $first_name .''.filter_var($request->input('lastname'),513);
            DB::table('school')->where('ID',$this->getId())->update(['name' => $name]);
        }else{
            $last_name=filter_var($request->input('lastname'),513);
            DB::table($this->getGuard())->where('ID',$this->getId())->update(['first_name' => $first_name , 'last_name' => $last_name]);
        }
        return redirect()->back()->with(['tabPane' => 'name','success' => 'The name updated successfully']);
    }
    public function ChangePassword(Request $request){
        $rules=[
            'OldPass' => 'required|max:40|min:8',
            'password' => 'required|max:40|min:8|confirmed',
            'password_confirmation' => 'required|max:40|min:8|same:password'
        ];
        $validator=Validator::make($request->all() , $rules);
        if($validator->fails()){
            return redirect()->back()->with(['tabPane' => 'password'])->withErrors($validator);
        }
        $userPass=auth()->guard($this->getGuard())->user()->password;
        $oldPass=$request->input('OldPass');
        $newPass=Hash::make($request->input('password'));

        if(Hash::check($oldPass,$userPass)){
            DB::table($this->getGuard())->where('ID',$this->getId())->update(['password' => $newPass]);
            return redirect()->back()->with(['tabPane'=>'password', 'success' => 'The password updated successfully']);
        }else{
            return redirect()->back()->with(['tabPane' => 'password','errorPass' => 'The old password is wrong']);
        }
    }
    public function ChangeEmail(Request $request){
        $email=filter_var($request->input('email'),517);
        session()->put('email',$email);
        $rules=[
            'email' =>'required|email|unique:School|unique:Teacher|unique:Student|unique:Parents|max:45',
        ];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return redirect()->back()->with(['tabPane'=> 'email'])->withErrors($validator);
        }

        Mail::send('commonLogged.ConfirmEmail',['name' => 'khaled'],function($details) use($email){
            $details->to($email)->subject('confirm email')->from('khalednasser546@gmail.com');
        });

        return redirect()->back()->with(['tabPane' => 'email','success' => 'We\'ve sent a confirmation link to Your New Email Address "'.$email.'"So Please Check your Email']);
    }
    public function ConfirmEmail(Request $request){
    if(session()->has('email') && session()->get('email') == auth()->guard($this->getGuard())->user()->email)
        return redirect()->route('Edit')->with(['tabPane' => 'email' , 'danger' => 'Your Email is already updated']);
        if(hash_equals(session()->token(),$request->input('_token')) && session()->has('email')){
            DB::table($this->getGuard())->where('ID',$this->getId())->update(['email' => session()->get('email')]);
            return redirect('Edit')->with(['tabPane' => 'email', 'success' => 'Your email address updated successfully']);
        }else{
            return redirect()->route('Edit')->with(['tabPane' => 'email' , 'danger' => 'Not valid request']);
        }
    }
    public function ChangePhone(Request $request)
    {
        $rules=['phone' => 'required|numeric|digits:11|unique:School|unique:Student|unique:Teacher|unique:Parents'];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return redirect()->route('Edit')->with(['tabPane' =>'phone'])->withErrors($validator);
        }
        $phone=(string)$request->input('phone');
        DB::table($this->getGuard())->where('ID',$this->getId())->update(['phone' => $phone]);
        return redirect()->route('Edit')->with(['tabPane' => 'phone', 'success' => 'Your phone number updated successfully']);
    }
    public function BIO(Request $request)
    {
        $rules=['bio' => 'required|string|max:255'];
        $validator=Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return redirect()->route('Edit')->with(['tabPane' =>'bio'])->withErrors($validator);
        }
        $bio=$request->input('bio');
        DB::table($this->getGuard())->where('ID',$this->getId())->update(['bio' => $bio]);
        return redirect()->route('Edit')->with(['tabPane' => 'bio', 'success' => 'Your BIO  updated successfully']);
    }
    public function ChangeBirthDay(Request $request)
    {
        $birthday=$request->input('day')."/".$request->input('mon')."/".$request->input('year');
        if($this->getGuard() == 'school')
            return redirect()->route('Edit');
        $rules=[
            'day' =>'required|integer|between:1,31',
            'mon' =>'required|integer|between:1,12',
            'year' =>'required|integer|digits:4|between:1960,2020'];
        $validator= Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('Edit')->with(['tabPane' => 'birthday'])->withErrors($validator);
        }
        DB::table($this->getGuard())->where('ID',$this->getId())->update(['birthday' =>$birthday]);
        return redirect()->route('Edit')->with(['tabPane' => 'birthday' ,'success' => 'Your birthday updated successfully']);
    }
    public function ChangeLocalAddress(Request $request)
    {
        $localAddress=filter_var($request->input('localAddress'),513);
        $rules=[
            'localAddress' =>'required|string|max:40|min:4',
        ];
        $validator= Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('Edit')->with(['tabPane' => 'LocalAddress'])->withErrors($validator);
        }
        if ($this->getGuard() == 'school')
            DB::table($this->getGuard())->where('ID',$this->getId())->update(['location' => $localAddress]);
        else
            DB::table($this->getGuard())->where('ID',$this->getId())->update(['local_address' => $localAddress]);
        return redirect()->route('Edit')->with(['tabPane' => 'LocalAddress' ,'success' => 'Your LocalAddress updated successfully']);
    }
    public function addMaterial(Request $request){
        if ($this->getGuard() != 'school')
            return redirect()->route('Edit');
        $rules=['name.*' =>'required|string|max:20|min:3'];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->route('Edit')->with(['tabPane' => 'addMaterial'])->withErrors($validator);
        }
        $subjects=$request->input('name.*');
        if($subjects != null){
            $subjects=filter_var_array($subjects,513);
            if(count($subjects) == count(array_unique($subjects))){
                foreach ($subjects as $subject){
                    if(in_array(strtolower($subject),array_map('strtolower',explode('/',auth()->guard('school')->user()->subject_name))))
                        return redirect()->route('Edit')->with(['tabPane' => 'addMaterial','danger' => 'This subject is already exists']);
                }
                $newSubjects=auth()->guard('school')->user()->subject_name.'/'.implode('/',$subjects);
                School::where('ID',$this->getId())->update(['subject_name' => $newSubjects]);
                return  redirect()->route('Edit')->with(['tabPane' => 'addMaterial' , 'success' => 'Your subjects updated successfully']);
            }else{
                return redirect()->route('Edit')->with(['tabPane' => 'addMaterial','danger' => 'Please don\'t duplicate any subject']);
            }
        }else{
            return redirect()->route('Edit')->with(['message' => 'Please, set at least one Subject']);
        }
    }
    public function DeleteAccount(Request $request){
        if($request->input('confirm') == 'yes'){
            auth()->guard($this->getGuard())->user()->delete();
            return redirect()->route('login')->with(['danger' => 'Your account deleted successfully']);
        }
        return  redirect()->route('Edit')->with(['tabPane' => 'delete','danger' => 'Please answer the question before sending the delete request ']);
    }
    public function AddChild(Request $request){
        $rules=[
            'child_code' => 'required|string||min:13|max:13||exists:Student,parent_code'
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->route('Edit')->with(['tabPane' => 'add_child'])->withErrors($validator);
        }
        $child_code=$request->input('child_code');
        $student_info=Student::select('ID','school_name','parent_id')->where('parent_code',$child_code)->first();
        if($student_info->parent_id == null){
            if($student_info->school_name == auth()->guard('parents')->user()->school_name){
                $student_info->parents()->associate($this->getId())->save();
                return redirect()->route('Edit')->with(['tabPane' => 'add_child','success' => 'Connected successfully with the child']);
            }else{
                return redirect()->route('Edit')->with(['tabPane' => 'add_child','danger' => 'This code is invalid']);
            }
        }
        else{
            return redirect()->route('Edit')->with(['tabPane' => 'add_child','danger' => 'This child is already connected with parent']);

        }

    }
    public function ChangeSubject(Request $request){
        $rules=['name.*' =>'required|string|max:20|min:3'];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->route('Edit')->with(['tabPane' => 'ChangeSubject'])->withErrors($validator);
        }
        if($request->input('name') != null || $request->input('name.*') != null){
            $user=auth()->guard($this->getGuard())->user();
           if ($this->getGuard() == 'teacher'){
              $subject=filter_var($request->input('name'),513);
              if ($subject == auth()->guard('teacher')->user()->subject)
                  return redirect()->route('Edit')->with(['tabPane' => 'ChangeSubject','danger' => 'You already registered this subject before']);
              Teacher::where('ID',$this->getId())->update(['subject' => $subject]);
              $user->student()->detach();
              $students=Student::select('ID','subject','grade')->where('school_name',$user->school_name)->get();
              foreach ($students as $student){
                if (in_array($subject,explode('/',$student->subject)) && $student->grade == $user->grade){
                    $user->student()->syncWithoutDetaching([$student->ID => ['subject' => $subject]]);
                }
              }
               return redirect()->route('Edit')->with(['tabPane' => 'ChangeSubject' ,'success' => 'your subject updated successfully']);
           }
           elseif ($this->getGuard() == "student"){
                $subjects=filter_var_array($request->input('name.*'),513);
                $str_subjects=implode('/',$subjects);
                Student::where('ID',$this->getId())->update(['subject' => $str_subjects]);
                $user->teacher()->detach();
               $teachers=Teacher::select('ID','subject','grade')->where('school_name',$user->school_name)->get();
               foreach ($teachers as $teacher){
                   if (in_array($teacher->subject,$subjects) && $teacher->grade == $user->grade){
                       $user->teacher()->syncWithoutDetaching([$teacher->ID => ['subject' => $teacher->subject]]);
                   }
               }
               return redirect()->route('Edit')->with(['tabPane' => 'ChangeSubject' ,'success' => 'your subjects updated successfully']);
           }
        }else{
            return redirect()->route('Edit')->with(['tabPane' => 'ChangeSubject' ,'danger' => 'You can\'t send nullable value']);
        }
    }
    public function ChangeGrade(Request $request){
        $user=auth()->guard($this->getGuard())->user();
        $rules=['grade' =>'required|string|max:22'];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->route('Edit')->with(['tabPane' => 'ChangeGrade'])->withErrors($validator);
        }

        $grade=filter_var($request->input('grade'),513);
        if($user->grade != $grade){
            DB::table($this->getGuard())->where('ID',$this->getId())->update(['grade' => $grade]);
            if ($this->getGuard() == 'teacher'){
                $user->student()->detach();
                $students=Student::select('ID','subject','grade')
                    ->where([['school_name','=',$user->school_name],['grade','=', $grade]])
                    ->get();
                foreach ($students as $student){
                    if (in_array($user->subject,explode('/',$student->subject))){
                        $user->student()->syncWithoutDetaching([$student->ID => ['subject' => $user->subject]]);
                    }
                }
            }
            elseif ($this->getGuard() == 'student'){
                $user->teacher()->detach();
                $teachers=Teacher::select('ID','subject')
                    ->where([['school_name','=',$user->school_name],['grade' ,'=', $grade]])
                    ->whereIn('subject',explode('/',$user->subject))
                    ->get();
                foreach ($teachers as $teacher){
                    $user->teacher()->syncWithoutDetaching([$teacher->ID => ['subject' => $teacher->subject]]);
                }
            }
            return redirect()->route('Edit')->with(['tabPane' => 'ChangeGrade' ,'success' => 'Your grade updated successfully']);

        }else{
            return redirect()->route('Edit')->with(['tabPane' => 'ChangeGrade' ,'danger' => 'You already in this grade']);
        }

    }
    public function getId()
    {
        return auth()->guard($this->getGuard())->user()->ID;
    }

}
