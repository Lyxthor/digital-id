@extends('layouts.dukcapil')

@section('title', 'Edit Document')

@section('content')
<div class="container flex justify-center">
    <div class="w-3/4">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title font-bold">Edit Document</h2>
                <form action="{{ route('citizen.document.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Nama</span>
                        </div>
                        <input type="text" name="owner" value="{{ $document->owner }}" class="input input-bordered w-full">
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Current Image</span>
                        </div>
                        <img src="{{ route('image.show', ['filename' => $document->gambar]) }}" class="w-20 aspect-square rounded object-cover">
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">New Document Image (optional)</span>
                        </div>
                        <input type="file" name="gambar" class="file-input file-input-bordered w-full">
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Document Type</span>
                        </div>
                        <select name="tipe_dokumen" class="select select-bordered w-full">
                            <option value="ijazah" @selected($document->tipe_dokumen == 'ijazah')>Ijazah</option>
                            <option value="sertifikat" @selected($document->tipe_dokumen == 'sertifikat')>Sertifikat</option>
                        </select>
                    </label>

                    <div class="card-actions justify-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
