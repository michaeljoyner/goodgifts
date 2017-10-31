@extends('front.base')

@section('content')
    @include('front.partials.navbar')
    <div class="measure center-ns mh4">
        <h1 class="f3 f1-ns strong-font">Nicely done.</h1>
        <p class="f4">That's one less thing for you to worry about.</p>
        <p>Now it's up to us to get you a cracking list, and we aren't in the business of letting people down.</p>
        <p>We'll be in touch.</p>
        <div class="">
            <a class="inline-flex mt4 items-center ba bw2 pa2 strong-font ttu mr3 link col-d hov-p" href="/">Back to the site</a>
            <a class="inline-flex mt4 items-center ba bw2 pa2 strong-font ttu mr3 link col-d hov-p" href="/recommendations/signup">Add another guy</a>
        </div>
    </div>
@endsection