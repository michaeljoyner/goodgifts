<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @section('title')
        <title>Good Gifts for Guys | Admin</title>
    @show
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    @yield('head')
    <script>
        var Laravel = {
            csrfToken: '{{ csrf_token() }}'
        }
    </script>
</head>
<body>
@if(Auth::check())
    @include('admin.partials.navbar')
@endif
<div class="container" id="app">
    @yield('content')
</div>
{{--<div class="main-footer"></div>--}}
<script src="{{ mix('js/app.js') }}"></script>
@include('admin.partials.flash')
@yield('bodyscripts')
</body>
</html>