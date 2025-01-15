@extends('layouts.citizen')

@section('title', 'Folder')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Folder Saya</h1>

        {{-- Form create folder --}}
        <form action="{{ route('citizen.folder.store') }}" method="POST" class="mb-4">
            @csrf
            @method('POST')
            <div class="flex items-center gap-2">
                <input type="text" name="folder_name" placeholder="Tambahkan Folder baru" class="input input-bordered w-full"
                    required>
                <button type="submit" class="btn btn-primary">Buat Folder</button>
            </div>
        </form>

        {{-- Folder List --}}
        <div class="grid grid-cols-4 gap-4">
            @foreach ($folders as $folder)
                <div class="card bg-case-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">{{ $folder->name }}</h2>
                        <p>List Folder: {{ $folder->created_at->format('d M Y') }}</p>
                        <div class="card-actions justify-end space-x-2">
                            <a href="{{ route('citizen.folder.show', $folder->id) }}" class="btn btn-sm btn-success">Lihat</a>
                            <a href="{{ route('citizen.folder.edit', $folder->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('citizen.folder.destroy', $folder->id) }}" method="POST"
                                onsubmit="return confirm('Yakin Ingin Mendelete folder ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-error">Delete</button>
                            </form>
                            <a href="#" class="btn btn-sm btn-primary">Share</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
