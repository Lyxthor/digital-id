<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/capture.js'])
    <title>Digiidalgo | @yield('title')</title>
</head>
<body>
    <div class="container mx-auto w-3/4">
        @yield('content')
        <div class="w-full h-full absolute top-0 left-0 flex justify-center items-center">
            <button id="capture-btn" class="px-5 py-2 bg-blue-400 text-white rounded-md">Save</button>
        </div>
    </div>
    <script>

    </script>
</body>
</html>
