<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('header-links')

</head>
<body>
    <div id="app">
        @include('layouts.nav')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script>
        window.feature_flags = @json(\FriendsOfCat\LaravelFeatureFlags\FeatureFlagsForJavascript::get());
        window.User = @json(Auth::user());
    </script>
    <script>
        // Check that service workers are supported
        if ('serviceWorker' in navigator) {
          // Use the window load event to keep the page load performant
          window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js');
          });
        }
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
