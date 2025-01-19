@extends('layouts.auth')
@section('title', 'login')

@section('content')
<div class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="flex w-full max-w-4xl shadow-lg rounded-lg overflow-hidden">
        <!-- Bagian Kiri -->
        <div class="w-1/2 bg-white flex flex-col items-center justify-center p-6">
            <img src="{{ route('image.show', ['filename'=>'assets\banner.png']) }}" alt="Logo" class="w-full h-auto mb-4">
            <h1 class="text-2xl font-bold">DIGIID</h1>
            <p class="text-gray-600 mt-2">Digital Identitas Indonesia</p>
        </div>

        <!-- Bagian Kanan -->
        <div class="w-1/2 bg-[#124868] text-white p-6 flex flex-col justify-center">
            <form action="{{ route('login.store') }}" method="post" class="space-y-6">
                @csrf
                <!-- Input Nama Lengkap -->
                <div class="form-control w-full">
                    <label for="username" class="label">
                        <span class="label-text text-gray-200">Masukkan Nama</span>
                    </label>
                    <input id="username" name="username" type="text" required
                        class="input input-bordered w-full rounded-lg bg-gray-200 text-gray-700"
                        placeholder="Masukkan Nama Lengkap">
                </div>

                <!-- Input Password -->
                <div class="form-control w-full">
                    <label for="password" class="label">
                        <span class="label-text text-gray-200">Masukkan Password</span>
                    </label>
                    <input id="password" name="password" type="password" required
                        class="input input-bordered w-full rounded-lg bg-gray-200 text-gray-700"
                        placeholder="Masukkan password">
                </div>

                <!-- Tombol Lanjutkan -->
                <button type="submit"
                    class="btn btn-primary w-full rounded-lg active:bg-blue-700 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors duration-300">
                    Lanjutkan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
