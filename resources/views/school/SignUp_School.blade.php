@extends('layouts.layout')
@section('title','Create Your own School')
@section('content')

    <div class="bar">
        <div class="container">
            <p>Create your School</p>
        </div>
    </div>
    @if (Session::has('password_error'))
        <div class="alert alert-danger" role="alert" style="text-align: center">
            {{Session::get('password_error')}}
        </div>
    @endif
    <div class="formstudent">
        <div class="container">
            <form method="post" action="{{route('Create_School')}}">
                @csrf
                <div class="one">
                    <label>First Name</label>
                    <input type="text" name="firstname">
                    @error('firstname')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Mid Name</label>
                    <input  type="text" name="midname">
                    @error('midname')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>

                    @enderror
                    <label>Last Name</label>
                    <input type="text" name="lastname">
                    @error('lastname')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Phone <i class="fas fa-mobile-alt"></i></label>
                    <input type="text" name="phone" >
                    @error('phone')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                </div>
                <div class="two">
                    <label>Location <i class="fas fa-address-card"></i></label>
                    <input type="text" name="localaddress" >
                    @error('localaddress')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Email <i class="fas fa-envelope"></i></label>
                    <input type="Email" name="email" >
                    @error('email')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Password</label>
                    <input type="password" name="password" >
                    @error('password')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation">
                    @error('cpassword')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                </div>
                <div class="three">
                    <input type="submit" name="submit" value="CREATE YOUR SCHOOL">
                </div>
            </form>
        </div>
    </div>
@stop
