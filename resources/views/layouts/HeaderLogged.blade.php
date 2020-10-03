@extends('layouts.HeadFileHtml')
@section('content_body')
    <div class="header">
        <div class="container">
            <div class="one">
                <a href="{{route('home')}}">Smart School</a>
                <a href="{{route('home')}}"><i class="fas fa-school"></i></a>
            </div>
            <div class="two">
                <div class="icon">
                    <a href="https://twitter.com/home"><i class="fab fa-twitter-square"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=100024236513092"><i class="fab fa-facebook-square"></i></a>
                    <a href=""><i class="fab fa-linkedin"></i></a>

                </div>
                <div class="loged">
                    <div class="pic">
                        <div class="image">
                            <img src="{{asset('image/'.$user->image)}}" alt='...' class='rounded-circle'>
                        </div>
                        <a href="">
                            @if (isset($user->name))
                                {{$user->name}}
                            @else
                                {{$user->first_name." ".$user->last_name}}
                            @endif
                        </a>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Setting
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <ul >
                                <li><a class="ma" href="{{route('Edit')}}">Edit profile</a></li>
                                <li><a class="ma" href="{{route('logout')}}">Logout</a></li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @section('navbar')
        <div class="navbar">
            <div class="container">
                <ul>
                    <!-- subject for teacher and student -->
                    @if ($user->getTable() == "student" || $user->getTable() =="teacher")
                    <li>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Material
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <ul >
                                    <div class="material">
                                        @forelse (explode('/',$user->subject) as $subject)
                                            <li ><span class="lan"><i class="fas fa-caret-down"></i>{{$subject}}</span>
                                                <ul class="ul">
                                                    <li><a  href="">Attendance</a></li>
                                                    <li><a  href="">Grades sheet</a></li>
                                                    <li><a href="">RoadMap</a></li>
                                                    <li><a href="">Assignment</a></li>
                                                    <li><a href="">Lessons</a></li>
                                                </ul>
                                            </li>
                                        @empty
                                                <li ><span class="lan"><i class="fas fa-caret-down"></i>No subject</span>
                                        @endforelse
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </li>
                   @elseif ($user->getTable() == "school")
                    <li>
                        <div class="dropdown">

                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Users
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <ul >
                                    <li class="lan"><span><a href="">Teachers</a></span></li>
                                    <li class="lan"><span><a href="">Students</a></span></li>
                                    <li class="lan"><span><a href="">Parents</a></span></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @elseif($user->getTable() == "parent")
                    <li>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select Child
                            </button>
                            <div class="dropdown-menu select_child" aria-labelledby="dropdownMenuButton">
                                <ul >
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown">

                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Materials
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <ul >
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif
                    <li><a href="">Home</a></li>
                    <li><a href="">Events</a></li>
                    <li><a href="">Support</a></li>
                    <li><a href="">About Us</a></li>
                    <li><a href="">Contact Us</a></li>
                </ul>
                <div class="search-box">
                    <form method="get" action="search_result.php" name="test">
                        <input type="text" name="name" placeholder=" Type here" class="search-text" id="search_text" onchange="search()">
                        <a href="" class="search-btn" id="bttn"><i class='fas fa-search'></i></a>
                    </form>

                </div>
            </div>
        </div>

        <script>
            function search(){
                var btn= document.getElementById('bttn');
                var txt= document.getElementById('search_text');
                btn.href="search_result.php?name="+txt.value;
            }
            // enter key to submit serch icon
            document.onkeydown=function(evt){
                var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
                if(keyCode == 13)
                {
                    //your function call here
                    document.test.submit();
                }
            }
        </script>

    @show


    @yield('content')

    <div class="copy">
        <div class="container">
            <div class="one">
                <i class="fas fa-phone"></i>
                <p>Tel : 01025070424</p>
            </div>
            <div class="two">
                <i class="fas fa-envelope"></i>
                <p>khalednasser546@gmail.com</p>
            </div>
            <div class="three">
                <i class="far fa-copyright"></i>
                <p>2020 Smart School System</p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("a[href*='000webhost']").parent().remove();
        });
    </script>

@stop
