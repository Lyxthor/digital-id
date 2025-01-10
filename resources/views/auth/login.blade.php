@extends('layouts.auth')
@section('title', 'login')

@section('content')
<div class="container flex justify-center mx-auto">
    <div class="w-1/3 flex justify-center">
        <div class="card shadow-xl pt-5">
            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <div class="card-header pt-5 px-5">
                    <h1 class="font-bold text-center">Sign-in</h1>
                </div>
                <div class="card-body">
                    <div class="form-control mb-2">
                        <label for="username">username</label>
                        <input type="text" name="username" id="username" class="input input-sm input-bordered w-full">
                    </div>
                    <div class="form-control mb-2">
                        <label for="password">password</label>
                        <input type="password" name="password" id="password" class="input input-sm input-bordered w-full">
                    </div>
                    <div class="form-control">
                        <button class="w-full p-2 bg-blue-400 text-white rounded-md">Sign-in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
