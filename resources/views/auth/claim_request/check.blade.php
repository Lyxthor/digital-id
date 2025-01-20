@extends('layouts.auth')
@section('title', 'login')

@section('content')
<div class="bg-gray-100 h-screen flex items-start justify-center">
    <div class="container flex justify-center">
        <div class="w-1/3">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-end flex-wrap">

                        <div>
                            <div class="flex items-end gap-5">
                                <div>
                                    <h2 class="card-title font-bold">View Request</h2>
                                    <span class="text-xs mb-6 text-slate-500">Enter the password to see your request</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('login') }}" class="btn btn-success">Back to login</a>
                        </div>
                    </div>
                    <form action="{{ route('register.check') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Token</span>
                                </div>
                                <input type="text" name="token" id="token" class="input input-bordered w-full" autocomplete="off">
                            </label>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Password</span>
                                </div>
                                <input name="password" type="password" id="memberSearchField" class="input input-bordered w-full" autocomplete="off">
                            </label>
                        </div>
                        <div class="card-actions justify-end">
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
