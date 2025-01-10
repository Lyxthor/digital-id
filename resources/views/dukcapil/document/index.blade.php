@extends('layouts.dukcapil')

@section('title', 'Add Citizen')

@section('content')
<div class="container flex justify-center">
    <div class="w-3/4">
        <div class="card bg-base-100 shadow-xl">

            <div class="card-body">
                <div class="flex justify-between items-end flex-wrap">
                    <div class="breadcrumbs w-full text-sm">
                        <ul>
                            <li><a>Home</a></li>
                            <li><a>Documents</a></li>
                            <li>Add Document</li>
                        </ul>
                    </div>
                    <div>
                        <div class="flex items-end gap-5">
                            <img src="{{ route('image.show',['filename'=>$citizen->pp_img_path]) }}" alt="" class="w-20 aspect-square rounded-full object-cover">
                            <div>
                                <h2 class="card-title font-bold">Citizen Form</h2>
                                <span class="text-xs mb-6 text-slate-500">Add document for citizen {{ $citizen->nik }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('dukcapil.document.index') }}" class="btn btn-success">Back to index</a>
                    </div>
                </div>
                <form action="{{ route('dukcapil.document.generate') }}" method="POST" enctype="multipart/form-data">

                    @csrf


                    <div class="flex gap-5 mb-6">
                        <input type="hidden" name="owner_id" value="{{ $citizen->id }}">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Document Type</span>
                            </div>
                            
                        </label>
                    </div>

                    <div class="card-actions justify-end">
                        <button class="btn btn-primary">Buy Now</button>
                    </div>
                </form>
            </div>

          </div>
    </div>
</div>

@endsection
