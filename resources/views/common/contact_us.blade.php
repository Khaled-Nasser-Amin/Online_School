@extends('layouts.layout')
@section('title','Contact Us')
@section('content')
    <hr>
    <div class="contact">
        <div class="container">
            <h1>Contact Us</h1>
            <p>You can find us on our social networks
                Facebook, Twitter & Instagram.
                Along with meeting us in person during
                our Open Days.
            </p>
        </div>
    </div>

    <div class="contactform">
        <div class="container">
            <center>
                <form>

                    <label>Name*</label>
                    <input type="name" name="name">
                    <br>
                    <label>Email*</label>
                    <input type="Email" name="Email">
                    <br>
                    <label>Message*</label>
                    <textarea></textarea>
                    <br>
                    <button>Submit</button>
                </form>
            </center>
        </div>
    </div>
@stop
