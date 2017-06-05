@extends('front.base')

@section('title')
    Personalised Gift Lists
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogImage' => url('/images/assets/fb_image.png'),
        'ogTitle' => 'Get a Custom Gift List',
        'ogDescription' => 'Get a custom gift list'
    ])
@endsection

@section('content')
    @include('front.partials.standardheader')
    <section class="signup-page-main-section">
        <h1>Need help finding the perfect gift for him?</h1>
        <p>Worry not, we have your back.</p>
        <form class="signup-form" action="">
            <div class="form-section">
                <div class="form-text-box">
                    <h3>All About You</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores consectetur consequatur eius minima numquam quam.</p>
                </div>
                <div class="form-input-box">
                    <div class="form-group{{ $errors->has('sender') ? ' has-error' : '' }}">
                        <label for="sender">Your Name: </label>
                        @if($errors->has('sender'))
                        <span class="error-message">{{ $errors->first('sender') }}</span>
                        @endif
                        <input type="text" name="sender" value="{{ old('sender') }}" class="form-control">
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Your Email: </label>
                        @if($errors->has('email'))
                        <span class="error-message">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection