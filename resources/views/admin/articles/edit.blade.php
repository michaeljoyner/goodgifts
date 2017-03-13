@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Edit "{{ $article->title }}"</h1>
        <div class="page-actions">
            <a href="/admin/articles/{{ $article->id }}" class="btn">Back</a>
        </div>
    </header>
    <section>
        @include('admin.forms.article')
    </section>
@endsection