@extends('layouts.HeaderLogged')
@section('navbar')
    @parent
@stop
@section('content')
    <hr>
    <div class="text-center card-box">
        <div class="member-card">
            <div class="thumb-x1 member-thumb m-b-10 center-block">
                <img src="{{asset('/image/'.$user_data->image)}}" class="img-circle img-thumbnail profile_image" alt="profile-image">
                <div class="">
                    <h4 class="m-b-5">{{$type != 'school' ? $user_data->first_name : ''}}</h4><br>
                    <br>BIO<br>{{$user_data->bio}}<br><br>
                </div>
                <div class="text-center m-t-40">
                    <p class="text-muted font-13"><strong>Name :</strong> <span class="m-l-15">{{$type != 'school' ? $user_data->first_name.' '.$user_data->last_name : $user_data->name}}</span></p>
                    <p class="text-muted font-13"><strong>Mobile :</strong><span class="m-l-15">{{$user_data->phone}}</span></p>
                    <p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15">{{$user_data->email}}</span></p>
                    <p class="text-muted font-13"><strong>Location :</strong> <span class="m-l-15">{{$type != 'school' ? $user_data->local_address: $user_data->location}}</span></p>
                    @if($type != 'school')
                    <p class="text-muted font-13"><strong>School Name : </strong><span class="m-l-15">{{$user_data->school_name}}</span></p>
                    <p class="text-muted font-13"><strong>Birthday :</strong> <span class="m-l-15">{{$user_data->birthday}}</span></p>
                    @endif
                    @if($type != 'parents')
                    <p class="text-muted font-13"><strong>Subjects :</strong> <span class="m-l-15">{{$type == 'school' ? $user_data->subject_name : $user_data->subject}}</span></p>
                    @endif
                    @if($type == 'student' || $type == 'teacher')
                    <p class="text-muted font-13"><strong>Level :</strong> <span class="m-l-15">{{$user_data->grade}}</span></p>
                    @endif
                    @if($type == 'student')
                    <p class="text-muted font-13"><strong>Parent :</strong> <span class="m-l-15">
                        <a href="{{route('profile',['id' =>$user_data->parent_id,'type' => 'parents'])}}">{{$user_data->parents->first_name.' '.$user_data->parents->last_name}}</a></span></p>
                    @endif
                    @if($type == 'school')
                    <p class="text-muted font-13"><strong>Total Num of Students :</strong><span class="m-l-15">{{count($user_data->student)}}</span></p>
                    <p class="text-muted font-13"><strong>Total Num of Teachers :</strong> <span class="m-l-15">{{count($user_data->teacher)}}</span></p>
                    <p class="text-muted font-13"><strong>Total Num of Parents :</strong><span class="m-l-15">{{count($user_data->parents)}}</span></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="home" >
        <div class="card-body container text-center posts" id="myTabContent">
            <ul style=" padding: 0">
                @if ($data_posts != null)
                    @foreach ($data_posts as $key => $post)
                        @if ($post['user_id'] == $user_data->ID)
                            <li>
                                <div class="card text-white bg-dark mb-3" >
                                    <div class="card-header" style="text-align: left; display: inline;">
                                    <span class="card-title" style="margin: 0; font-size:18px;">
                                        <a href="{{route('profile',['id' => $post['user_id'],'type' => 'student'])}}">
                                            <img style="margin-right:20px" src="{{asset('/image/'.$post['user_image'])}}" alt="..." class="rounded-circle">
                                            {{$post['user_name']}}
                                        </a>
                                    </span>
                                        @if ($post['user_id'] == $user->ID)
                                            <a href="{{route('DeletePost',['number' => $key ,'id' => $user->ID , 'type' => $user->getTable()])}}"class="btn btn-danger" style="float: right;">Delete</a>
                                        @endif
                                        <br>
                                        {{date($post['time'])}}
                                    </div>
                                    <div class="card-body" style="min-height: 150px; text-align: left;">
                                        <p class="card-text">{{$post['post']}}</p>
                                        @if ($post['image'] != null)
                                            <div class="post_image"><img src="{{asset('/image/'.$post['image'])}}"></div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@stop
