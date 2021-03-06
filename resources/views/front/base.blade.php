<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Good Gifts for Guys')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <link rel="stylesheet" href="{{ mix('css/fapp.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One|Droid+Serif" rel="stylesheet">
    @yield('head')
    <script>
        var Laravel = {
            csrfToken: '{{ csrf_token() }}'
        }
    </script>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <script charset="UTF-8" src="//cdn.sendpulse.com/28edd3380a1c17cf65b137fe96516659/js/push/34627b6bccbae17bbc28edb20d8c659f_1.js" async></script>
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1930525960496398'); // Insert your pixel ID here.
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1930525960496398&ev=PageView&noscript=1"
        /></noscript>
</head>
<body class="@yield('bodyclass', 'scripted') {{ $pageName ?? '' }} min-h-100 flex flex-column justify-between pt5 pt6-ns">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="main-container" id="app">
    @yield('content')
</div>
@include('front.partials.footer')
<script async src="{{ mix('js/front.js') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'AW-858669646');
</script>
@yield('bodyscripts')
@if(app()->environment('production'))
<script>
    window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
    ga('create','UA-51468211-10','auto');ga('send','pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-858669646"></script>
@endif

</body>
</html>