@extends('layouts.HeadFileHtml')
@section('content_body')
<div class="card text-center">
    <div class="card-header">
        <h2>Verify Your Email</h2>
        <h5>Dear {{$name}}</h5>
    </div>
    <div class="card-body">
        <p class="card-text">You need to verify Your Email to continue.</p>
        <form class="d-inline" method="GET" action="{{route('VerifyEmail')}}">
            @csrf
            <input class="btn btn-success" type="submit" value="Click Here to Verify your Account" >
        </form>

    </div>
</div>
@stop
