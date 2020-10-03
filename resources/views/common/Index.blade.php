@extends('layouts.layout')
@section('title','Home Page')
@section('content')
    @php
        function activeGuard(){
            foreach(array_keys(config('auth.guards')) as $guard){
                if(auth()->guard($guard)->check()) return $guard;
            }
        }
        $guardType=activeGuard();
        $user=Auth::guard($guardType)->user();
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    @endphp
    <div class="img">
        <div class="container">
            <p><span>Education is the </span><br>key to Success</p>
            <a href="SignUp/School"><button>Create your School</button></a>
        </div>
    </div>
    <pre>

</pre>

    <div class="welcome">
        <div class="container">
            <div class="one">
                <h3>Principal's Welcome</h3>
                <p> it is my pleasure to welcome to our website ,
                    a website where children are encouraged to
                    value intellectual growth and develop a love
                    of learning with a strong moral compass that
                    will guide them for the rest of their lives.
                </p>
            </div>
            <div class="two">
                <h3>Admission</h3>
                <p>The School welcomes students . students may
                    be considered for entry on a more flexible
                    basis. .We shall be very pleased to respond to
                    any query and to support you through the
                    application process.
                </p>
            </div>
        </div>
    </div>

@stop
