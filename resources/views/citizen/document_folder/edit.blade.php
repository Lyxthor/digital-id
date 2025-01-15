@extends('layouts.citizen')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Edit folder</h2>
        <form action="{{route('citizen.folder.edit')}}" method="POST">
            @csrf
            @method('PUT')
            {{-- input nama folder --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Folder</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="mt-1 block w-full rounded-md border-grey-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{$message}}</p>
                @enderror
            </div>

            {{-- checkbox dokumen --}}
            <div class="mb-4">
                <label for="documents" class="block text-sm font-medium text-gray-700">Pilih Dokumen</label>
                <div class="mt-2">
                    @foreach ($documents as $document)
                        <div class="flex items-center mb-2">
                            <input
                                type="checkbox"
                                name="documents[]"
                                id="document-{{$document->id}}"
                                value="{{$document->id}}"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            >
                            <label for="document-{{$document->id}}" class="ml-2 block text-sm text-grey-900">
                                {{$document->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('documnets')
                    <p class="text-red-500 text-sm mt-1">{{$message}}</p>
                @enderror
            </div>

            {{-- tombol submit --}}
            <div class="mt-6 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >Simpan Perubahan</button>
                <a
                    href="{{route('citizen.folder.index')}}"
                    class="ml-4 inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >Batal</a>
            </div>
        </form>
    </div>
@endsection
