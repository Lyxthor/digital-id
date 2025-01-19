<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <title>Digiid| @yield('title')</title>
</head>
<body class="bg-gray-100">
    @include('partials.alerts')
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform transition-transform lg:translate-x-0 lg:fixed lg:inset-0 h-full">
            <div class="p-4 bg-primary text-white">
                <h1 class="text-xl font-bold">Dukcapil Dashboard</h1>
                <!-- Close Button for Mobile -->
                <button
                    @click="sidebarOpen = false"
                    class="lg:hidden absolute top-4 right-4 text-white">
                    ✕
                </button>
            </div>
           @include('partials.dukcapil_sidebar')
        </div>
        <div class="fake-sidebar static h-full w-64">

        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="p-4 bg-white shadow-lg flex justify-between items-center fixed w-full z-10">
                <button
                    @click="sidebarOpen = true"
                    class="lg:hidden p-2 text-primary">
                    ☰
                </button>
                <h1 class="text-lg font-bold">DigiId</h1>
            </header>
            <div class="fake-header p-10 w-full">

            </div>

            <!-- Content -->
            <main class="p-6 bg-gray-100 flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
