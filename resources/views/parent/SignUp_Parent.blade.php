@extends('layouts.layout')
@section('title','SignUp as a Parent')
@section('content')
    <div class="bar">
        <div class="container">
            <p>Sign Up as a Parent</p>
        </div>
    </div>

    <div class="formstudent">
        <div class="container">
            <form method="POST" action="{{route('Create_Parent')}}">
                @csrf
                <div class="one">
                    <label>First Name</label>
                    <input type="name" name="firstname">
                    @error('firstname')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Mid Name</label>
                    <input type="name" name="midname">
                    @error('midname')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Last Name</label>
                    <input type="name" name="lastname">
                    @error('lastname')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Email <i class="fas fa-envelope"></i></label>
                    <input type="Email" name="email">
                    @error('email')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Phone <i class="fas fa-mobile-alt"></i></label>
                    <input type="text" name="phone">
                    @error('phone')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Local Address <i class="fas fa-address-card"></i></label>
                    <input type="text" name="localaddress">
                    @error('localaddress')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Child Code</label>
                    <input type="text" name="child_code">
                    @error('child_code')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                </div>
                <div class="two">
                    <label>School Name</label>
                    <select name="schoolname">
                        <?php
                        $schoolName=\App\Models\School::select('name')->get();
                        foreach ($schoolName as $school){
                            echo "<option>".$school->name."</option>";
                        }
                        ?>
                    </select>
                    @error('schoolname')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Birthday</label>
                    <select name="day">
                        @for ($i = 1; $i <= 31 ; $i++)
                            <option>{{$i}}</option>
                        @endfor
                    </select>
                    @error('day')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <select name="mon">
                        @for ($i = 1; $i <= 12 ; $i++)
                            <option>{{$i}}</option>
                        @endfor
                    </select>
                    @error('mon')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <select name="year">
                        @for ($i = 1960; $i <= 2020 ; $i++)
                            <option>{{$i}}</option>
                        @endfor
                    </select>
                    @error('year')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Gender</label>
                    <select name="gender">
                        <option>male</option>
                        <option>female</option>
                    </select>
                    @error('gender')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Parent Registration Code</label>
                    <input type="text" name="schoolcode">
                    @error('schoolcode')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Password</label>
                    <input type="password" name="password">
                    @error('password')
                    <small class="alert alert-danger" role="alert">{{$message}}</small>
                    @enderror
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation">
                </div>

                <div class="three">
                    <input type="submit" name="submit" value="CREATE YOUR ACCOUNT">
                </div>
            </form>
        </div>
    </div>
@stop
