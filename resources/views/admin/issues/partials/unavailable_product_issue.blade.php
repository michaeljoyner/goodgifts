<div class="product-admin-card">
    <img src="{{ $issue->product->image }}" alt="">
    <p>{{ $issue->product->title }}</p>
    @include('admin.partials.deletebutton', [
        'objectName' => $issue->product->title,
        'deleteFormAction' => '/admin/products/' . $issue->product->id
    ])
</div>
@if($issue->product->articles->count() > 0)
    <p>This product is associated with these articles:</p>
    <ul>
        @foreach($issue->product->articles as $article)
            <li><a href="/admin/articles/{{ $article->id }}">{{ $article->title }}</a></li>
        @endforeach
    </ul>
@endif