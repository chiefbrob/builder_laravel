<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Builder') }}</title>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script>
            window.feature_flags = @json(\FriendsOfCat\LaravelFeatureFlags\FeatureFlagsForJavascript::get());
            window.User = @json(Auth::user());
          </script>
    </head>
    <body>
        <div id="app" class="col-md-10 offset-md-1"><router-view></router-view></div>
    <script src="{{ mix('js/main.js') }}"></script>
    </body>
</html>