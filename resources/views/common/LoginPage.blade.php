@extends('layouts.layout')
@section('title','Login Page')
@section('content')

    <div class="bar">
        <div class="container">
            <p>Login</p>
        </div>
    </div>
    @if (session()->has('danger'))
        <div class="alert alert-danger" style="text-align: center">{{session()->get('danger')}}</div>
    @endif
    <div class="form">
        <div class="container">
            <form method="post" action="{{route('check_login')}}">
                {{csrf_field()}}
                <input type="text" name="username" placeholder="Email address or Phone Number" value="{{ old('username') }}" >
                @error('email')
                <span class="invalid-feedback" role="alert" style="padding: 0;margin: 0;">
                    <strong style="padding: 0;margin: 0;">{{ $message }}</strong>
                </span>
                @enderror
                <input type="password" name="password" placeholder="password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" name="submit">
            </form>
            <a href="forget_password" name="submit">Forget Password?</a>
            <label>OR</label>
            <a href="signup" name="CREATE" class="btn btn-primary">CREATE ACCOUNT</a>
        </div>
    </div>
@stop
