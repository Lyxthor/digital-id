@extends('layouts.citizen')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4">
    @php
        $citizen = \Illuminate\Support\Facades\Auth::user()->userable;
        $documents = \App\Models\Document::ownership($citizen->id)->get();
        $folders = $citizen->folders;
        $tokens = $citizen->folders()->with('tokens')->get()->pluck('tokens')->flatten();

    @endphp
    <div class="p-4 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold">Jumlah Dokumen Yang dimiliki</h3>
        <p class="text-2xl font-bold">{{ $documents->count() }}</p>
    </div>
    <div class="p-4 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold">Jumlah Folder Dokumen</h3>
        <p class="text-2xl font-bold">{{ $folders->count() }}</p>
    </div>
    <div class="p-4 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold">Token Dibagikan</h3>
        <p class="text-2xl font-bold">{{ $tokens->count() }}</p>
    </div>
</div>
@endsection
