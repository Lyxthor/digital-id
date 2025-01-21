@extends('layouts.citizen')

@section('content')
<div class="container mx-auto px-6">
    <div class="mb-4">
        <a href="{{ route('citizen.folder.index') }}" class="btn btn-sm btn-success">Kembali</a>
    </div>
    <div class="bg-white shadow-md rounded-lg mb-6">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Folder Saya</h1>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="category" id="category" value="preMade">
                    <input type="text" name="name" placeholder="Tambahkan Folder baru"
                        class="input input-bordered input-sm px-10" value="{{ $folder->name }}" readonly>
                </div>
            </div>
            <div class="overflow-x-auto text-center">
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Document</th>
                            <th class="px-4 py-2">Last Modified</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($folder->documents) && $folder->documents != null && $folder->documents->count() > 0)
                            @php
                                $index = 1;
                            @endphp
                            @foreach($folder->documents as $doc)
                                <tr class="border-b">
                                    <td class="px-4 py-2 text-right">{{ $index++ }}</td>
                                    <td class="px-4 py-2">{{ $doc->type->name }}</td>
                                    <td class="px-4 py-2">{{ $doc->updated_at }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <div x-data="{ isOpen: false }">
                                            <button x-on:click="isOpen = true" type="button" class="btn btn-xs btn-success rounded-xl">
                                                Show
                                            </button>
                                            <div class="modal-container fixed w-screen z-50 h-screen top-0 left-0 bg-slate-800 bg-opacity-55"
                                                x-show="isOpen"
                                                x-transition.opacity
                                                x-on:click="isOpen = false">
                                                <div id="modal{{ $index }}" class="h-full">
                                                    <div class="modal-body h-full flex justify-center items-center">
                                                        <img src="{{ route('image.show', ['filename' => $doc->filename]) }}" alt="" class="h-full">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center py-4">Belum ada document</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
