@extends('admin.base')

@section('content')
    <h1>Login</h1>
    <form action="/admin/login" method="POST">
        {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Email: </label>
            @if($errors->has('email'))
            <span class="error-message">{{ $errors->first('email') }}</span>
            @endif
            <input type="text" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">Password: </label>
            @if($errors->has('password'))
            <span class="error-message">{{ $errors->first('password') }}</span>
            @endif
            <input type="password" name="password" value="{{ old('password') }}" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Login</button>
        </div>
    </form>
@endsection
