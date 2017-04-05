@if($issue->issue->products()->count())
    <p>The following products never updated due to incomplete lookup</p>
    <ul class="list-group">
        @foreach($issue->issue->products() as $product)
            <li class="list-group-item">{{ $product->title }}</li>
            @if($product->articles->count() > 0)
                <ul class="list-group">
                    @foreach($product->articles as $article)
                        <li class="list-group-item"><a href="/admin/articles/{{ $article->id }}">{{ $article->title }}</a></li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    </ul>
    <form action="/admin/issues/incompleteupdate/{{ $issue->issue->id }}/resolve" method="POST">
        {!! csrf_field() !!}
        <button class="btn btn-red">Attempt to Resolve</button>
    </form>
@endif