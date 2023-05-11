<!DOCTYPE html>
<html lang="en">
<head>
    @include('header-links')
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h4>Livewire</h4>
            <livewire:counter />
        </div>
    </div>
</div>
@livewireScripts
</body>
</html>
