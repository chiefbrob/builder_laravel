<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>


        @include('header-links')

    </head>
    <body>
        <div id="app" style="overflow: hidden">
            <nav-root></nav-root>
            <router-view :key="$route.path"></router-view>
            <hr style="margin-top: 5em; border: 1px solid transparent;
            height: 0px;">
            <page-footer></page-footer>
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
        window.details = {
            name:  '{{ config('app.name') }}',
            description: '{{ config('app.description') }}',
            url: '{{ config('app.url') }}',
            email: '{{ config('app.email') }}',
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
