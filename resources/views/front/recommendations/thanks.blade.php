@extends('front.base')

@section('content')
    @include('front.partials.standardheader')
    <div class="thanks-container">
        <h1><span>Congrats!</span></h1>
        <p class="thanks-sub-title">That's one less thing for you to worry about.</p>
        <p>Now it's up to us to get you a cracking list, and we aren't in the business of letting people down.</p>
        <p>We'll be in touch.</p>
        <div class="thaks-page-actions">
            <a class="action-button" href="/">Back to the site</a>
            <a class="action-button" href="/recommendations/signup">Add another guy</a>
        </div>
    </div>
@endsection