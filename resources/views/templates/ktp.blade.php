@extends('layouts.template')

@section('title', 'KTP Template');
@section('content')
<div id="content" class="card bg-base-100 shadow-xl aspect-video">
    <div class="card-body">
        <div class="row flex justify-between">
            <div class="w-2/12">
                <img src="{{ route('image.show', ['filename'=>$owner->pp_img_path]) }}" class="bg-slate-500 w-full aspect-square rounded-full object-cover" />
            </div>
            <div class="w-9/12">
                <table class="w-full text-2xl">
                    <tbody>
                        <tr>
                            <td class="font-bold py-2">NIK</td>
                            <td>: {{ $owner->nik }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold py-2">Nama</td>
                            <td>: {{ $owner->name }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold py-2">Tempat, Tanggal Lahir</td>
                            <td>: {{ $owner->birth_place }}, {{ $owner->birth_date }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold py-2">Jenis Kelamin</td>
                            <td>: {{ $owner->gender }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold py-2">Gol Darah</td>
                            <td>: {{ $owner->blood_type }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold py-2">Pekerjaan</td>
                            <td>: {{ $owner->job }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold py-2">Alamat</td>
                            <td>: {{ $owner->current_address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
