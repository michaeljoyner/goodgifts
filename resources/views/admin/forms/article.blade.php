<form action="/admin/articles/{{ $article->id }}" method="POST" class="form-horizontal">
    {!! csrf_field() !!}
    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="title">Title: </label>
        @if($errors->has('title'))
        <span class="error-message">{{ $errors->first('title') }}</span>
        @endif
        <input type="text" name="title" value="{{ old('title') ?? $article->title }}" class="form-control">
    </div>
    <div class="form-group{{ $errors->has('target') ? ' has-error' : '' }}">
        <label for="target">Target: </label>
        @if($errors->has('target'))
        <span class="error-message">{{ $errors->first('target') }}</span>
        @endif
        <input type="text" name="target" value="{{ old('target') ?? $article->target }}" class="form-control">
    </div>
    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="description">Description: </label>
        @if($errors->has('description'))
        <span class="error-message">{{ $errors->first('description') }}</span>
        @endif
        <textarea name="description" class="form-control">{{ old('description') ?? $article->description }}</textarea>
    </div>
    <div class="form-group{{ $errors->has('intro') ? ' has-error' : '' }}">
        <label for="intro">Intro: </label>
        @if($errors->has('intro'))
        <span class="error-message">{{ $errors->first('intro') }}</span>
        @endif
        <textarea name="intro" class="form-control">{{ old('intro') ?? $article->intro }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Save Changes</button>
    </div>
</form>