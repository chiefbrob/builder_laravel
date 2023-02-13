<!DOCTYPE html>
<html lang="en">
<head>
    @include('header-links')
</head>
<body>
    @include('layouts.nav')
    <div class="container">
        <div class="row">

            <div class="col-md-10 offset-md-1">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
