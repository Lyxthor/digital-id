@extends('layouts.auth')
@section('title', 'register')

@section('content')
<div class="py-16">
    <div class="flex bg-white rounded-lg shadow-lg items-center overflow-hidden mx-auto max-w-sm lg:max-w-4xl">
        <div class="hidden lg:block lg:w-1/2 bg-cover">
            <img src="{{ asset('images/image.png') }}" alt="register" class="object-cover w-full h-full">
        </div>
        <div class="w-full p-8 lg:w-1/2">
            <h2 class="text-2xl font-bold text-gray-700 text-center">REGISTER</h2>
            <p class="text-xl text-gray-600 text-center">DigiID</p>
            <form action="{{ route('register.store') }}" method="post" class="space-y-6">
                @csrf
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">NIK</label>
                    <input id="nik" name="nik" type="text" required
                        class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                        placeholder="Masukkan NIK">
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input id="email" name="email" type="email" required
                        class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                        placeholder="Masukkan email valid">
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input id="username" name="username" type="text" required
                        class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                        placeholder="Masukkan Username">
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">No. Telp</label>
                    <input id="mobile" name="mobile" type="text" required
                        class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                        placeholder="Masukkan No. Telp">
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input id="password" name="password" type="password" required
                        class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                        placeholder="Masukkan password">
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Token request Akun</label>
                    <input id="request_password" name="request_password" type="password" required
                        class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                        placeholder="Token Untuk cek request akun">
                </div>
                <div class="mt-8">
                    <button type="submit"
                        class="bg-gray-700 text-white font-bold py-2 px-4 w-full rounded hover:bg-gray-600">Lanjutkan</button>
                </div>
            </form>
            <div class="mt-4 flex items-center justify-between">
                <span class="border-b w-1/5 md:w-1/4"></span>
                <a href="{{ route('login') }}" class="text-xs text-gray-500 uppercase">Sudah punya akun? Login</a>
                <span class="border-b w-1/5 md:w-1/4"></span>
            </div>
        </div>
    </div>
</div>
@endsection
