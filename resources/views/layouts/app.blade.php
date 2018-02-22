<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
</head>
<body>
    @component('navbar')
        Navbar
    @endcomponent

    <div class="container is-widescreen" id="app">
        @yield('content')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
