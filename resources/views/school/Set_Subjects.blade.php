@extends('layouts.HeaderLogged')
@section('navbar')
@stop
@section('content')

<!-- modal -->
<div class="AddLanguagePage">
    <div class="container">
        @if (session()->has('danger'))
            <dev class="alert alert-danger" style="margin: 0 auto;text-align: center;display: block">{{session()->get('danger')}}</dev>
        @endif
        @for ($i = 0; $i < count($errors->all()); $i++)
                @error('name.'. $i)
                <div class="alert alert-danger" style="margin: 0 auto;text-align: center;display: block">{{ $message }}</div>
                @enderror
        @endfor

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add The subjects
        </button>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add The All subjects</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="add_language">
                <button name="add" id="add" class="btn btn-success btn_AddMore">Add More</button>

                <form name="add_name" id="add_name" method="POST" action="{{route('Set_Subjects')}}">
                    @csrf
                    <table class="table" id="dynamic_field">
                        <tr>
                            <td><input type="text" name="name[]" id="name" placeholder="Enter The subject" class="form-control name_list"></td>
                            <td style="border:none;">&nbsp;</td>
                        </tr>
                    </table>
                    <input type="Submit" name="submit" value="Submit" id="submit" class="btn btn-primary btn_submit" />
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" id="name" placeholder="Enter The subject" class="form-control name_list"></td><td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">Delete</button></td></tr>');
        });
        $(document).on('click','.btn_remove',function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
        $("a[href*='000webhost']").parent().remove();
    });
</script>
@stop
