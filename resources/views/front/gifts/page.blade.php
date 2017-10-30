@extends('front.base', ['pageName' => ''])

@section('content')
    @include('front.partials.navbar')
    <header>
        <h1 class="f3 f1-ns strong-font tc">Find a Gift</h1>
        <p class="f5 f4-ns tc col-gr measure-wide lh-copy center-ns mh3">We mix your budget with his interests to serve up the best gift ideas.</p>
    </header>
    <gifts-app></gifts-app>


@endsection