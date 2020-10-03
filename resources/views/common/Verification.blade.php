@extends('layouts.HeadFileHtml')
@section('content_body')
@if (isset($success))
    <div class="alert alert-primary" role="alert" style="text-align: center">
        {{$success}}
    </div>
@elseif(isset($danger))
    <div class="alert alert-danger" role="alert" style="text-align: center">
        {{$danger}}
    </div>
@endif
<div class="card text-center">
    <div class="card-header">
        <h2>Verify Your Email</h2>
    </div>
    <div class="card-body">
        <h5 class="card-title">We have sent an Email to <b>{{$email}}</b></h5>

        <p class="card-text">You need to verify Your Email to continue.<br>You can also click on the resend button below to have another Verification Email.</p>
        <form method="get" action="{{route('CheckEmail')}}">
            <input class="btn btn-primary" type="submit" value="Check again and Continue">
        </form>
        <form method="get" action="{{route('SendEmail')}}">
            <input class="btn btn-success" type="submit" value="Resend">
        </form>
    </div>
</div>
@stop
