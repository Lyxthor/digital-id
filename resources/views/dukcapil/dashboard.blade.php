@extends('layouts.dukcapil')

@section('title', 'Dashboard')

@section('content')
@php
    $dukcapil = Auth::user()->userable;
    $citizens = \App\Models\Citizen::count();
    $officialDocuments = \App\Models\Document::whereHas('type', function($query) {
        return $query->where('category', 'official');
    })->count();
    $customDocuments = \App\Models\Document::whereHas('type', function($query) {
        return $query->where('category', 'custom');
    })->count();
    $types = \App\Models\Document::count();
@endphp
<div class="container mx-auto p-6">
    <div class="bg-white shadow rounded-lg mb-6 p-6">
        <h1 class="text-2xl font-semibold text-black">Selamat Datang, {{ $dukcapil->name }}</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold">Jumlah Penduduk yang terdaftar</h3>
            <p class="text-3xl font-bold">{{ $citizens }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold">Jumlah Dokumen Official</h3>
            <p class="text-3xl font-bold">{{ $officialDocuments }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold">Jumlah Dokumen Custom</h3>
            <p class="text-3xl font-bold">{{ $customDocuments }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold">Jumlah Tipe Dokumen</h3>
            <p class="text-3xl font-bold">{{ $types }}</p>
        </div>
    </div>
</div>
@endsection
