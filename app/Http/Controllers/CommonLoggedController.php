<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Posts;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Traits\GetCurrentGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonLoggedController extends Controller
{
    use GetCurrentGuard;
    public function ViewHome(){
       $teacher_posts=file_exists('files/posts/teacher_'.$this->school_id().'.json') ? file_get_contents('files/posts/teacher_'.$this->school_id().'.json') : '';
       $student_posts=file_exists('files/posts/student_'.$this->school_id().'.json') ? file_get_contents('files/posts/student_'.$this->school_id().'.json') : '';
       $parents_posts=file_exists('files/posts/parents_'.$this->school_id().'.json') ? file_get_contents('files/posts/parents_'.$this->school_id().'.json') : '';
       $school_posts=file_exists('files/posts/school_'.$this->school_id().'.json') ? file_get_contents('files/posts/school_'.$this->school_id().'.json') : '';

        return view('commonLogged.homeLogged',
            [
            'teacher_posts' => json_decode($teacher_posts,true) ,
            'student_posts' => json_decode($student_posts,true) ,
            'parents_posts' => json_decode($parents_posts,true) ,
            'school_posts' => json_decode($school_posts,true) ,
            ]);
    }
    public function ViewProfile($type,$id){
        $user_data=array();
        switch ($type){
            case 'school':
                $user_data=School::select('*')->where('ID',$id)->with(['teacher','student','parents'])->first();
                break;
            case 'student':
                $user_data=Student::select('*')->where('ID',$id)->with('parents')->first();
                break;
            case 'parents':
                $user_data=Parents::select('*')->where('ID',$id)->first();
                break;
            case 'teacher':
                $user_data=Teacher::select('*')->where('ID',$id)->first();
                break;
        }
        $data_posts=file_exists('files/posts/'.$type.'_'.$this->school_id().'.json') ? file_get_contents('files/posts/'.$type.'_'.$this->school_id().'.json') : '';
        return view('commonLogged.Profile',['user_data' => $user_data,'type' => $type,'data_posts' => json_decode($data_posts,true)]);
    }
    public function SearchResult(Request $request){
        $searchKey=filter_var($request->input('key'),513);
        if($searchKey != null){
            $StudentResult=Student::select('first_name','last_name','ID','image')
                ->where('first_name','LIKE','%'.$searchKey.'%')->orWhere('last_name','LIKE','%'.$searchKey.'%')->get();
            $ParentsResult=Parents::select('first_name','last_name','ID','image')
                ->where('first_name','LIKE','%'.$searchKey.'%')->orWhere('last_name','LIKE','%'.$searchKey.'%')->get();
            $TeacherResult=Teacher::select('first_name','last_name','ID','image')
                ->where('first_name','LIKE','%'.$searchKey.'%')->orWhere('last_name','LIKE','%'.$searchKey.'%')->get();
            $SchoolResult=School::select('name','ID','image')->where('name','LIKE','%'.$searchKey.'%')->get();
            return view('commonLogged.SearchResult',['teachers' => $TeacherResult,'parents' => $ParentsResult,'students' => $StudentResult,'schools' => $SchoolResult]);
        }else{
            return redirect()->back();
        }

    }
    public function ViewEvents(){
        $event_data=array();
        $event_files=auth()->guard($this->getGuard())->user()->events;
        foreach ($event_files as $event){
            $str=file_get_contents('files/events/'.$event->event_file_name);
            $arr=json_decode($str,true);
            $arr+=['event_id' => $event->event_id];
            $arr+=['event_file_name' => $event->event_file_name];
            array_push($event_data,$arr);
        }
        return view('commonLogged.Events',['data' =>$event_data]);
    }
    public function SetPost(Request $request){
        $rules=[
            'image' => 'mimes:jpeg,jpg,gif,png,svg|max:2048',
        ];
        $validator= Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return redirect()->route('home_logged')->with(['action' => 'clickBtn'])->withErrors($validator);
        }
        $image=$request->file('image');
        $post=$request->input('post');
        $image_name=null;
        if ($image == null && $post == null)
            return redirect()->route('home_logged')->with(['action' => 'clickBtn']);
        if ($image != null){
            $image_name=$image->getClientOriginalName();
            $image->move('image/',$image_name);
        }
        $user=auth()->guard($this->getGuard())->user();
        $user_name= $this->getGuard() == 'school' ? $user->name : $user->first_name.' '.$user->last_name;
        $user_image=$user->image;
        $data=array('image' => $image_name , 'post' => $post ,'user_id' => $user->ID,'user_name' => $user_name,'user_image'=>$user_image,'time' => date('Y-m-d h:i:s '));
        $file_name=$this->getGuard().'_'.$this->school_id().'.json';
        $file_path='files/posts/'.$file_name;
        $array=array();
        if(!file_exists($file_path)) {
            array_unshift($array,$data);
            Posts::create(['post_file_name' => $file_name, 'school_id' => $this->school_id()]);
            file_put_contents($file_path,json_encode($array));
            return redirect()->route('home_logged')->with(['success' => 'The post uploaded successfully']);
        }
        $object=file_get_contents($file_path);
        $object=json_decode($object,true);
        $object == null ? array_unshift($array,$data) : array_unshift($object,$data);
        $array= $object == null ? json_encode($array): json_encode($object);
        file_put_contents($file_path,$array);
        return redirect()->route('home_logged')->with(['success' => 'The post uploaded successfully']);

    }
    public function DeletePost($number,$id,$type){
        if ($this->getGuard() == $type && auth()->guard($this->getGuard())->user()->ID == $id){
            $file_name='files/posts/'.$type.'_'.$this->school_id().'.json';
            $arr=file_get_contents($file_name);
            $arr=json_decode($arr);
            $deleted_post=array_splice($arr,$number,1);
            if($deleted_post[0]->image != null)
                unlink('image/'.$deleted_post[0]->image);
            file_put_contents($file_name,json_encode($arr));
            return redirect()->route('home_logged')->with(['success' => 'Post deleted successfully']);

        }
    }
    public function school_id(){
        return $this->getGuard() == 'school' ? auth()->guard('school')->user()->ID : auth()->guard($this->getGuard())->user()->school_id;
    }

}
