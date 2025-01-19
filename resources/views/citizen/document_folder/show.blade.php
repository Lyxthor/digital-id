@extends('layouts.citizen')

@section('content')
<div class="container mx-auto h-96">
    <div class="card bg-white h-full">
        <div class="flex justify-between w-full items-center p-8">
            <div>
                <h1 class="text-2xl font-bold">Folder Saya</h1>
            </div>

            <div class="flex justify-end items-center gap-2 w-3/4">
                <input
                type="hidden"
                name="category"
                id="category"
                value="preMade">
                <input
                type="text"
                name="name"
                placeholder="Tambahkan Folder baru"
                class="join-item input input-sm input-bordered input-disabled w-1/2"
                value="{{ $folder->name }}"
                readonly>
            </div>
        </div>
        <table class="table table-xs border">
            <thead>
                <tr>
                <th class="py-5"></th>
                <th class="border-r">Document</th>
                <th class="border-r">Last Modified</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($folder->documents) && $folder->documents!=null && $folder->documents->count() > 0)
                @php
                    $index = 1;
                @endphp

                    @foreach($folder->documents as $doc)
                        <tr>
                            <th>{{ $index++ }}</th>
                            <td>{{ $doc->type->name }}</td>
                            <td>
                                {{ $doc->updated_at }}
                            </td>
                            <td>
                                <div x-data="{ isOpen: false }">
                                    <button x-on:click="isOpen = true" type="button" class="btn btn-xs btn-success rounded-sm">
                                        show
                                    </button>
                                    <div class="modal-container fixed w-screen z-50 h-screen top-0 left-0 bg-slate-800 bg-opacity-55"
                                    x-show="isOpen"
                                    x-transition.opacity
                                    x-on:click="isOpen = false">
                                        <div id="modal{{ $index }}" class="h-full">
                                            <div class="modal-body h-full flex justify-center items-center">
                                                <img src="{{ route('image.show', ['filename'=>$doc->filename]) }}" alt="" class="h-full">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                @else
                <tr>
                    <td colspan="4" class="py-2 text-center bg-stone-100">
                        Belum ada document
                    </td>
                </tr>
                @endif
            </tbody>
            </table>

    </div>
</div>
@endsection
