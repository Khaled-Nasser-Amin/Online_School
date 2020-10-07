@extends('layouts.HeaderLogged')
@section('navbar')
    @parent
@stop
@section('content')
    <hr>
    {{session()->get('action')}}
    @if (session()->has('action') && session()->get('action') == 'clickBtn')
        {{session()->get('action')}}
        <script>
            $(document).ready(function (){
                $('#addEvent').click();
            });
        </script>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success text-center" style="text-align: center">{{session()->get('success')}}</div>
    @endif
    @if(session()->has('danger'))
        <div class="alert alert-danger text-center" style="text-align: center">{{session()->get('danger')}}</div>
    @endif

    <div class="teacherInfo event">
        <div class="container">
            <div class="assi">
                <h1>Events</h1>
                @if ($user->getTable() == 'school')
                <div>
                    <button id='addEvent' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Add Event
                    </button>
                </div>
                @endif
                <br>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('SetEvent')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="add_photo">
                                        <input type="file" name="image" id="real-file" hidden="hidden">
                                        <button type='button' class="k" id='custom-button'>Add Photo</button>
                                        <span id='custom-text'>No Photo chosen, yet.Please Uplaod Photo</span>
                                    </div>
                                    @error('image')
                                        <div class="text-center">
                                            <small class="alert alert-danger text-center">{{$message}}</small>
                                        </div>
                                    @enderror
                                    <script type='text/javascript'>
                                        const realFileBtn = document.getElementById('real-file');
                                        const customBtn = document.getElementById('custom-button');
                                        const customTxt = document.getElementById('custom-text');
                                        customBtn.addEventListener('click', function () {
                                            realFileBtn.click();
                                        });
                                        realFileBtn.addEventListener('change', function () {

                                            if (realFileBtn.value) {
                                                customTxt.innerHTML = realFileBtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
                                            } else {
                                                customTxt.innerHTML = 'No file chosen yet.';
                                            }
                                        });
                                    </script>
                                    <div class="add_description">
                                        <label>Title</label>
                                        <input type="text" name="title" placeholder="Write Event's Title">
                                        @error('title')
                                            <div class="text-center">
                                                <small class="alert alert-danger text-center">{{$message}}</small>
                                            </div>
                                        @enderror
                                        <label>Start Date</label>
                                        <input type="date" name="start_date">
                                        @error('start_date')
                                        <div class="text-center">
                                            <small class="alert alert-danger text-center">{{$message}}</small>
                                        </div>
                                        @enderror
                                        <label>End Date</label>
                                        <input type="date" name="end_date">
                                        @error('end_date')
                                            <div class="text-center">
                                                <small class="alert alert-danger text-center">{{$message}}</small>
                                            </div>
                                        @enderror
                                        <textarea type="textarea" name="description" placeholder="Write the Description"></textarea>
                                        @error('description')
                                            <div class="text-center">
                                                <small class="alert alert-danger text-center">{{$message}}</small>
                                            </div>
                                        @enderror
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" name="Upload_Event" value="Upload">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    @forelse($data as $event)
                        <div class="event_card">
                            <div class="card" style="width: 18rem;">
                                <img src="image/{{$event['image']}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h4 class="card-title"><b>{{$event['title']}}</b></h4>
                                    <p class="card-text">Start Date : {{$event['start_date']}} </p>
                                    <p class="card-text">End Date : {{$event['end_date']}}</p>
                                    <p class="card-text description">Description : {{$event['description']}}</p>
                                    @if ($user->getTable() == 'school')
                                        <a href="{{route('DeleteEvent',['id' => $event['event_id'],'name'=>$event['event_file_name'] ,'image'=>$event['image']])}}" class="btn btn-danger">Delete Event</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div>

@stop
