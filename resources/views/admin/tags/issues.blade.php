@extends('admin.base')

@section('content')
    <header class="gg-page-header">
        <h1 class="header-title">Product and Tagging Issues</h1>
        <div class="page-actions">

        </div>
    </header>
    <section>
        <h2>The following products are missing tags:</h2>
        <ul class="list-group">
        @foreach($untagged as $product)
            <li class="list-group-item">
                <p>{{ $product->title }}</p>
                @foreach($product->articles as $article)
                <p>Appears in: <a href="/admin/articles/{{ $article->id }}">{{ $article->title }}</a></p>
                @endforeach
            </li>
        @endforeach
        </ul>
    </section>
    <section>
        <h2>The following article/product combos are missing their whats and whys</h2>
        <ul class="list-group">
        @foreach($unreasoned_suggestions as $suggestion)
            <li class="list-group-item">
                <p>{{ $suggestion->product->title }} appearing in <a
                            href="/admin/articles/{{ $suggestion->article->id }}">{{ $suggestion->article->title }}</a>
                </p>
            </li>
        @endforeach
        </ul>
    </section>
    <section>
        <h2>The following products are orphans</h2>
        <ul class="list-group">
            @foreach($orphans as $orphan)
            <li class="list-group-item">{{ $orphan->title }}</li>
            @endforeach
        </ul>
    </section>
@endsection