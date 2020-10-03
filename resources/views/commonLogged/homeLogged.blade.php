@extends('layouts.HeaderLogged')
@section('navbar')
    @parent
@stop
@section('content')
    <hr>
    @if(session()->has('message'))
        <div class="alert alert-primary" style="text-align: center">{{session()->get('message')}}</div>
    @endif
    <div class="home">
        <div class="container">
            <div class="posts">
                <div class="card text-center">

                    <div class="card-header">
                        <ul class="nav nav-tabs edit_list card-header-tabs" id="myTab" role="tablist">

                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="student-tab" data-toggle="tab" href="#student" role="tab" aria-controls="student" aria-selected="true">Students</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="teacher-tab" data-toggle="tab" href="#teacher" role="tab" aria-controls="teacher" aria-selected="false">Teachers</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="parent-tab" data-toggle="tab" href="#parent" role="tab" aria-controls="parent" aria-selected="false">Parents</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="school-tab" data-toggle="tab" href="#school" role="tab" aria-controls="school" aria-selected="false">Schools</a>
                            </li>
                        </ul>

                        <div class="upload_bttn">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Say Something
                            </button>
                        </div>
                        <br>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Write a Post</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="home.php" enctype="multipart/form-data">
                                            <div class="add_photo">
                                                <input type="file" name="file" id="real-file" hidden="hidden">
                                                <button type='button'class="k" id='custom-button'>Add Photo</button>
                                                <span id='custom-text'>No Photo chosen, yet.Please Uplaod Photo</span>
                                            </div>
                                            <br>
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
                                            <div class="write_post">
                                                <textarea type="textarea" name="post" placeholder="Say Something"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" name="Upload" value="Upload" class="btn btn-primary">
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>

                    <div class="card-body" >
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="home-tab">
                                <ul style=" padding: 0">

                                </ul>
                            </div>

                            <div class="tab-pane fade" id="teacher" role="tabpanel" aria-labelledby="profile-tab">
                                <ul style=" padding: 0">

                                </ul>
                            </div>

                            <div class="tab-pane fade " id="parent" role="tabpanel" aria-labelledby="contact-tab">
                                <ul style=" padding: 0">

                                </ul>
                            </div>

                            <div class="tab-pane fade" id="school" role="tabpanel" aria-labelledby="contact-tab">
                                <ul style=" padding: 0">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
