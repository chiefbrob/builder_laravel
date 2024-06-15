<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">



<title>{{ config('app.name') }}</title>

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="{{ config('app.description') }}">
<meta name="theme-color" content="{{ config('app.theme_color') }}"/>
{{-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'"> --}}
<meta name="application-name" content="{{ config('app.name') }}">
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link rel="manifest" href="/manifest.json">
<link rel="apple-touch-icon" href="/images/180.png">
@vite('resources/css/app.css')
<!-- Verify website ownership -->
<meta name="google-site-verification" content="verification_token"><!-- Google Search Console -->
<meta name="yandex-verification" content="verification_token"><!-- Yandex Webmasters -->
<meta name="msvalidate.01" content="verification_token"><!-- Bing Webmaster Center -->
<meta name="alexaVerifyID" content="verification_token"><!-- Alexa Console -->
<meta name="p:domain_verify" content="code_from_pinterest"><!-- Pinterest Console-->
<meta name="norton-safeweb-site-verification" content="norton_code"><!-- Norton Safe Web -->

<meta name="robots" content="index,follow"><!-- All Search Engines -->
<meta name="googlebot" content="index,follow"><!-- Google Specific -->

<!-- Tells Google not to show the sitelinks search box -->
{{-- <meta name="google" content="nositelinkssearchbox"> --}}

<!-- Tells Google not to provide a translation for this document -->
{{-- <meta name="google" content="notranslate"> --}}

{{-- <meta property="fb:app_id" content="123456789">
<meta property="og:url" content="https://example.com/page.html">
<meta property="og:type" content="website">
<meta property="og:title" content="Content Title">
<meta property="og:image" content="https://example.com/image.jpg">
<meta property="og:image:alt" content="A description of what is in the image (not a caption)">
<meta property="og:description" content="Description Here">
<meta property="og:site_name" content="Site Name">
<meta property="og:locale" content="en_US">
<meta property="article:author" content=""> --}}
<link href="/css/quill.snow.css" rel="stylesheet">

