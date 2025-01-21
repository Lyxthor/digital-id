@extends('layouts.dukcapil')

@section('title', 'Add Citizen')

@section('content')
<div class="container flex justify-center">
    <div class="w-3/4">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-end flex-wrap">
                    <ul class="flex justify-between w-full">
                        <div class="breadcrumbs text-sm">
                            <ul>
                                <li><a>Home</a></li>
                                <li><a>Edit Penduduk</a></li>
                            </ul>
                        </div>
                        <li><a href="{{ route('dukcapil.citizen.index') }}" class="btn btn-sm btn-primary">Kembali</a></li>
                    </ul>
                    <div class="flex items-end gap-5">
                        <img src="{{ route('image.show',['filename'=>$citizen->pp_img_path]) }}" alt="" class="w-20 aspect-square rounded-full object-cover">
                        <div>
                            <h2 class="card-title font-bold">Citizen Form</h2>
                            <span class="text-xs mb-6 text-slate-500">Edit citizen {{ $citizen->nik }} to database</span>
                        </div>
                    </div>
                </div>
                <form action="{{ route('dukcapil.citizen.update', ['id'=>$citizen->id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="flex gap-5 mb-3">

                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">NIK</span>
                            </div>
                            <input value="{{ $citizen->nik }}" type="text" name="nik" id="nik" placeholder="Type here" class="input input-bordered w-full" />
                        </label>
                    </div>
                    <div class="flex gap-5 mb-3">
                        <label class="form-control w-full" for="name">
                            <div class="label">
                            <span class="label-text capitalize">Citizen name</span>
                            </div>
                            <input value="{{ $citizen->name }}" type="text" name="name" id="name" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>

                    </div>
                    <div class="flex gap-5 mb-3">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">Birth Date</span>
                            </div>
                            <input value="{{ $citizen->birth_date }}" type="date" name="birth_date" id="birth_date" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">Birth Place</span>
                            </div>
                            <input value="{{ $citizen->birth_place }}" type="text" name="birth_place" id="birth_place" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                    </div>
                    <div class="flex gap-5 mb-3">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">Gender</span>
                            </div>
                            <select type="text" name="gender" id="gender" placeholder="Type here" class="input input-sm input-bordered w-full">
                                <option value="m" @selected($citizen->gender=="m")>Laki-laki</option>
                                <option value="f" @selected($citizen->gender=="f")>Perempuan</option>
                            </select>
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">Blood Type</span>
                            </div>
                            <select type="text" name="blood_type" id="blood_type" placeholder="Type here" class="input input-sm input-bordered w-full">
                                <option value="-">-</option>
                                @foreach ($blood_types as $bt)
                                    <option value="{{ $bt }}" @selected($citizen->blood_type == $bt)>{{ $bt }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="flex gap-5 mb-3">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">Job</span>
                            </div>
                            <input value="{{ $citizen->job }}" type="text" name="job" id="job" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">Profile Image</span>
                            </div>
                            <input type="file" name="pp_img" id="pp_img" placeholder="Type here" class="file-input file-input-bordered file-input-primary file-input-sm w-full" />
                        </label>
                    </div>
                    <div class="flex gap-5 mb-3">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">religion</span>
                            </div>
                            <input value="{{ $citizen->religion }}" type="text" name="religion" id="religion" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full" for="name">
                            <div class="label">
                            <span class="label-text capitalize">education</span>
                            </div>
                            <input value="{{ $citizen->education }}" type="text" name="education" id="education" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                    </div>
                    <div class="grid grid-cols-4 gap-3 mb-3">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">village</span>
                            </div>
                            <input value="{{ $citizen->village }}" type="text" name="village" id="village" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">district</span>
                            </div>
                            <input value="{{ $citizen->district }}" type="text" name="district" id="district" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">regency</span>
                            </div>
                            <input value="{{ $citizen->regency }}" type="text" name="regency" id="regency" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">province</span>
                            </div>
                            <input value="{{ $citizen->province }}" type="text" name="province" id="province" placeholder="Type here" class="input input-sm input-bordered w-full" />
                        </label>

                    </div>
                    <div class="flex gap-5 mb-3">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text capitalize">Address</span>
                            </div>
                            <textarea name="address" id="address" cols="30" rows="6" class="textarea textarea-bordered">{{ $citizen->address }}</textarea>
                        </label>
                    </div>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

          </div>
    </div>
</div>

@endsection
