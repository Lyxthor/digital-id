@extends('layouts.citizen')

@section('title', 'Add Citizen')

@section('content')

<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<div class="container flex justify-center">
    <div class="w-1/2">
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
                    <div class="w-1/5">
                        <a href="{{ route('dukcapil.document.index') }}" class="btn btn-success">Back to index</a>
                    </div>
                </div>
                <form action="{{ route('citizen.event.submit', ['id'=>$event->id]) }}" method="post">
                    @csrf
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
                            @if (isset($documents) && $documents!=null && $documents->count() > 0)
                            @php
                                $index = 1;
                            @endphp

                                @foreach($documents as $doc)
                                    <tr>
                                        <th>{{ $index++ }}</th>
                                        <td>{{ $doc->type->name }}</td>
                                        <td>
                                            {{ $doc->updated_at }}
                                        </td>
                                        <td>
                                            <div x-data="{ isOpen: false }">
                                                <button x-on:click="isOpen = true" type="button">
                                                    show document
                                                </button>
                                                <div class="modal-container fixed w-screen z-50 h-screen top-0 left-0 bg-slate-800 bg-opacity-55"
                                                x-show="isOpen"
                                                x-transition.opacity
                                                x-on:click="isOpen = false">
                                                    <div id="modal{{ $index }}" class="h-full">
                                                        <div class="modal-body h-full flex justify-center items-center">
                                                            <img src="{{ route('image.show', ['filename'=>$doc->filename]) }}" alt="" class="w-1/2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="document_ids[]" id="document_id" value="{{ $doc->id }}" @checked($event->requirements->where('id', $doc->type_id)->isNotEmpty())>
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
                      <div class="mt-6">
                        <button type="submit" class="btn  btn-primary w-full">Konfirmasi</button>
                      </div>
                </form>



            </div>
          </div>
    </div>
</div>

@endsection
