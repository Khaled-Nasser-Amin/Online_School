@extends('layouts.HeadFileHtml')
@section('content_body')
<div class="header">
    <div class="container">
        <div class="one">
            <a href="/Home">Online School</a>
            <a href="/Home"><i class="fas fa-school"></i></a>
        </div>

        <div class="two">
            <div class="icon">
                <a href="https://twitter.com/home"><i class="fab fa-twitter-square"></i></a>
                <a href="https://www.facebook.com/profile.php?id=100024236513092"><i class="fab fa-facebook-square"></i></a>
                <a href=""><i class="fab fa-linkedin"></i></a>
            </div>

            <div class="login">
                <a href="/Login">Login</a>
                <b>|</b>
                <div class="dropdown" style="width:auto; display:inline">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        SignUp As
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <ul >
                            <li><a class="ma" href="/SignUp/Student">Student</a></li>
                            <li><a class="ma" href="/SignUp/Teacher">Teacher</a></li>
                            <li><a class="ma" href="/SignUp/Parent">Parent</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="navbar">
    <div class="container">
        <ul>
            <li><a href="/Home">Home</a></li>
            <li><a href="/Support">Support</a></li>
            <li><a href="/About">About Us</a></li>
            <li><a href="/Contact">Contact Us</a></li>
        </ul>

    </div>
</div>
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

