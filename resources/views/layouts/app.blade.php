<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
</head>
<body>
    @component('navbar')
        Navbar
    @endcomponent

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
