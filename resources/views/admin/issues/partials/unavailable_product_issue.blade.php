@if($issue->issue->product)
<div class="unavailable-product-card">
    <img src="{{ $issue->issue->product->image }}" alt="">
    <p>{{ $issue->issue->product->title }}</p>
    <a href="/admin/products/{{ $issue->issue->product->id }}/swap" class="btn">Replace</a>
    <a href="{{ $issue->issue->product->link }}" class="btn" target="_blank">See on Amazon</a>
    <a href="/admin/products/{{ $issue->issue->product->id }}/similar" class="btn">Check Similar Shit</a>
</div>
@if($issue->issue->product->articles->count() > 0)
    <p>This product is associated with these articles:</p>
    <ul>
        @foreach($issue->issue->product->articles as $article)
            <li><a href="/admin/articles/{{ $article->id }}">{{ $article->title }}</a></li>
        @endforeach
    </ul>
@else
<p>The product is not associated with any articles. I suggest just deleting the product and then issue.</p>
@endif
@else
<p>The product no longer exists. Just delete the issue.</p>
@endif