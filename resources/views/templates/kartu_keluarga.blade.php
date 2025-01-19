@extends('layouts.template')

@section('title', 'KTP Template');
@section('content')
<div id="content" class="p-6 max-w-6xl mx-auto my-5 font-sans border rounded bg-stone-100">
    <!-- Header -->
    <div class="text-center mb-5 relative">
        <p class="text-2xl font-bold">KARTU KELUARGA</p>
        <p class="text-lg">No. 3216290922110001</p>
    </div>

    <!-- Family Info -->
    <div class="mb-5 space-y-2 relative flex justify-between text-sm items-start">
        <img src="garuda.png" alt="Garuda" class="w-24">
        <div class="flex-1 ml-4">
            <div class="flex">
                <span class="w-50 ">Nama Kepala Keluarga</span>
                <span class="uppercase">: {{ $owner->name }}</span>
            </div>
            <div class="flex">
                <span class="w-50">Alamat</span>
                <span class="uppercase">: {{ $owner->address }}</span>
            </div>
            <div class="flex">
                <span class="w-50">Kode Pos</span>
                <span class="uppercase">: 000000</span>
            </div>
        </div>
        <div class="text-right">
            <div class="flex">
                <span class="w-50 text-left">Desa/Kelurahan</span>
                <span class="uppercase">: {{ $owner->village }}</span>
            </div>
            <div class="flex">
                <span class="w-50 text-left">Kecamatan</span>
                <span class="uppercase">: {{ $owner->district }}</span>
            </div>
            <div class="flex">
                <span class="w-50 text-left">Kabupaten/Kota</span>
                <span class="uppercase">: {{ $owner->regency }}</span>
            </div>
            <div class="flex">
                <span class="w-50 text-left">Provinsi</span>
                <span class="uppercase">: {{ $owner->province }}</span>
            </div>
        </div>
    </div>
    <!-- Main Table -->
    <div class="overflow-x-auto mb-5">
        <table class="w-full border-collapse border border-gray-400">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-400 p-2 text-xs">No</th>
                    <th class="border border-gray-400 p-2 text-xs">Nama Lengkap</th>
                    <th class="border border-gray-400 p-2 text-xs">NIK</th>
                    <th class="border border-gray-400 p-2 text-xs">Jenis Kelamin</th>
                    <th class="border border-gray-400 p-2 text-xs">Tempat Lahir</th>
                    <th class="border border-gray-400 p-2 text-xs">Agama</th>
                    <th class="border border-gray-400 p-2 text-xs">Pendidikan</th>
                    <th class="border border-gray-400 p-2 text-xs">Jenis Pekerjaan</th>
                    <th class="border border-gray-400 p-2 text-xs">Golongan Darah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $index = 0;
                @endphp
                @if(isset($members) && $members !=null && count($members) > 0)
                    @foreach ($members as $member)
                    <tr>
                        <td class="border border-gray-400 p-2 text-xs">{{ ++$index }}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['name'] }}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['nik'] }}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['gender'] == 'f' ? 'Perempuan' : 'Laki-laki'}}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['birth_place'] }}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['religion'] }}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['education'] }}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['job'] }}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['blood_type'] }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Secondary Table -->
    <div class="overflow-x-auto mb-5">
        <table class="max-w-full border-collapse border border-gray-400">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-400 p-2 text-xs">No</th>
                    <th class="border border-gray-400 p-2 text-xs">Status Perkawinan</th>
                    <th class="border border-gray-400 p-2 text-xs">Tanggal Perkawinan</th>
                    <th class="border border-gray-400 p-2 text-xs">Status Hubungan dalam Keluarga</th>
                    <th class="border border-gray-400 p-2 text-xs">Kewarganegaraan</th>
                    <th class="border border-gray-400 p-2 text-xs">Dokumen Imigrasi</th>
                    <th class="border border-gray-400 p-2 text-xs">No. Paspor</th>
                    <th class="border border-gray-400 p-2 text-xs">No. KITAP</th>
                    <th class="border border-gray-400 p-2 text-xs">Nama Ayah</th>
                    <th class="border border-gray-400 p-2 text-xs">Nama Ibu</th>
                </tr>
            </thead>
            <tbody>
                @php
                $index = 0;
                @endphp
                @if(isset($members) && $members !=null && count($members) > 0)
                    @foreach ($members as $member)
                    <tr>
                        <td class="border border-gray-400 p-2 text-xs">{{ ++$index }}</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['marriage_status'] }}</td>
                        <td class="border border-gray-400 p-2 text-xs">28-10-2017</td>
                        <td class="border border-gray-400 p-2 text-xs">{{ $member['role'] }}</td>
                        <td class="border border-gray-400 p-2 text-xs">WNI</td>
                        <td class="border border-gray-400 p-2 text-xs">-</td>
                        <td class="border border-gray-400 p-2 text-xs">-</td>
                        <td class="border border-gray-400 p-2 text-xs">-</td>
                        <td class="border border-gray-400 p-2 text-xs">BUDI PANGESTU</td>
                        <td class="border border-gray-400 p-2 text-xs">SRI WAHYUNI</td>
                    </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="flex justify-between mt-5">
        <div class="text-center w-48">
            <p class="text-xs">Dikeluarkan Tanggal: 15-06-2021</p>
        </div>
        <div class="text-center w-48">
            <p class="text-xs">KEPALA KELUARGA</p>
            <div class="my-8"></div>
            <p class="text-xs">HANDOKO PANGESTU</p>
        </div>
        <div class="text-center w-48">
            <p class="text-xs">KEPALA DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL KAB. BEKASI</p>
            <div class="w-24 h-24  mx-auto my-2">
                <img src="qrcodedummy.png" class="h-30" alt="">
            </div>
            <p class="text-xs">Dr. H. HUDAYA, M.Si.</p>
            <p class="text-xs">NIP. 197004151988031001</p>
        </div>
    </div>
</div>

@endsection
