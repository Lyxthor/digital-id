@extends('layouts.dukcapil')

@section('content')
@php
    $citizens = \App\Models\Citizen::count();
    $officialDocuments = \App\Models\Document::whereHas('type', function($query) {
        return $query->where('category', 'official');
    })->count();
    $customDocuments = \App\Models\Document::whereHas('type', function($query) {
        return $query->where('category', 'custom');
    })->count();
    $types = \App\Models\Document::count();


@endphp
<div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="p-4 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold">Jumlah Penduduk yang terdaftar</h3>
        <p class="text-2xl font-bold">{{ $citizens }}</p>
    </div>
    <div class="p-4 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold">Jumlah Dokumen Official</h3>
        <p class="text-2xl font-bold">{{ $officialDocuments }}</p>
    </div>
    <div class="p-4 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold">Jumlah Dokumen Custom</h3>
        <p class="text-2xl font-bold">{{ $customDocuments }}</p>
    </div>
    <div class="p-4 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold">Jumlah Tipe Dokumen</h3>
        <p class="text-2xl font-bold">{{ $types }}</p>
    </div>
</div>
@endsection
