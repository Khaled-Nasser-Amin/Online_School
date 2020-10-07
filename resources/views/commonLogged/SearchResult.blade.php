@extends('layouts.HeaderLogged')
@section('nav')
    @parent
@stop
@section('content')
    <hr>
    <div class="search_page">
        <div class="container">
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
                </div>

                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="home-tab">
                            <ul>
                                @forelse($students as $student)
                                    <div class="alert alert-light" role="alert">
                                        <li class="lan"><span><a href="{{route('profile',['id' => $student->ID,'type'=>'student'])}}"><img src="{{asset('/image/'.$student->image)}}" alt="..." class="rounded-circle">{{$student->first_name.' '.$student->last_name}}</a></span></li>
                                    </div>
                                @empty
                                    <div style="text-align:center;" class="alert alert-light" role="alert">No such results</div>
                                @endforelse
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="teacher" role="tabpanel" aria-labelledby="profile-tab">
                            <ul>
                                @forelse($teachers as $teacher)
                                    <div class="alert alert-light" role="alert">
                                        <li class="lan"><span><a href="{{route('profile',['id' => $teacher->ID,'type'=>'teacher'])}}"><img src="{{asset('/image/'.$teacher->image)}}" alt="..." class="rounded-circle">{{$teacher->first_name.' '.$teacher->last_name}}</a></span></li>
                                    </div>
                                @empty
                                    <div style="text-align:center;" class="alert alert-light" role="alert">No such results</div>
                                @endforelse
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="parent" role="tabpanel" aria-labelledby="contact-tab">
                            <ul>
                                @forelse($parents as $parent)
                                    <div class="alert alert-light" role="alert">
                                        <li class="lan"><span><a href="{{route('profile',['id' => $parent->ID,'type'=>'parents'])}}"><img src="{{asset('/image/'.$parent->image)}}" alt="..." class="rounded-circle">{{$parent->first_name.' '.$parent->last_name}}</a></span></li>
                                    </div>
                                @empty
                                    <div style="text-align:center;" class="alert alert-light" role="alert">No such results</div>
                                @endforelse
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="school" role="tabpanel" aria-labelledby="contact-tab">
                            <ul>
                                @forelse($schools as $school)
                                    <div class="alert alert-light" role="alert">
                                        <li class="lan"><span><a href="{{route('profile',['id' => $school->ID,'type'=>'school'])}}"><img src="{{asset('/image/'.$school->image)}}" alt="..." class="rounded-circle">{{$school->name}}</a></span></li>
                                    </div>
                                @empty
                                    <div style="text-align:center;" class="alert alert-light" role="alert">No such results</div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
