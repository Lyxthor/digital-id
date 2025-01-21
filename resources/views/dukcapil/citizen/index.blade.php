@extends('layouts.dukcapil')

@section('title', 'Dashboard Citizen')

@section('content')
    <div class="container mx-auto px-6">
        <div class="bg-white shadow-md rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-lg font-bold capitalize mb-4">Daftar data penduduk</h2>
                <div class="breadcrumbs text-sm mb-4">
                    <ul class="flex space-x-2">
                        <li><a href="#" class="text-blue-500">Home</a></li>
                        <li><a href="#" class="text-blue-500">Citizen</a></li>
                    </ul>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <form action="{{ route('dukcapil.citizen.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" placeholder="Masukkan Nama Penduduk"
                            class="input input-bordered input-sm px-10" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary ml-2">Search</button>
                    </form>
                    <div class="space-x-2">
                        <a href="{{ route('dukcapil.document.create') }}"
                            class="btn btn-outline btn-primary btn-sm text-xs text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Tambah Dokumen
                        </a>
                        <a href="{{ route('dukcapil.citizen.create') }}"
                            class="btn btn-primary font-semibold btn-sm text
                            class="btn btn-primary font-semibold btn-sm text-xs text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                            Tambah Citizen
                        </a>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto text-center">
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Gender</th>
                            <th class="px-4 py-2">Birth Place</th>
                            <th class="px-4 py-2">Job</th>
                            <th class="px-4 py-2">Age</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($citizens) && $citizens != null && $citizens->count() > 0)
                            @php
                                $index = ($citizens->currentPage() - 1) * $citizens->perPage() + 1;
                            @endphp
                            @foreach ($citizens as $c)
                                <tr class="border-b">
                                    <td class="px-4 py-2 text-right">{{ $index++ }}</td>
                                    <td class="px-4 py-2">{{ $c->name }}</td>
                                    <td class="px-4 py-2">{{ $c->gender }}</td>
                                    <td class="px-4 py-2">{{ $c->birth_place }}</td>
                                    <td class="px-4 py-2">{{ $c->job }}</td>
                                    <td class="px-4 py-2">
                                        {{ (int) $date->parse($c->birth_date)->diffInYears($date->now()) }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <a href="{{ route('dukcapil.citizen.edit', ['id' => $c->id]) }}"
                                            class="btn btn-xs btn-warning rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('dukcapil.citizen.show', ['id' => $c->id]) }}"
                                            class="btn btn-xs btn-success rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <button onclick="delete_modal_{{ $c->id }}.showModal()" type="submit"
                                            class="btn btn-xs btn-error rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                        <dialog id="delete_modal_{{ $c->id }}"
                                            class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Hapus Penduduk</h3>
                                                <form action="{{ route('dukcapil.citizen.destroy', ['id' => $c->id]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <p class="mt-3">Yakin ingin menghapus entitas bernama
                                                        {{ $c->name }} dengan nik <span
                                                            class="font-bold">{{ $c->nik }}</span>?</p>
                                                    <div class="modal-action">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary">Yakin</button>
                                                        <button type="button" class="btn btn-sm"
                                                            onclick="delete_modal_{{ $c->id }}.close()">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4">Citizen not found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-4 px-6 p-5">
                    {{ $citizens->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
