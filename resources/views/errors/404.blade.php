@extends('front.base')

@section('content')
    @include('front.partials.standardheader')
    <div class="thanks-container">
        <h1>Oh no!<br> It's a four-oh-four.</h1>
        <p class="thanks-sub-title">That means something is missing.</p>
        <p>Or the thing that you are looking for is no longer here. If that is the case, please accept our humblest apologies. Maybe have a look around and you might just find something else worth your precious time.</p>
        <p>Have a great day.</p>
        <div class="thaks-page-actions">
            <a class="action-button" href="/">Check out the home page</a>
            <a class="action-button" href="/recommendations/signup">Get a custom gift list</a>
        </div>
    </div>
@endsection