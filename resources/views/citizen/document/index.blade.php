@extends('layouts.citizen')

@section('title', 'Documents')

@section('content')
    <div class="container mx-auto h-96">
        <div class="card bg-white h-full">
            <div class="flex justify-start m-4">
                <button class="btn btn-primary" onclick="my_modal_5.showModal()">Tambah Dokumen</button>
                <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box">
                        <h3 class="text-lg font-bold">Tambah Dokumen</h3>
                        <form action="{{ route('citizen.document.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-control w-full mb-3">
                                <div class="label">
                                    <div class="label-text">Custom Name</div>
                                </div>
                                <input
                                type="text"
                                name="name"
                                id="name"
                                class="input input-bordered mt-1 block w-full">
                            </label>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Document Type</span>
                                </div>
                                <select
                                type="text"
                                name="type_id"
                                id="type_id"
                                placeholder="Type here"
                                class="input input-bordered w-full">
                                    @foreach ($types as $dt)
                                        <option value="{{ $dt->id }}">
                                            {{ $dt->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="form-control w-full mb-3">
                                <div class="label">
                                    <div class="label-text">File</div>
                                </div>
                                <input
                                type="file"
                                name="file"
                                id="file"
                                class="file-input file-input-bordered mt-1 block w-full">
                            </label>
                            <div class="modal-action">
                                <button type="button" class="btn" onclick="my_modal_5.close()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
            <table class="table table-xs border">
                <thead>
                    <tr>
                        <th class="py-5"></th>
                        <th class="border-r">Document</th>
                        <th class="border-r">Last Modified</th>
                        <th class="border-r">Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <th colspan="4" class="bg-stone-50 py-3">Official Documents</th>
                    </tr>
                    @if (isset($officialDocuments) && $officialDocuments != null && $officialDocuments->count() > 0)
                        @php
                            $index = 1;
                        @endphp
                        @foreach ($officialDocuments as $doc)
                            <tr>
                                <th>{{ $index++ }}</th>
                                <td>{{ $doc->type->name }}</td>
                                <td>
                                    {{ $doc->updated_at }}
                                </td>
                                <td>
                                    <div class="badge badge-outline font-medium py-3 px-2 badge-sm badge-info">
                                        {{ $doc->type->category }}
                                    </div>
                                </td>
                                <td>
                                    <div x-data="{ isOpen: false }">
                                        

                                        <button class="btn btn-success btn-xs rounded-sm" x-on:click="isOpen = true">
                                            show
                                        </button>
                                        <div class="modal-container fixed w-screen z-50 h-screen top-0 left-0 bg-slate-800 bg-opacity-55"
                                            x-show="isOpen" x-transition.opacity x-on:click="isOpen = false">
                                            <div id="modal{{ $index }}" class="h-full">
                                                <div class="modal-body h-full flex justify-center items-center">
                                                    <img src="{{ route('image.show', ['filename' => $doc->filename]) }}"
                                                        alt="" class="h-full">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>

                            <td colspan="5" class="py-2 text-center bg-stone-100">
                                Belum ada document
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td></td>
                        <th colspan="4" class="bg-stone-50 py-3">Personal Documents</th>
                    </tr>
                    @if (isset($customDocuments) && $customDocuments != null && $customDocuments->count() > 0)
                        @php
                            $index = 1;
                        @endphp
                        @foreach ($customDocuments as $doc)
                            <tr>
                                <th>{{ $index++ }}</th>
                                <td>{{ $doc->type->name }}</td>
                                <td>
                                    {{ $doc->updated_at }}
                                </td>
                                <td>
                                    <div class="badge badge-outline font-medium py-3 px-2 badge-sm badge-info">
                                        {{ $doc->type->category }}
                                    </div>
                                </td>
                                <td>
                                    <div x-data="{ isOpen: false }">
                                        <button
                                        onclick="delete_modal_{{ $doc->id }}.showModal()"
                                        class="btn btn-xs btn-error rounded-sm">
                                            delete
                                        </button>
                                        <dialog id="delete_modal_{{ $doc->id }}" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Hapus Dokumen</h3>
                                                <form
                                                action="{{ route('citizen.document.destroy', ['id'=>$doc->id]) }}"
                                                method="post">
                                                @method('DELETE')
                                                    @csrf
                                                    <p class="mt-3">Yakin ingin menghapus dokumen <span class="font-bold">{{ $doc->name }}</span>?</p>
                                                    <div class="modal-action">
                                                        <button type="submit" class="btn btn-sm btn-primary">Yakin</button>
                                                        <button type="button" class="btn btn-sm" onclick="delete_modal_{{ $doc->id }}.close()">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>

                                        <button onclick="edit_modal_{{ $doc->id }}.showModal()" class="btn btn-warning btn-xs rounded-sm">
                                            edit
                                        </button>
                                        <dialog id="edit_modal_{{ $doc->id }}" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Edit Dokumen</h3>
                                                <form action="{{ route('citizen.document.update',['id'=>$doc->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    <label class="form-control w-full mb-3">
                                                        <div class="label">
                                                            <div class="label-text">Custom Name</div>
                                                        </div>
                                                        <input
                                                        type="text"
                                                        name="name"
                                                        id="name"
                                                        class="input input-bordered mt-1 block w-full"
                                                        value="{{ $doc->name }}">
                                                    </label>
                                                    <label class="form-control w-full">
                                                        <div class="label">
                                                            <span class="label-text">Document Type</span>
                                                        </div>
                                                        <select
                                                        type="text"
                                                        name="type_id"
                                                        id="type_id"
                                                        placeholder="Type here"
                                                        class="input input-bordered w-full">
                                                            @foreach ($types as $dt)
                                                                <option value="{{ $dt->id }}" @selected($doc->type_id == $dt->id)>
                                                                    {{ $dt->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </label>
                                                    <label class="form-control w-full mb-3">
                                                        <div class="label">
                                                            <div class="label-text">File</div>
                                                        </div>
                                                        <input
                                                        type="file"
                                                        name="file"
                                                        id="file"
                                                        class="file-input file-input-bordered mt-1 block w-full">
                                                    </label>
                                                    <div class="modal-action">
                                                        <button type="button" class="btn" onclick="edit_modal_{{ $doc->id }}.close()">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>

                                        <button  class="btn btn-success btn-xs rounded-sm" x-on:click="isOpen = true">
                                            show
                                        </button>
                                        <div class="modal-container fixed w-screen z-50 h-screen top-0 left-0 bg-slate-800 bg-opacity-55"
                                            x-show="isOpen" x-transition.opacity x-on:click="isOpen = false">
                                            <div id="modal{{ $doc->id }}" class="h-full">
                                                <div class="modal-body h-full flex justify-center items-center">
                                                    <img src="{{ route('image.show', ['filename' => $doc->filename]) }}"
                                                        alt="" class="h-full">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>

                            <td colspan="5" class="py-2 text-center bg-stone-100">
                                Belum ada document
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
