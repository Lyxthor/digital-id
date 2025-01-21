@extends('layouts.citizen')

@section('title', 'Documents')

@section('content')
    <div class="container mx-auto px-6">
        <div class="bg-white shadow-md rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-lg font-bold capitalize mb-4">Daftar Dokumen</h2>
                <div class="flex items-center justify-between mb-4">
                    <button class="btn btn-sm text-md btn-primary" onclick="my_modal_5.showModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                        Tambah Dokumen</button>
                    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Tambah Dokumen</h3>
                            <form action="{{ route('citizen.document.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <label class="form-control w-full mb-3">
                                    <div class="label">
                                        <div class="label-text">Custom Name</div>
                                    </div>
                                    <input type="text" name="name" id="name"
                                        class="input input-bordered mt-1 block w-full">
                                </label>
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Document Type</span>
                                    </div>
                                    <select type="text" name="type_id" id="type_id" placeholder="Type here"
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
                                    <input type="file" name="file" id="file"
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
            </div>
            <div class="overflow-x-auto text-center">
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Document</th>
                            <th class="px-4 py-2">Last Modified</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Action</th>
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
                                <tr class="border-b">
                                    <td class="px-4 py-2 text-right">{{ $index++ }}</td>
                                    <td class="px-4 py-2">{{ $doc->type->name }}</td>
                                    <td class="px-4 py-2">{{ $doc->updated_at }}</td>
                                    <td class="px-4 py-2">
                                        <div class="badge badge-outline font-medium py-3 px-2 badge-sm badge-info">
                                            {{ $doc->type->category }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 space-x-2">
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
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada document</td>
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
                                <tr class="border-b">
                                    <td class="px-4 py-2 text-right">{{ $index++ }}</td>
                                    <td class="px-4 py-2">{{ $doc->type->name }}</td>
                                    <td class="px-4 py-2">{{ $doc->updated_at }}</td>
                                    <td class="px-4 py-2">
                                        <div class="badge badge-outline font-medium py-3 px-2 badge-sm badge-info">
                                            {{ $doc->type->category }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 space-x-2">
                                        <button onclick="delete_modal_{{ $doc->id }}.showModal()"
                                            class="btn btn-xs btn-error rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                        <dialog id="delete_modal_{{ $doc->id }}"
                                            class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Hapus Dokumen</h3>
                                                <form action="{{ route('citizen.document.destroy', ['id' => $doc->id]) }}"
                                                    method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <p class="mt-3">Yakin ingin menghapus dokumen <span
                                                            class="font-bold">{{ $doc->name }}</span>?</p>
                                                    <div class="modal-action">
                                                        <button type="submit" class="btn btn-sm btn-primary">Yakin</button>
                                                        <button type="button" class="btn btn-sm"
                                                            onclick="delete_modal_{{ $doc->id }}.close()">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>

                                        <button onclick="edit_modal_{{ $doc->id }}.showModal()"
                                            class="btn btn-warning btn-xs rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <dialog id="edit_modal_{{ $doc->id }}"
                                            class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Edit Dokumen</h3>
                                                <form action="{{ route('citizen.document.update', ['id' => $doc->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    <label class="form-control w-full mb-3">
                                                        <div class="label">
                                                            <div class="label-text">Custom Name</div>
                                                        </div>
                                                        <input type="text" name="name" id="name"
                                                            class="input input-bordered mt-1 block w-full"
                                                            value="{{ $doc->name }}">
                                                    </label>
                                                    <label class="form-control w-full">
                                                        <div class="label">
                                                            <span class="label-text">Document Type</span>
                                                        </div>
                                                        <select type="text" name="type_id" id="type_id"
                                                            placeholder="Type here" class="input input-bordered w-full">
                                                            @foreach ($types as $dt)
                                                                <option value="{{ $dt->id }}"
                                                                    @selected($doc->type_id == $dt->id)>
                                                                    {{ $dt->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </label>
                                                    <label class="form-control w-full mb-3">
                                                        <div class="label">
                                                            <div class="label-text">File</div>
                                                        </div>
                                                        <input type="file" name="file" id="file"
                                                            class="file-input file-input-bordered mt-1 block w-full">
                                                    </label>
                                                    <div class="modal-action">
                                                        <button type="button" class="btn"
                                                            onclick="edit_modal_{{ $doc->id }}.close()">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>
                                        <!-- Tombol untuk Membuka Modal -->
                                        <label for="my_modal_3" class="btn btn-success btn-xs rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </label>

                                        <!-- Modal DaisyUI -->
                                        <input type="checkbox" id="my_modal_3" class="modal-toggle" />
                                        <div class="modal">
                                            <div class="modal-box relative">
                                                <!-- Tombol untuk Menutup Modal -->
                                                <label for="my_modal_3"
                                                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                <h3 class="text-lg font-bold">Preview Dokumen</h3>
                                                <!-- Gambar -->
                                                <div class="flex justify-center py-4">
                                                    <img src="{{ route('image.show', ['filename' => $doc->filename]) }}"
                                                        alt="Image Preview" class="max-h-80 w-auto border" />
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
                <div class="mt-10">

                </div>
        </div>
    </div>
@endsection
