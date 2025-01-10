<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Digiidalgo | @yield('title')</title>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        @include('partials.citizen_sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('partials.navbar')

            <!-- Content -->
            <main class="p-6 bg-gray-100 flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
