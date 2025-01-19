@extends('layouts.dukcapil')

@section('content')
<div class="container px-6">
    <div class="card bg-base-100 w-full mb-6">
        <div class="card-body">
            <h2 class="text-lg font-bold capitalize">Daftar data penduduk</h2>
            <div class="breadcrumbs text-sm">
                <ul>
                    <li><a>Home</a></li>
                    <li><a>Documents</a></li>
                    <li>Add Document</li>
                </ul>
            </div>
            <div class="flex items-end justify-between">
                <label class="input input-bordered input-sm flex w-80 items-center gap-2">
                    <input type="text" class="grow" placeholder="Search" />
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="h-4 w-4 opacity-70">
                        <path
                        fill-rule="evenodd"
                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                        clip-rule="evenodd" />
                    </svg>
                </label>

                <div>
                    <a href="{{ route('dukcapil.document.create') }}" class="btn btn-outline btn-primary">
                        + Tambah Dokumen
                    </a>
                    <a href="{{ route('dukcapil.citizen.create') }}" class="btn btn-md btn-primary font-semibold">
                        + New Citizen
                    </a>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-xs">
            <thead>
                <tr>
                <th></th>
                <th>Name</th>
                <th>Gender</th>
                <th>Birth Place</th>
                <th>Job</th>
                <th>Age</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($citizens) && $citizens!=null && $citizens->count() > 0)
                    @php
                        $index = 1;
                    @endphp
                    @foreach($citizens as $c)
                    <tr>
                        <th class="text-right">{{ $index++ }}</th>
                        <td class="py-3">{{ $c->name }}</td>
                        <td class="py-3">{{ $c->gender }}</td>
                        <td class="py-3">{{ $c->birth_place }}</td>
                        <td class="py-3">{{ $c->job }}</td>
                        <td class="py-3">{{ (int) $date->parse($c->birth_date)->diffInYears($date->now()) }}</td>
                        <td class="py-3">
                            <a
                            href="{{ route('dukcapil.citizen.edit',['id'=>$c->id]) }}"
                            class="btn btn-xs btn-warning rounded-sm">
                                edit
                            </a>
                            <a
                            href="{{ route('dukcapil.citizen.show',['id'=>$c->id]) }}"
                            class="btn btn-xs btn-success rounded-sm">
                                show
                            </a>
                            <button
                                onclick="delete_modal_{{ $c->id }}.showModal()"
                                type="submit"
                                class="btn btn-xs btn-error rounded-sm">delete</button>
                            <dialog id="delete_modal_{{ $c->id }}" class="modal modal-bottom sm:modal-middle">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Hapus Penduduk</h3>
                                    <form
                                    action="{{ route('dukcapil.citizen.destroy', ['id'=>$c->id]) }}"
                                    method="post">
                                    @method('DELETE')
                                        @csrf
                                        <p class="mt-3">
                                            Yakin ingin menghapus entitas bernama {{ $c->name }} dengan nik <span class="font-bold">{{ $c->nik }}</span>?
                                        </p>
                                        <div class="modal-action">
                                            <button type="submit" class="btn btn-sm btn-primary">Yakin</button>
                                            <button type="button" class="btn btn-sm" onclick="delete_modal_{{ $c->id }}.close()">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </dialog>
                        </td>

                    </tr>
                    @endforeach
                @else
                <tr>
                    <td
                    colspan="8"
                    class="text-center py-4">
                        Citizen not found
                    </td>
                </tr>
                @endif
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
