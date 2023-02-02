<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">



        <title>{{ config('app.name') }}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ config('app.description') }}">
        <meta name="theme-color" content="{{ config('app.theme_color') }}"/>
        {{-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'"> --}}
        <meta name="application-name" content="{{ config('app.name') }}">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="manifest" href="/manifest.json">
        <link rel="apple-touch-icon" href="/images/180.png">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        @include('header-links')

    </head>
    <body>
        <div id="app"><router-view style="min-height: 100vh;"></router-view></div>
        @include('modals.session-expired')
    <script>
        // Check that service workers are supported
        if ('serviceWorker' in navigator) {
            // Use the window load event to keep the page load performant
            window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js');
            });
        }
    </script>
    <script>
        window.details = {
            name:  '{{ config('app.name') }}',
            description: '{{ config('app.description') }}',
        };
        window.feature_flags = @json(\FriendsOfCat\LaravelFeatureFlags\FeatureFlagsForJavascript::get());
        window.User = @json(Auth::user());
        window.locale =  @json(\Illuminate\Support\Facades\App::currentLocale());
    </script>
    <noscript>
        JavaScript is Disabled.
      </noscript>
    <script src="{{ mix('js/main.js') }}"></script>
    </body>
</html>
