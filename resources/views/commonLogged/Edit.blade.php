@extends('layouts.HeaderLogged')
@section('navbar')
    @parent
@stop
@section('content')
    <hr>
    @if(session()->has('success'))
        <div class="alert alert-success text-center" role="alert">{{session()->get('success')}}</div>

    @elseif(session()->has('danger'))
        <div class="alert alert-danger text-center" role="alert">{{session()->get('danger')}}</div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="text-left card-box">
                    <div class="text-left m-t-40">
                        <ul class="nav edit_list">
                            <li class="nav-item"><a href="#Image" data-toggle="tab" class="nav-link" aria-expanded="true">Upload Profile Image</a></li>
                            <li class="nav-item"><a href="#Name" class="nav-link" data-toggle="tab" aria-expanded="false">Change Name</a></li>
                            <li class="nav-item"><a href="#pass" class="nav-link" data-toggle="tab" aria-expanded="false">Change Password</a></li>
                            <li class="nav-item"><a href="#Em" data-toggle="tab" class="nav-link" aria-expanded="true">Change Email</a></li>
                            <li class="nav-item"><a href="#Phone" data-toggle="tab" class="nav-link" aria-expanded="false">Change Phone</a></li>
                            <li class="nav-item"><a href="#Bio" data-toggle="tab" class="nav-link" aria-expanded="false">Change Bio</a></li>
                            <li class="nav-item"><a href="#LocalAddress" data-toggle="tab" class="nav-link" aria-expanded="false">Change Local Address</a></li>
                            @if($user->getTable() == "school")
                                <li class="nav-item"><a href="#add_material" data-toggle="tab" class="nav-link" aria-expanded="false">Add New Subject</a></li>
                                <li class="nav-item"><a href="#user_code" data-toggle="tab" class="nav-link" aria-expanded="false">Display user's Codes</a></li>
                            @endif
                            @if($user->getTable() == "teacher" || $user->getTable() == "student")
                                <li class="nav-item"><a href="#Grade" data-toggle="tab" class="nav-link" aria-expanded="false">Change Grade </a></li>
                                <li class="nav-item"><a href="#Subject" data-toggle="tab" class="nav-link" aria-expanded="false">Change Subject</a></li>
                            @endif
                            @if($user->getTable() == "parents")
                                <li class="nav-item"><a href="#add_child" data-toggle="tab" class="nav-link" aria-expanded="false">Add Child</a></li>
                            @endif
                            @if($user->getTable() == "student")
                                <li class="nav-item"><a href="#student_parent_code" data-toggle="tab" class="nav-link" aria-expanded="false">Display Parent's Code</a></li>
                            @endif
                            @if ($user->getTable() != "school")
                                <li class="nav-item"><a href="#Birthday" data-toggle="tab" class="nav-link" aria-expanded="false">Change Birthday</a></li>
                                <li class="nav-item"><a href="#Delete_account" data-toggle="tab" class="nav-link" aria-expanded="true">Delete Your Account</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 text-center" style="margin: 40px 0">
                <div class="tab-content">
                        <div style="max-width: 20rem;margin: auto" class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "name" ? "active": ''}}" id="Name">
                            <form role="form" method="post" action="{{route('EditName')}}">
                                @csrf
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="firstname" value="{{old('firstname')}}" id="FirstName" class="form-control">
                                    @error('firstname')
                                    <smal class="alert alert-danger">{{$message}}</smal>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="midname">Mid Name</label>
                                    <input type="text" name="midname" value="{{old('midname')}}" id="FullName" class="form-control">
                                    @error('midname')
                                    <smal class="alert alert-danger">{{$message}}</smal>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" value="{{old('lastname')}}" id="FullName" class="form-control">
                                    @error('lastname')
                                    <smal class="alert alert-danger">{{$message}}</smal>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary " value="Save" name="save_name" type="submit">
                                </div>
                            </form>
                        </div>
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "password" ? "active": ''}}" id="pass">
                            <form method="post" action="{{route('ChangePassword')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="OldPassword">Old Password</label>
                                    <input type="password" placeholder="at least 8 Characters" name="OldPass" id="OldPassword" class="form-control">
                                    @if(session()->has('errorPass'))
                                        <small class="alert alert-danger">{{session()->get('errorPass')}}</small>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="Password">New Password</label>
                                    <input type="password" placeholder="at least 8 Characters" name="password" id="Password" class="form-control">
                                    @error('password')
                                    <small class="alert alert-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="RePassword">Re-Password</label>
                                    <input type="password" placeholder="at least 8 Characters" name="password_confirmation" id="RePassword" class="form-control">
                                    @error('password_confirmation')
                                    <small class="alert alert-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Save" name="save_pass" class="btn btn-primary waves-effect waves-light w-md">
                                </div>
                            </form>
                        </div>
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "phone" ? "active": ''}}" id="Phone">
                            <form method="post" action="{{route('ChangePhone')}}">
                                @csrf
                                <div class="form-group">
                                    <p>Currently Phone : <b>{{$user->phone}}</b></p>
                                </div>
                                <div class="form-group">
                                    <label for="Phone">New Phone</label>
                                    <input type="text" name="phone" value="" id="Phone" class="form-control" placeholder="Your phone number must be 11 digits">
                                </div>
                                <div class="form-group">
                                    @error('phone')
                                    <small class="alert alert-danger text-center">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Save" name="save_phone" class="btn btn-primary waves-effect waves-light w-md">
                                </div>
                            </form>
                        </div>
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "email" ? "active": ''}}" id="Em">
                            <form method="post" action="{{route('ChangeEmail')}}">
                                @csrf
                                <div class="form-group">
                                    <p>Currently Email : <b>{{$user->email}}</b></p>
                                </div>
                                <div class="form-group">
                                    <label for="Email">New Email</label>
                                    <input type="email" name="email" value="{{$user->email}}" id="Email" class="form-control">
                                </div>
                                <div class="form-group">
                                    @error('email')
                                    <smail class="alert alert-danger text-center">{{$message}}</smail>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Save" name="save_email" class="btn btn-primary waves-effect waves-light w-md">
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "bio" ? "active": ''}}" id="Bio">
                            <div class="form-group">
                                <form action="{{route('BIO')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea name="bio" class="form-control">{{$user->bio}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        @error('bio')
                                        <small class="alert alert-danger text-center">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="save_profile" class="btn btn-primary btn-block" value="Save">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == 'image' ? ' active' : ''}}" id="Image">
                            <div class="form-group">
                                @error('imageProfile')
                                <div class="alert alert-danger text-center" role="alert">{{$message}}</div>
                                @enderror
                                <h2 class="text-center mb-3 mt-3">Update Image</h2>

                                <img src="{{"image/".$user->image}}" class="img-circle img-thumbnail upload_image" id="" alt="profile-image">
                                <div class="col text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        Upload photo
                                    </button>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload Photo</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <img src="{{"image/".$user->image}}" class="img-circle img-thumbnail upload_image" id="image_source" alt="profile-image">
                                                <form method="POST" action="{{route('EditImage')}}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" id="real-file" hidden="hidden" name="imageProfile"/>
                                                    <div class="row justify-content-center">
                                                        <button type='button'class="btn btn-primary" id='custom-button'>Choose A Photo</button>
                                                    </div>
                                                    <br>
                                                    <script type='text/javascript'>
                                                        const realFileBtn = document.getElementById('real-file');
                                                        const customBtn = document.getElementById('custom-button');
                                                        const image_place=document.getElementById('image_source');
                                                        customBtn.addEventListener('click', function () {
                                                            realFileBtn.click();
                                                        });
                                                        realFileBtn.addEventListener('change', function () {
                                                            const file = this.files[0];
                                                            if (file) {
                                                                const reader = new FileReader();
                                                                reader.addEventListener("load",function(){
                                                                    image_place.setAttribute("src",this.result);
                                                                    console.log(this);
                                                                });

                                                                reader.readAsDataURL(file);

                                                            }
                                                        });
                                                    </script>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <input type="submit" name="Up_photo" value="Upload" class="btn btn-primary">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="max-width: 20rem;margin: auto" class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "LocalAddress" ? "active": ''}}" id="LocalAddress">
                            <div class="form-group">
                                <div class="form-group">
                                    <p>Currently Local Address : <b>{{$user->getTable() == 'school' ? $user->location : $user->local_address}}</b></p>
                                </div>
                                <div class="form-group">
                                    <form method="POST" action="{{route('ChangeLocalAddress')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label>Local Address</label>
                                            <input type="text" name="localAddress" value="">
                                        </div>
                                        @error('localAddress')
                                        <div class="form-group text-center">
                                            <small class="alert alert-danger">{{$message}}</small>
                                        </div>
                                        @enderror
                                        <div class="form-group">
                                            <input type="submit" value="Save" name="LocalAddress" class="btn btn-primary waves-effect waves-light w-md">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @if($user->getTable() == 'parents')
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == 'add_child' ? ' active' : ''}}" id="add_child">
                            <form role="form" method="post" action="{{route('AddChild')}}">
                                <div class="form-group">
                                    <label>Child's Code</label>
                                    <input type="text" name="child_code" class="form-control" placeholder="The code must be 13 digits">
                                </div>
                                @error('child_code')
                                <div class="form-group text-center">
                                    <small class="alert alert-danger text-center">{{$message}}</small>
                                </div>
                                @enderror
                                <div class="form-group">
                                    <input class="btn btn-primary waves-effect waves-light w-md" value="Enter" name="add_child" type="submit">
                                </div>
                            </form>
                        </div>
                    @endif
                    @if ($user->getTable() == 'student')
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane" id="student_parent_code">
                            <div style="margin: 60px;" class="form-group text-center">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-header">Parents</div>
                                    <div class="card-body">
                                        <p class="card-text">Code : <b>{{$user->parent_code}}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($user->getTable() == 'student' || $user->getTable() == 'teacher')
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "ChangeSubject" ? "active": ''}}" id="Subject">
                            <div class="form-group change_subject">
                                <p> Your Subjects : <b>{{$user->subject}}</b></p>
                                @error('name')
                                <div class="form-group">
                                    <small class="alert alert-danger text-center">{{$message}}</small>
                                </div>
                                @enderror
                                @for ($i = 0; $i < count($errors->all()); $i++)
                                    @error('name'.$i)
                                    <div class="form-group">
                                        <small class="alert alert-danger text-center">{{$message}}</small>
                                    </div>
                                    @enderror
                                @endfor
                                <!-- Button trigger modal -->
                                <div class="">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#subject_for_student">
                                        Change Your Subjects
                                    </button>
                                </div>
                            </div>
                                <!-- Modal -->
                                <div class="modal fade" id="subject_for_student" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Subjects</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="add_subject">
                                                <form method="POST" action="{{route('ChangeSubject')}}">
                                                    @if($user->getTable()=='teacher')
                                                        @foreach (explode('/',$user->school->subject_name) as $subject)
                                                            <input type="radio" name="name" id='{{$subject}}' value='{{$subject}}'>
                                                            <label>{{$subject}}</label>
                                                        @endforeach
                                                    @elseif ($user->getTable()=='student')
                                                        @foreach (explode('/',$user->school->subject_name) as $subject)
                                                            <input type="checkbox" name="name[]" id='{{$subject}}' value='{{$subject}}'>
                                                            <label>{{$subject}}</label>
                                                        @endforeach
                                                    @endif
                                                    <input type="Submit" name="save_subjects" value="Submit" id="submit" class="btn btn-primary btn_submit" />
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "ChangeGrade" ? "active": ''}}" id="Grade">
                            <div class="form-group">
                                <p> Your Level : <b>{{$user->grade}}</b></p>
                                @error('grade')
                                <div class="form-group">
                                    <small class="alert alert-danger text-center">{{$message}}</small>
                                </div>
                                @enderror
                                <form method="POST" action="{{route('ChangeGrade')}}">
                                    <label> Change Your Grade</label>
                                    <select name="grade">
                                        <option>kindergarten 1 (KG)</option>
                                        <option>kindergarten 2 (KG)</option>
                                        <hr>
                                        <option>1st Primary</option>
                                        <option>2nd Primary</option>
                                        <option>3rd Primary</option>
                                        <option>4th Primary</option>
                                        <option>5th Primary</option>
                                        <option>6th Primary</option>
                                        <hr>
                                        <option>1st Preparatory</option>
                                        <option>2nd Preparatory</option>
                                        <option>3rd Preparatory</option>
                                        <hr>
                                        <option>1st Secondary</option>
                                        <option>2nd Secondary</option>
                                        <option>3rd Secondary</option>
                                    </select>
                                    <div class="form-group">
                                        <input type="submit" value="Save" name="save_grade" class="btn btn-primary waves-effect waves-light w-md">
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if($user->getTable() != 'school')
                        <div class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "birthday" ? "active": ''}}" id="Birthday">
                            <div class="form-group">
                                <div class="form-group">
                                    <p>Currently Birthday : <b>{{$user->birthday}}</b></p>
                                </div>
                                <div class="form-group">
                                    <form method="POST" action="{{route('ChangeBirthDay')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <select name="day">
                                                @for($i=1;$i <= 31; $i++)
                                                    <option>{{$i}}</option>
                                                @endfor
                                            </select>
                                            @error('day')
                                            <small class="alert alert-danger">{{$message}}</small>
                                            @enderror
                                            <select name="mon">
                                                @for($i=1;$i <= 12; $i++)
                                                    <option>{{$i}}</option>
                                                @endfor
                                            </select>
                                            @error('mon')
                                            <small class="alert alert-danger">{{$message}}</small>
                                            @enderror
                                            <select name="year">
                                                @for($i=1960;$i <= 2020; $i++)
                                                    <option>{{$i}}</option>
                                                @endfor
                                            </select >
                                            @error('year')
                                            <small class="alert alert-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="Save" name="save_birthday" class="btn btn-primary waves-effect waves-light w-md">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "delete" ? "active": ''}}" id="Delete_account">
                            <div class="form-group">
                                <form method="post" action="{{route('DeleteAccount')}}">
                                    @csrf
                                    <div class="form-group add_subject">
                                        <input style="display: inline;" type="radio" name="confirm" value="yes">
                                        <label>Are you wanna <b>delete</b> this Account ?</label>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Delete" name="Delete_account" class="btn btn-danger waves-effect waves-light w-md">
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if($user->getTable() == "school")
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane" id="user_code">
                            <div style="margin: 60px;" class="form-group text-center">

                                    <div class="card text-white bg-primary mb-3">
                                        <div class="card-header">Teacher</div>
                                        <div class="card-body">

                                            <p class="card-text">Code : <b>{{$user->te_reg_code}}</b></p>
                                        </div>
                                    </div>
                                    <div class="card text-white bg-secondary mb-3">
                                        <div class="card-header">Parent</div>
                                        <div class="card-body">

                                            <p class="card-text">Code : <b>{{$user->par_reg_code}}</b></p>
                                        </div>
                                    </div>
                                    <div class="card text-white bg-dark mb-3">
                                        <div class="card-header">Student</div>
                                        <div class="card-body">

                                            <p class="card-text">Code : <b>{{$user->st_reg_code}}</b></p>
                                        </div>
                                    </div>

                            </div>
                        </div>
                        <div style="max-width: 20rem;margin: auto"  class="tab-pane {{session()->has('tabPane') && session()->get('tabPane') == "addMaterial" ? "active": ''}}" id="add_material">
                                <div class="form-group">
                                    <p>Currently Subjects: <b>{{$user->subject_name}}</b></p>
                                </div>
                                @for ($i = 0; $i < count($errors->all()); $i++)
                                    @error('name'.$i)
                                        <div class="form-group">
                                            <small class="alert alert-danger text-center">{{$message}}</small>
                                        </div>
                                    @enderror
                                @endfor
                                <div class="form-group">
                                    <!-- Button trigger modal -->
                                    <div class="AddLanguagePage">
                                        <div class="container">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_new_material">
                                                Add More subjects
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="add_new_material" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add The All subjects</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="add_language">
                                                    <button name="add" id="add" class="btn btn-success btn_AddMore">Add More</button>
                                                    <form name="add_name" id="add_name" method="POST" action="{{route('addMaterial')}}">
                                                       @csrf
                                                        <table class="table" id="dynamic_field">
                                                            <tr>
                                                                <td><input type="text" name="name[]" id="name" placeholder="Enter The subject" class="form-control name_list"></td>
                                                                <td style="border:none;">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                        <input type="Submit" name="add_material" value="Submit" id="submit" class="btn btn-primary btn_submit" />
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            let i=1;
            $('#aadddd').click(function(){
                i++;
                $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" id="name" placeholder="Enter The subject" class="form-control name_list"></td><td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">Delete</button></td></tr>');
            });
            $(document).on('click','.btn_remove',function(){
                let button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });
        });
    </script>

@stop
