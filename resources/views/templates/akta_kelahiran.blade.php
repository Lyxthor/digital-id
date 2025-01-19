@extends('layouts.template')

@section('title', 'KTP Template');
@section('content')
<div id="content" class="aspect-[3/4] h-screen max-h-screen bg-blue-100 border-4 border-green-600 p-6 pb-16 relative font-serif mx-auto">
    <!-- Header -->
    <div class="absolute top-4 left-4 flex items-start gap-2">
        <div>
            <p class="text-[10px] font-semibold">Nomor Induk Kependudukan</p>
            <p class="text-[9px] italic">Personal Registration Number</p>
        </div>
        <p class="text-[11px]">{{ $owner->nik }}</p>
    </div>
    <div class="absolute top-4 right-4">
        <p class="text-[10px] font-bold">No. AL.500.0008752</p>
    </div>

    <!-- Seal -->
    <div class="absolute top-12 left-1/2 transform -translate-x-1/2">
        <div class="w-12 h-12 bg-pink-300 rounded-full flex items-center justify-center">

        </div>
    </div>

    <!-- Title -->
    <div class="text-center mt-20">
        <p class="text-[12px] font-bold">PENCATATAN SIPIL</p>
        <p class="text-[10px] italic">Registry Office</p>
        <p class="text-[12px] font-bold mt-3">WARGA NEGARA</p>
        <p class="text-[10px] italic">Nationality</p>
        <p class="text-[12px] font-bold mt-3">KUTIPAN AKTA KELAHIRAN</p>
        <p class="text-[10px] italic">Excerpt of Birth Certificate</p>
    </div>

    <!-- Body -->
    <div class="mt-10">
        <p class="text-[10px]">
            Berdasarkan Akta Kelahiran Nomor: <span class="italic">By virtue of Birth Certificate Number:</span>
        </p>
        <p class="text-[10px] mt-2">
            Menurut <span class="italic">State Gazette</span>
        </p>
        <p class="text-[10px] mt-2">
            Bahwa di <strong>{{ $owner->birth_place }}</strong> pada tanggal <strong>{{ \Illuminate\Support\Carbon::parse($owner->birth_date)->format('d F Y') }}</strong> telah lahir <strong>{{ $owner->name }}</strong>
        </p>
        <p class="text-[10px] mt-2">
           {{ $members->where('id', $owner->id)->first()['role'] }} dari pasangan <strong>{{ $members->where('gender', 'm')->where('id', '!=', $owner->id)->first()['name'] }}</strong> dan <strong>{{ $members->where('gender', 'f')->where('id', '!=', $owner->id)->first()['name'] }}</strong>
        </p>
    </div>

    <!-- Footer -->
    <div class="absolute bottom-8 right-4">
        <p class="text-[10px]">Kutipan ini dikeluarkan</p>
        <p class="text-[9px] italic">The excerpt is issued</p>
        <p class="text-[10px] mt-3">pada tanggal <strong>{{ date('j F Y') }}</strong></p>

    </div>

    <div class="absolute bottom-8 left-4 text-center">

    </div>

    <!-- Border Pattern -->
    <div class="absolute inset-0 border-[10px] border-green-600 rounded-md" style="clip-path: polygon(1% 0%, 99% 0%, 99% 100%, 0% 100%);"></div>
</div>
@endsection
