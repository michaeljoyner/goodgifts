@extends('front.base')

@section('content')
    @include('front.partials.navbar')
    <div class="mw7 mh3 center-ns">
        <h1 class="f2 f1-ns strong-font">Oh no!<br> It's a four-oh-four.</h1>
        <p class="thanks-sub-title">That means something is missing.</p>
        <p>Or the thing that you are looking for is no longer here. If that is the case, please accept our humblest apologies. Maybe have a look around and you might just find something else worth your precious time.</p>
        <p>Have a great day.</p>
        <div class="">
            <a class="inline-flex mt4 items-center ba bw2 pa2 strong-font ttu mr3 link col-d hov-p" href="/">Check out the home page</a>
            <a class="inline-flex mt4 items-center ba bw2 pa2 strong-font ttu mr3 link col-d hov-p" href="/recommendations/signup">Get a custom list</a>
        </div>
    </div>
@endsection