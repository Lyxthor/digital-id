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
    <form action="{{ route('image.store') }}" id="form" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" id="image">
        <button type="submit">text</button>
    </form>
    <div class="container mx-auto w-3/4">
        @yield('content')
        <button id="capture-btn" class="absolute top-0 left-0">Save</button>
    </div>
    <script>

    </script>
</body>
</html>
