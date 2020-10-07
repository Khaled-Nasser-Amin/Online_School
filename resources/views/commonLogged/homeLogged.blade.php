@extends('layouts.HeaderLogged')
@section('navbar')
    @parent
@stop
@section('content')
    <hr>
    @if (session()->has('action') && session()->get('action') == 'clickBtn')
        <script>
            $(document).ready(function (){
                $('#Btn').click();
            });
        </script>
    @endif
    @if(session()->has('danger'))
        <div class="alert alert-primary" style="text-align: center">{{session()->get('danger')}}</div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-primary" style="text-align: center">{{session()->get('success')}}</div>
    @endif
    <div class="home">
        <div class="container">
            <div class="posts">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs edit_list card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="true">Students</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="teacher-tab" data-toggle="tab" href="#teacher" role="tab" aria-controls="teacher" aria-selected="false">Teachers</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="parent-tab" data-toggle="tab" href="#parent" role="tab" aria-controls="parent" aria-selected="false">Parents</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="school-tab" data-toggle="tab" href="#school" role="tab" aria-controls="school" aria-selected="false">Schools</a>
                            </li>
                        </ul>
                        <div class="upload_bttn">
                            <button id='Btn' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Say Something
                            </button>
                        </div>
                        <br>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Write a Post</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{route('SetPost')}}" enctype="multipart/form-data">
                                           @csrf
                                            <div class="add_photo">
                                                <input type="file" name="image" id="real-file" hidden="hidden">
                                                <button type='button' class="k"  id='custom-button'>Add Photo</button>
                                                <span id='custom-text'>No Photo chosen, yet.</span>
                                            </div>
                                            @error('image')
                                            <div class="text-center">
                                                <small class="alert alert-danger text-center">{{$message}}</small>
                                            </div>
                                            @enderror
                                            <script type='text/javascript'>
                                                const realFileBtn = document.getElementById('real-file');
                                                const customBtn = document.getElementById('custom-button');
                                                const customTxt = document.getElementById('custom-text');
                                                customBtn.addEventListener('click', function () {
                                                    realFileBtn.click();
                                                });
                                                realFileBtn.addEventListener('change', function () {

                                                    if (realFileBtn.value) {
                                                        customTxt.innerHTML = realFileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
                                                    } else {
                                                        customTxt.innerHTML = 'No file chosen yet.';
                                                    }
                                                });
                                            </script>
                                            <div class="write_post">
                                                <textarea type="textarea" name="post" placeholder="Say Something"></textarea>
                                            </div>
                                            @error('post')
                                            <div class="text-center">
                                                <small class="alert alert-danger text-center">{{$message}}</small>
                                            </div>
                                            @enderror
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <input type="submit" name="Upload" value="Upload" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                    <div class="card-body" >
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="home-tab">
                                <ul style=" padding: 0">
                                    @if ($student_posts != null)
                                        @foreach ($student_posts as $key => $post)
                                            <li>
                                                <div class="card text-white bg-dark mb-3">
                                                    <div class="card-header" style="text-align: left; display: inline;">
                                                    <span class="card-title" style="margin: 0; font-size:18px;">
                                                        <a href="{{route('profile',['id' => $post['user_id'],'type' => 'student'])}}">
                                                            <img style="margin-right:20px" src="{{asset('/image/'.$post['user_image'])}}" alt="..." class="rounded-circle">
                                                            {{$post['user_name']}}
                                                        </a>
                                                    </span>
                                                        @if ($post['user_id'] == $user->ID)
                                                            <a href="{{route('DeletePost',['number' => $key ,'id' => $user->ID , 'type' => $user->getTable()])}}" class="btn btn-danger" style="float: right;">Delete</a>
                                                        @endif
                                                        <br>
                                                        {{date($post['time'])}}                                                    </div>
                                                    <div class="card-body" style="min-height: 150px; text-align: left;">
                                                        <p class="card-text">{{$post['post']}}</p>
                                                        @if ($post['image'] != null)
                                                            <div class="post_image"><img src="{{asset('/image/'.$post['image'])}}"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="teacher" role="tabpanel" aria-labelledby="profile-tab">
                                <ul style=" padding: 0">
                                    @if ($teacher_posts != null)
                                        @foreach ($teacher_posts as $key => $post)
                                            <li>
                                                <div class="card text-white bg-dark mb-3">
                                                    <div class="card-header" style="text-align: left; display: inline;">
                                                    <span class="card-title" style="margin: 0; font-size:18px;">
                                                        <a href="{{route('profile',['id' => $post['user_id'],'type' => 'teacher'])}}">
                                                            <img style="margin-right:20px" src="{{asset('/image/'.$post['user_image'])}}" alt="..." class="rounded-circle">
                                                            {{$post['user_name']}}
                                                        </a>
                                                    </span>
                                                        @if ($post['user_id'] == $user->ID)
                                                            <a href="{{route('DeletePost',['number' => $key ,'id' => $user->ID , 'type' => $user->getTable()])}}" class="btn btn-danger" style="float: right;">Delete</a>
                                                        @endif
                                                        <br>
                                                        {{date($post['time'])}}
                                                    </div>
                                                    <div class="card-body" style="min-height: 150px; text-align: left;">
                                                        <p class="card-text">{{$post['post']}}</p>
                                                        @if ($post['image'] != null)
                                                            <div class="post_image"><img src="{{asset('/image/'.$post['image'])}}"></div>
                                                        @endif                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-pane fade " id="parent" role="tabpanel" aria-labelledby="contact-tab">
                                <ul style=" padding: 0">
                                    @if ($parents_posts != null)
                                        @foreach ($parents_posts as $key => $post)
                                            <li>
                                                <div class="card text-white bg-dark mb-3">
                                                    <div class="card-header" style="text-align: left; display: inline;">
                                                    <span class="card-title" style="margin: 0; font-size:18px;">
                                                        <a href="{{route('profile',['id' => $post['user_id'],'type' => 'parents'])}}">
                                                            <img style="margin-right:20px" src="{{asset('/image/'.$post['user_image'])}}" alt="..." class="rounded-circle">
                                                            {{$post['user_name']}}
                                                        </a>
                                                    </span>
                                                        @if ($post['user_id'] == $user->ID)
                                                            <a href="{{route('DeletePost',['number' => $key ,'id' => $user->ID , 'type' => $user->getTable()])}}" class="btn btn-danger" style="float: right;">Delete</a>
                                                        @endif
                                                        <br>
                                                        {{date($post['time'])}}                                                    </div>
                                                    <div class="card-body" style="min-height: 150px; text-align: left;">
                                                        <p class="card-text">{{$post['post']}}</p>
                                                        @if ($post['image'] != null)
                                                            <div class="post_image"><img src="{{asset('/image/'.$post['image'])}}"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="school" role="tabpanel" aria-labelledby="contact-tab">
                                <ul style=" padding: 0">
                                    @if ($school_posts != null)
                                        @foreach ($school_posts as $key => $post)
                                            <li>
                                                <div class="card text-white bg-dark mb-3">
                                                    <div class="card-header" style="text-align: left; display: inline;">
                                                    <span class="card-title" style="margin: 0; font-size:18px;">
                                                        <a href="{{route('profile',['id' => $post['user_id'],'type' => 'school'])}}">
                                                            <img style="margin-right:20px" src="{{asset('/image/'.$post['user_image'])}}" alt="..." class="rounded-circle">
                                                            {{$post['user_name']}}
                                                        </a>
                                                    </span>
                                                        @if ($post['user_id'] == $user->ID)
                                                            <a href="{{route('DeletePost',['number' => $key ,'id' => $user->ID , 'type' => $user->getTable()])}}" class="btn btn-danger" style="float: right;">Delete</a>
                                                        @endif
                                                        <br>
                                                        {{date($post['time'])}}                                                    </div>
                                                    <div class="card-body" style="min-height: 150px; text-align: left;">
                                                        <p class="card-text">{{$post['post']}}</p>
                                                        @if ($post['image'] != null)
                                                            <div class="post_image"><img src="{{asset('/image/'.$post['image'])}}"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
