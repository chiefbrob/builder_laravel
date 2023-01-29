<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Template to base new applications from">

        <title>{{ config('app.name', 'BuilderLaravel') }}</title>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#317EFB"/>
        <link rel="apple-touch-icon" href="/images/180.png">
        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            <router-view style="min-height: 100vh;"/>
        </div>
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
        window.feature_flags = @json(\FriendsOfCat\LaravelFeatureFlags\FeatureFlagsForJavascript::get());
        window.User = @json(Auth::user());
        window.locale =  @json(\Illuminate\Support\Facades\App::currentLocale());
    </script>
    <script src="{{ mix('js/main.js') }}"></script>
    </body>
</html>
