<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Digital Identity</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100 text-gray-900">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <header class="w-full bg-white shadow-md py-4">
                <div class="container mx-auto flex justify-between items-center px-6">
                    <h1 class="text-2xl font-bold text-gray-700">Digital Identity</h1>
                    <nav class="flex space-x-4">
                        @auth
                            @if (Auth::user()->role == 'dukcapil')
                                <a href="{{ url('/dashboard/dukcapil') }}" class="bg-gray-700 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">Dashboard</a>
                            @elseif (Auth::user()->role == 'citizen')
                                <a href="{{ url('/dashboard/citizen') }}" class="bg-gray-700 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">Dashboard</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-400">Log out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-gray-700 text-white font-bold py-2 px-4 rounded hover:bg-gray-600 text-xs ">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-400 text-xs ">Register</a>
                            @endif
                        @endauth
                    </nav>
                </div>
            </header>

            <main class="flex-1 w-full flex flex-col items-center justify-center text-center px-6">
                <h2 class="text-3xl font-bold text-gray-700 mb-4">Welcome to Digital Identity</h2>
                <p class="text-gray-600 mb-8">Securely manage your digital identity with our application.</p>
                <div class="flex space-x-4">
                    @auth
                        @if (Auth::user()->userable_type == 'dukcapil')
                            <a href="{{ url('/dashboard/dukcapil') }}" class="bg-gray-700 text-white font-bold py-2 px-6 rounded hover:bg-gray-600">Go to Dukcapil Dashboard</a>
                        @elseif (Auth::user()->userable_type == 'citizen')
                            <a href="{{ url('/dashboard/citizen') }}" class="bg-gray-700 text-white font-bold py-2 px-6 rounded hover:bg-gray-600">Go to Citizen Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="bg-gray-700 text-white font-bold py-2 px-6 rounded hover:bg-gray-600">Get Started</a>
                        <a href="{{ route('login') }}" class="bg-gray-500 text-white font-bold py-2 px-6 rounded hover:bg-gray-400">Log in</a>
                    @endauth
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 w-full max-w-4xl">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Enkripsi</h3>
                        <p class="text-gray-600">Data Anda dienkripsi untuk memastikan keamanan dan privasi.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Mudah Digunakan</h3>
                        <p class="text-gray-600">Aplikasi ini dirancang agar mudah digunakan oleh semua orang.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Aman</h3>
                        <p class="text-gray-600">Keamanan data Anda adalah prioritas utama kami.</p>
                    </div>
                </div>
            </main>

            <footer class="bg-gray-50 w-full py-4">
                <p class="text-gray-500 text-sm text-center">Digital Identity v1.0 &copy; {{ date('Y') }}</p>
            </footer>
        </div>
    </body>
</html>
