@extends('layouts.citizen')

@section('title', 'Add Citizen')

@section('content')
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<div class="container">
    <div class="w-2/3 mx-auto">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-end flex-wrap mb-2">
                    <div class="breadcrumbs w-full text-sm">
                        <ul>
                            <li><a>Home</a></li>
                            <li><a>Documents</a></li>
                            <li>Add Document</li>
                        </ul>
                    </div>
                    <div class="w-3/5">
                        <div class="flex items-end gap-5">
                            <div>
                                <h2 class="card-title font-bold">{{ $event->title }}</h2>
                                <div class="text-xs text-slate-500">Diupload pada, {{ $event->updated_at }}</div>
                                <div class="text-xs text-slate-500">oleh {{ $event->author->name }}</div>
                            </div>
                        </div>
                    </div>
                    @if ($event->reviewers->where('id', $citizen->id)->isNotEmpty() || $event->author_id == $citizen->id)
                    <div class="w-1/5 flex justify-end">
                        <a href="{{ route('citizen.event.edit', ['id'=>$event->id]) }}" class="btn btn-warning">Edit</a>
                    </div>
                    @endif

                </div>
                <div class="text-sm mb-4">
                    <label class="form-control w-full mb-4">
                        <div class="flex w-full gap-2 flex-wrap">
                            @if(isset($event->requirements) && $event->requirements != null && $event->requirements->count() > 0)
                            @php
                                $documents = \App\Models\Document::ownership($citizen->id)->get();

                            @endphp
                            @foreach ($event->requirements as $dt)
                                <div>
                                    <label for="document_requirements{{ $dt->id }}" class="btn btn-sm {{ $documents->where('type_id', $dt->id)->isNotEmpty() ? 'btn-primary' : 'btn-default' }} rounded-badge">{{ $dt->name }}</label>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </label>
                    <p>{{ $event->desc }}</p>
                </div>
                <div class="card-footer flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-500">
                            Batas akhir pengumpulan {{ $event->submit_deadline }}
                        </div>
                        <div class="text-xs text-slate-500">
                            Batas pembacaan dokumen
                            <span class="font-bold">{{ $event->access_expires_at }}</span>
                        </div>
                    </div>
                    @if ($event->reviewers->where('id', $citizen->id)->isEmpty())
                    <form action="{{ route('citizen.event.confirmation', ['id'=>$event->id]) }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-primary">Konfirmasi pengumpulan</button>
                    </form>
                    @endif
                </div>
                {{-- <form action="{{ route('citizen.event.update', ['id'=>$event->id]) }}" method="POST" >
                    @method('PUT')
                    @csrf
                    <div class="mb-6">
                        <label class="form-control w-full mb-3">
                            <div class="label">
                                <span class="label-text">Title</span>
                            </div>
                            <input type="text" name="title" id="title" class="input input-bordered w-full" value="{{ $event->title }}">
                        </label>
                        <div class="grid grid-cols-2 mb-4 gap-2 box-content">
                            <label class="form-control">
                                <div class="label">
                                    <span class="label-text">Submit deadline</span>
                                </div>
                                <input type="datetime-local" name="submit_deadline" id="submit_deadline" class="input input-sm input-bordered w-full" value="{{ $event->submit_deadline }}">
                            </label>
                            <label class="form-control">
                                <div class="label">
                                    <span class="label-text">Access deadline</span>
                                </div>
                                <input type="datetime-local" name="access_expires_at" id="access_expires_at" class="input input-sm input-bordered w-full" value="{{ $event->access_expires_at }}">
                            </label>
                        </div>
                        <label class="form-control w-full mb-3">
                            <div class="label">
                                <span class="label-text">Description</span>
                            </div>
                            <textarea name="desc" id="desc" cols="30" rows="3" class="textarea textarea-bordered">{{ $event->desc }}</textarea>
                        </label>
                        <label class="form-control w-full mb-4">
                            <div class="label">
                            <span class="label-text">Document Type</span>
                            </div>
                            <div class="flex w-full gap-2 flex-wrap">
                                @if(isset($document_types) && $document_types != null && $document_types->count() > 0)
                                @foreach ($document_types as $dt)
                                    <div>
                                        <input type="checkbox" name="document_requirements[]" id="document_requirements{{ $dt->id }}" class="hidden peer" value="{{ $dt->id }}" @checked($event->requirements->where('id', $dt->id)->isNotEmpty())>
                                        <label for="document_requirements{{ $dt->id }}" class="btn btn-sm rounded-badge peer-checked:btn-primary">{{ $dt->name }}</label>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                        </label>
                        <div id="authorized_citizen_container">
                            <div class="w-full dropdown dropdown-bottom dropdown-end">
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Reviewers</span>
                                    </div>
                                    <input type="text" id="memberSearchField" class=" mt-2 input input-bordered w-full" autocomplete="off">
                                </label>
                                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-full p-0 shadow overflow-hidden">
                                    <div class="p-2 w-full" id="inputMembersContainer"></div>
                                    <div class="bg-slate-200 text-center italic py-3">
                                        Search citizen will be displayed here
                                    </div>
                                </ul>
                            </div>
                            <ul id="membersContainer" class="px-3 py-3 text-sm bg-base-200 rounded-md w-full mt-4">


                                @if (isset($event->reviewers) && $event->reviewers != null && $event->reviewers->isNotEmpty())
                                @foreach ($event->reviewers as $rv)
                                <li class="p-3 rounded-md">
                                    <div class="flex items-center justify-between">
                                        <input type='hidden' name='reviewers[]' value='{{ $rv->id }}'>
                                        <div>
                                            <div class='font-semibold'>{{ $rv->name }}</div>
                                            <div class='font-thin text-xs'>{{ $rv->nik }}</div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form> --}}
            </div>
          </div>
    </div>
    @php

    @endphp
    @if ($event->reviewers->where('id', $citizen->id)->isNotEmpty() || $event->author_id == $citizen->id)
        <div class="w-2/3 mx-auto mt-6">
            <div class="card bg-base-100 rounded-md shadow-xl">
                <div class="h-full">
                    <table class="table table-xs">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center py-3">
                                    Reviewer
                                </th>
                            </tr>
                            <tr>
                                <th class="py-5"></th>
                                <th class="border-r">Name</th>
                                <th class="border-r">NIK</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($event->reviewers) && $event->reviewers!=null && $event->reviewers->count() > 0)
                            @php
                                $index = 1;
                            @endphp
                            @foreach($event->reviewers as $reviewer)
                                <tr>
                                    <th class="py-4">{{ $index++ }}</th>
                                    <td>
                                        {{ $reviewer->name }}
                                    </td>
                                    <td>
                                        {{ $reviewer->nik }}
                                    </td>

                                </tr>
                            @endforeach
                          @else
                            <tr>
                                <td colspan="5" class="py-2 text-center bg-stone-100">
                                    Belum ada yang mengumpulkan
                                </td>
                            </tr>
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="w-2/3 mx-auto mt-6">
            <div class="card bg-base-100 rounded-md shadow-xl">
                <div class="h-full">
                    <table class="table table-xs">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center py-3">
                                    Data Pengumpulan
                                </th>
                            </tr>
                            <tr>
                                <th class="py-5"></th>
                                <th class="border-r">Owner</th>
                                <th class="border-r">NIK</th>
                                <th class="border-r">Submitted at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($event->document_tokens) && $event->document_tokens!=null && $event->document_tokens->count() > 0)
                            @php
                                $index = 1;
                            @endphp
                            @foreach($event->document_tokens as $token)
                                <tr>
                                    <th class="py-4">{{ $index++ }}</th>
                                    <td>
                                        {{ $token->folder->owner->name }}
                                    </td>
                                    <td>
                                        {{ $token->folder->owner->nik }}
                                    </td>
                                    <td>
                                        {{ $token->created_at }}
                                    </td>
                                    <td>
                                        <a href="{{ route('citizen.token.show', ['token'=>$token->token]) }}" class="btn btn-sm">Open</a>
                                    </td>
                                </tr>
                            @endforeach
                          @else
                            <tr>
                                <td colspan="5" class="py-2 text-center bg-stone-100">
                                    Belum ada yang mengumpulkan
                                </td>
                            </tr>
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
