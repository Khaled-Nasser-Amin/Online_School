<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{URL::asset('css/bootstrapcss.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/font/font/css/all.min.css')}}">
    <script src="{{URL::asset('js/slim.js')}}" ></script>
    <script src="{{URL::asset('js/popper.js')}}" ></script>
    <script src="{{URL::asset('js/bootstrap.js')}}" ></script>
    <script src="{{URL::asset('js/jquery-3.5.0.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url::asset('css/css.css')}}">
</head>
<body>
@yield('content_body')
</body>
</html>
