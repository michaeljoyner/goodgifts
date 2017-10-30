<div class="tc mv4">
    <a class="col-p" href="https://twitter.com/home?status={{ urlencode($article->title . ' ' . Request::url()) }}">
        @include('svgicons.social.twitter', ['classNames' => 'h2 col-p hov-d'])
    </a>
    <a class="col-p" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}">
        @include('svgicons.social.facebook', ['classNames' => 'h2 col-p hov-d'])
    </a>
    <a class="col-p hov-d" href="mailto:?&subject=Read&body={{ Request::url() }}">
        @include('svgicons.social.email', ['classNames' => 'h2 col-p hov-d'])
    </a>
</div>