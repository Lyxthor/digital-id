@extends('layouts.template')

@section('title', 'KTP Template');
@section('content')
<div class="flex items-center justify-center h-screen bg-gray-100">
    <div
        id="content"
        class="relative w-[720px] h-[440px] bg-cover bg-center rounded-lg shadow-lg"
        style="background-image: url({{ route('image.show', ['filename'=>'front-ktp.jpg']) }});"
    >

        <!-- Header -->
        <div class="absolute top-4 left-0 right-0 text-center">
            <h1 class="text-lg font-bold uppercase">PROVINSI {{ $owner->province }}</h1>
            <h2 class="text-lg font-bold uppercase">{{ $owner->regency }}</h2>
        </div>

        <!-- Content -->
        <div class="absolute top-16 left-6 text-sm mt-4">
            <div class="flex mb-2">
                <span class="font-bold w-[150px]">NIK</span>
                <span class="mx-2">:</span>
                <span class="uppercase">{{ $owner->nik }}</span>
            </div>
            <div class="flex mb-2">
                <span class="font-bold w-[150px]">Nama</span>
                <span class="mx-2">:</span>
                <span class="uppercase">{{ $owner->name }}</span>
            </div>
            <div class="flex mb-2">
                <span class="font-bold w-[150px]">Tempat/Tgl Lahir</span>
                <span class="mx-2">:</span>
                <span class="uppercase">{{ $owner->birth_place }}, {{ $owner->birth_date }}</span>
            </div>
            <div class="flex mb-2">
                <span class="font-bold w-[150px]">Jenis Kelamin</span>
                <span class="mx-2">:</span>
                <span class="uppercase">{{ $owner->gender == "f" ? "perempuan" : "laki-laki" }}</span>
                <span class="ml-8 font-bold w-[100px]">Gol. Darah</span>
                <span class="mx-2">:</span>
                <span class="uppercase">{{ $owner->blood_type }}</span>
            </div>
            <div class="flex flex-col mb-2">
                <div class="flex">
                    <span class="font-bold w-[150px]">Alamat</span>
                    <span class="mx-2">:</span>
                    <span class="uppercase">{{ $owner->address }}</span>
                </div>
                <div class="flex flex-col gap-1 ml-[104px] mt-1">
                    <div class="flex mr-8">
                        <span class="font-bold">Kel/Desa</span>
                        <span class="mx-2">:</span>
                        <span class="uppercase">{{ $owner->village }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-bold">Kecamatan</span>
                        <span class="mx-2">:</span>
                        <span class="uppercase">{{ $owner->district }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-bold">Kabupaten</span>
                        <span class="mx-2">:</span>
                        <span class="uppercase">{{ $owner->regency }}</span>
                    </div>
                </div>
            </div>
            <div class="flex mb-2">
                <span class="font-bold w-[150px]">Agama</span>
                <span class="mx-2">:</span>
                <span class="uppercase">{{ $owner->religion }}</span>
            </div>
            <div class="flex mb-2">
                <span class="font-bold w-[150px]">Status Perkawinan</span>
                <span class="mx-2">:</span>
                <span class="uppercase">{{ $owner->marriage_status }}</span>
            </div>
            <div class="flex mb-2">
                <span class="font-bold w-[150px]">Pekerjaan</span>
                <span class="mx-2">:</span>
                <span class="uppercase">{{ $owner->job }}</span>
            </div>
            <div class="flex mb-2">
                <span class="font-bold w-[150px]">Kewarganegaraan</span>
                <span class="mx-2">:</span>
                <span class="uppercase">WNI</span>
            </div>
            <div class="flex">
                <span class="font-bold w-[150px]">Berlaku Hingga</span>
                <span class="mx-2">:</span>
                <span class="uppercase">Selamanya</span>
            </div>
        </div>

        <!-- Photo -->
        <div class="absolute top-28 right-6">
            <img
                src="{{ route('image.show', ['filename'=>$owner->pp_img_path]) }}"
                alt="Foto Diri"
                class="w-[182px] h-[227px] border border-black"
            />
            <p class="text-center text-xs mt-2">{{ $owner->province }}<br />{{ date('Y-m-d') }}</p>
        </div>
    </div>
</div>

@endsection
