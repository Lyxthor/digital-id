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
                    <button
                    type="button"
                    onclick="create_modal.showModal()"
                    href="{{ route('dukcapil.citizen.create') }}"
                    class="btn btn-md btn-primary font-semibold">
                        + New Citizen
                    </button>
                    <dialog id="create_modal" class="modal modal-bottom sm:modal-middle">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Tambah Tipe Dokumen</h3>
                            <form
                            action="{{ route('dukcapil.document_type.store') }}"
                            method="post">
                                @csrf
                                <label class="form-control mb-2 mt-2">
                                    <div class="label">
                                        <div class="label-text">Name</div>
                                    </div>
                                    <input type="text" name="name" id="name" class="input input-sm input-bordered w-full mt-2">
                                </label>
                                <label class="form-control mb-2 mt-2">
                                    <div class="label">
                                        <div class="label-text">Category</div>
                                    </div>
                                    <select
                                    name="category"
                                    id="category"
                                    class="select select-bordered">
                                        <option value="official">official</option>
                                        <option value="custom">custom</option>
                                    </select>
                                </label>

                                <div class="grid grid-cols-3 gap-2 mb-2 mt-2">
                                    <label class="form-control">
                                        <div class="label">
                                            <div class="label-text">Jumlah Kepemilikan</div>
                                        </div>
                                        <select
                                        name="ownership_count"
                                        id="ownership_count"
                                        class="select select-bordered select-sm rounded-sm">
                                            <option value="mono">mono</option>
                                            <option value="multi">multi</option>
                                        </select>
                                    </label>
                                    <label class="form-control">
                                        <div class="label">
                                            <div class="label-text">Jumlah Pemilik</div>
                                        </div>
                                        <select
                                        name="membership_count"
                                        id="membership_count"
                                        class="select select-bordered select-sm rounded-sm">
                                            <option value="mono">mono</option>
                                            <option value="multi">multi</option>
                                        </select>
                                    </label>
                                    <label class="form-control">
                                        <div class="label">
                                            <div class="label-text">Pemilik Dokumen</div>
                                        </div>
                                        <select
                                        name="member_ownership"
                                        id="member_ownership"
                                        class="select select-bordered select-sm rounded-sm">
                                            <option value="main">main</option>
                                            <option value="all">all</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="w-full" id="authorized_citizen_container">
                                    <div class="w-full dropdown dropdown-bottom dropdown-end">
                                        <div class="form-control w-full">
                                            <div class="label">
                                                <div class="label-text font-bold">Other Type Requisites</div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                @foreach ($types as $type)
                                                    <div class="form-control">
                                                        <label class="label cursor-pointer">
                                                            <span class="label-text">
                                                                {{ $type->name }}
                                                            </span>
                                                            <input type="checkbox"
                                                            value="{{ $type->id }}"
                                                            name="requisites[]" id="" class="checkbox checkbox-sm rounded-sm">
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-action">
                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                    <button type="button" class="btn btn-sm" onclick="create_modal.close()">Close</button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-xs">
            <thead>
                <tr>
                <th></th>
                <th>Name</th>
                <th>Jumlah Kepemilikan</th>
                <th>Jumlah Pemilik</th>
                <th>Pemilik Utama Dokumen</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($types) && $types!=null && $types->count() > 0)
                    @php
                        $index = 1;
                    @endphp
                    @foreach($types as $type)
                    <tr>
                        <th class="text-right">{{ $index++ }}</th>
                        <td class="py-3">{{ $type->name }}</td>
                        <td class="py-3">{{ $type->ownership_count }}</td>
                        <td class="py-3">{{ $type->membership_count }}</td>
                        <td class="py-3">{{ $type->member_ownership }}</td>

                        <td class="py-3">
                            <button
                            type="button"
                            onclick="edit_modal_{{ $type->id }}.showModal()"
                            class="btn btn-xs btn-warning rounded-sm">
                                edit
                            </button>

                            <a
                            href="{{ route('dukcapil.citizen.show',['id'=>$type->id]) }}"
                            class="btn btn-xs btn-success rounded-sm">
                                show
                            </a>
                            <button
                            onclick="delete_modal_{{ $type->id }}.showModal()"
                            class="btn btn-xs btn-error rounded-sm">
                                delete
                            </button>
                            <dialog id="delete_modal_{{ $type->id }}" class="modal modal-bottom sm:modal-middle">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Hapus Tipe Dokumen</h3>
                                    <form
                                    action="{{ route('dukcapil.document_type.destroy', ['id'=>$type->id]) }}"
                                    method="post">
                                    @method('DELETE')
                                        @csrf
                                        <p class="mt-3">Yakin ingin menghapus tipe dokumen <span class="font-bold">{{ $type->name }}</span>?</p>
                                        <div class="modal-action">
                                            <button type="submit" class="btn btn-sm btn-primary">Yakin</button>
                                            <button type="button" class="btn btn-sm" onclick="delete_modal_{{ $type->id }}.close()">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </dialog>
                            <dialog id="edit_modal_{{ $type->id }}" class="modal modal-bottom sm:modal-middle">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Edit Tipe Dokumen</h3>
                                    <form
                                    action="{{ route('dukcapil.document_type.update', ['id'=>$type->id]) }}"
                                    method="post">
                                        @method('PUT')
                                        @csrf
                                        <label class="form-control mb-2 mt-2">
                                            <div class="label">
                                                <div class="label-text">Name</div>
                                            </div>
                                            <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="input input-sm input-bordered w-full mt-2"
                                            value="{{ $type->name }}">
                                        </label>
                                        <label class="form-control mb-2 mt-2">
                                            <div class="label">
                                                <div class="label-text">Category</div>
                                            </div>
                                            <select
                                            name="category"
                                            id="category"
                                            class="select select-bordered">
                                                <option
                                                value="official"
                                                @selected($type->category=='official')>
                                                    official
                                                </option>
                                                <option
                                                value="custom"
                                                @selected($type->category=='custom')>
                                                    custom
                                                </option>
                                            </select>
                                        </label>

                                        <div class="grid grid-cols-3 gap-2 mb-2 mt-2">
                                            <label class="form-control">
                                                <div class="label">
                                                    <div class="label-text">Jumlah Kepemilikan</div>
                                                </div>
                                                <select
                                                name="ownership_count"
                                                id="ownership_count"
                                                class="select select-bordered select-sm rounded-sm">
                                                    <option
                                                    value="mono"
                                                    @selected($type->ownership_count=='mono')>
                                                        mono
                                                    </option>
                                                    <option
                                                    value="multi"
                                                    @selected($type->ownership_count=='multi')>
                                                        multi
                                                    </option>
                                                </select>
                                            </label>
                                            <label class="form-control">
                                                <div class="label">
                                                    <div class="label-text">Jumlah Pemilik</div>
                                                </div>
                                                <select
                                                name="membership_count"
                                                id="membership_count"
                                                class="select select-bordered select-sm rounded-sm">
                                                    <option
                                                    value="mono"
                                                    @selected($type->membership_count=='mono')>
                                                        mono
                                                    </option>
                                                    <option
                                                    value="multi"
                                                    @selected($type->membership_count=='multi')>
                                                        multi
                                                    </option>
                                                </select>
                                            </label>
                                            <label class="form-control">
                                                <div class="label">
                                                    <div class="label-text">Pemilik Dokumen</div>
                                                </div>
                                                <select
                                                name="member_ownership"
                                                id="member_ownership"
                                                class="select select-bordered select-sm rounded-sm">
                                                    <option
                                                    value="main"
                                                    @selected($type->category=='main')>
                                                        main
                                                    </option>
                                                    <option
                                                    value="all"
                                                    @selected($type->category=='all')>
                                                        all
                                                    </option>
                                                </select>
                                            </label>
                                        </div>

                                        <div class="w-full" id="authorized_citizen_container">
                                            <div class="w-full dropdown dropdown-bottom dropdown-end">
                                                <div class="form-control w-full">
                                                    <div class="label">
                                                        <div class="label-text font-bold">Other Type Requisites</div>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-2">
                                                        @foreach ($types->where('id', '!=', $type->id) as $t)
                                                            <div class="form-control">
                                                                <label class="label cursor-pointer">
                                                                    <span class="label-text">
                                                                        {{ $t->name }}
                                                                    </span>
                                                                    <input
                                                                    type="checkbox"
                                                                    value="{{ $t->id }}"
                                                                    name="requisites[]"
                                                                    id=""
                                                                    class="checkbox checkbox-sm rounded-sm"
                                                                    @checked($type->requisites->pluck('id')->contains($t->id))>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-action">
                                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                            <button type="button" class="btn btn-sm" onclick="edit_modal_{{ $type->id }}.close()">Close</button>
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
