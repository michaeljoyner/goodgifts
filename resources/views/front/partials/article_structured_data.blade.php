<script type="application/ld+json">
    {
  "@context": "http://www.schema.org",
  "@type": "Article",
  "name": "{{ $article->title }}",
  "alternateName": "{{ $article->title }}",
  "url": "{{ request()->fullUrl() }}",
  "dateModified": "{{ $article->lastUpdated()->format('Y-m-d') }}",
  "author": "Good Gifts for Guys",
  "datePublished": "{{ $article->published_on->format('Y-m-d') }}",
  "headline": "{{ $article->title }}",
  "image": {
    "@type": "ImageObject",
    "url": "{{ url($article->titleImage('web')) }}",
    "height": "800px",
    "width": "500px"
  },
  "publisher": {
    "@type": "Organization",
    "url": "http://goodgiftsforguys.com",
    "logo": {
      "@type": "ImageObject",
      "url": "http://goodgiftsforguys.com/images/logos/glogo.png"
    },
    "name": "Good Gifts for Guys"
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "http://goodgiftsforguys.com"
  }
}
</script>