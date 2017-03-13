<form action="/admin/articles/{{ $article->id }}" method="POST" class="form-horizontal">
    {!! csrf_field() !!}
    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="title">Title: </label>
        @if($errors->has('title'))
        <span class="error-message">{{ $errors->first('title') }}</span>
        @endif
        <input type="text" name="title" value="{{ old('title') ?? $article->title }}" class="form-control">
    </div>
    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="description">Description: </label>
        @if($errors->has('description'))
        <span class="error-message">{{ $errors->first('description') }}</span>
        @endif
        <textarea name="description" class="form-control">{{ old('description') ?? $article->description }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Save Changes</button>
    </div>
</form>