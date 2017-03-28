<div class="social-sharing-icons">
    <a href="https://twitter.com/home?status={{ urlencode($article->title . ' ' . Request::url()) }}">
        @include('svgicons.social.twitter')
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}">
        @include('svgicons.social.facebook')
    </a>
    <a href="mailto:?&subject=Read&body={{ Request::url() }}">
        @include('svgicons.social.email')
    </a>
</div>