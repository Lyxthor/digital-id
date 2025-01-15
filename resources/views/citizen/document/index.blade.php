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
                            <div class="mb-4">
                                <label for="file" class="block text-sm font-medium text-gray-700">File</label>
                                <input type="file" name="file" id="file" class="form-input mt-1 block w-full">
                            </div>
                            <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Document Type</span>
                            </div>
                            <select type="text" name="type_id" id="type_id" placeholder="Type here" class="input input-bordered w-full">
                                @foreach ($types as $dt)
                                    <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                                @endforeach
                            </select>
                        </label>
                            <div class="modal-action">
                                <button type="button" class="btn" onclick="my_modal_5.close()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
            <table class="table table-xs">
                <thead>
                    <tr>
                        <th class="py-5"></th>
                        <th class="border-r">Document</th>
                        <th class="border-r">Last Modified</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($documents) && $documents != null && $documents->count() > 0)
                        @php
                            $index = 1;
                        @endphp
                        @foreach ($documents as $doc)
                            <tr>
                                <th>{{ $index++ }}</th>
                                <td>{{ $doc->type->name }}</td>
                                <td>
                                    {{ $doc->updated_at }}
                                </td>
                                <td>
                                    <div x-data="{ isOpen: false }">
                                        <button x-on:click="isOpen = true">
                                            show document
                                        </button>
                                        <div class="modal-container fixed w-screen z-50 h-screen top-0 left-0 bg-slate-800 bg-opacity-55"
                                            x-show="isOpen" x-transition.opacity x-on:click="isOpen = false">
                                            <div id="modal{{ $index }}" class="h-full">
                                                <div class="modal-body h-full flex justify-center items-center">
                                                    <img src="{{ route('image.show', ['filename' => $doc->filename]) }}"
                                                        alt="" class="w-1/2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="py-2 text-center bg-stone-100">
                                Belum ada document
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
