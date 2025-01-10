<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Digiidalgo | @yield('title')</title>
</head>
<body>
    <div class="container mx-auto w-3/4">
        @include('partials.dukcapil_header')
        @yield('content')
    </div>
</body>
</html>
