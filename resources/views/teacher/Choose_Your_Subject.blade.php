@extends('layouts.HeaderLogged')
@section('navbar')
@stop
@section('content')
    @if (session()->has('danger'))
        <dev class="alert alert-danger" style="margin: 0 auto;text-align: center;display: block">{{session()->get('danger')}}</dev>
    @endif
    @for ($i = 0; $i < count($errors->all()); $i++)
        @error('name.'. $i)
        <div class="alert alert-danger" style="margin: 0 auto;text-align: center;display: block">{{ $message }}</div>
        @enderror
    @endfor
    <div class="AddLanguagePage">
        <div class="container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Choose Your Subjects
            </button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Subjects</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="add_subject">
                    <form method="POST" action="{{route('Choose_Your_Subject')}}">
                        @csrf
                        @foreach (explode('/',$user->school->subject_name) as $subject)
                            <input type="radio" name="name" id='{{$subject}}' value='{{$subject}}'>
                            <label>{{$subject}}</label>
                        @endforeach
                        <input type="Submit" name="submit" value="Submit" id="submit" class="btn btn-primary btn_submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("a[href*='000webhost']").parent().remove();
        });
    </script>

@stop
