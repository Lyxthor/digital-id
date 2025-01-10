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
                    <div class="flex items-end gap-5">
                        <img src="{{ route('image.show',['filename'=>$citizen->pp_img_path]) }}" alt="" class="w-20 aspect-square rounded-full object-cover">
                        <div>
                            <h2 class="card-title font-bold">Citizen Form</h2>
                            <span class="text-xs mb-6 text-slate-500">Edit citizen {{ $citizen->nik }} to database</span>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('dukcapil.citizen.index') }}" class="btn btn-success">Back to index</a>
                    </div>
                </div>
                <form action="{{ route('dukcapil.citizen.update', ['id'=>$citizen->id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="flex gap-5">
                        <label class="form-control w-full" for="name">
                            <div class="label">
                            <span class="label-text">Citizen name</span>
                            </div>
                            <input type="text" name="name" id="name" value="{{ $citizen->name }}" placeholder="Type here" class="input input-bordered w-full" />
                        </label>
                    </div>
                    <div class="flex gap-5">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">NIK</span>
                            </div>
                            <input type="text" name="nik" id="nik" value="{{ $citizen->nik }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">No. KK</span>
                            </div>
                            <input type="text" name="no_kk" id="no_kk" value="{{ $citizen->no_kk }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                    </div>
                    <div class="flex gap-5">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Birth Date</span>
                            </div>
                            <input type="date" name="birth_date" value="{{ $citizen->birth_date }}" id="birth_date" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Birth Place</span>
                            </div>
                            <input type="text" name="birth_place" value="{{ $citizen->birth_place }}" id="birth_place" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                    </div>
                    <div class="flex gap-5">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Gender</span>
                            </div>
                            <select type="text" name="gender" id="gender" placeholder="Type here" class="input input-sm input-bordered w-full">
                                <option value="m" @selected($citizen->gender=='m')>Laki-laki</option>
                                <option value="f" @selected($citizen->gender=='f')>Perempuan</option>
                            </select>
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Blood Type</span>
                            </div>
                            <select type="text" name="blood_type" id="blood_type" placeholder="Type here" class="input input-sm input-bordered w-full">
                                <option value="">-</option>
                                @foreach ($blood_types as $bt)
                                    <option value="{{ $bt }}" @selected($citizen->blood_type == $bt)>{{ $bt }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="flex gap-5">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Job</span>
                            </div>
                            <input type="text" name="job" id="job" value="{{ $citizen->job }}" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Profile Image</span>
                            </div>
                            <input type="file" name="pp_img" id="pp_img" placeholder="Type here" class="file-input file-input-bordered file-input-primary file-input-sm w-full" />
                        </label>
                    </div>
                    <div class="flex gap-5">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Current address</span>
                            </div>
                            <textarea name="current_address" id="current_address" cols="30" rows="10" class="textarea textarea-bordered">{{ $citizen->current_address }}</textarea>
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
