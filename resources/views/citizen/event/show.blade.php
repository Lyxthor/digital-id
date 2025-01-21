@extends('layouts.citizen')

@section('title', 'Show Event')

@section('content')
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<div class="container mx-auto px-6">
    <div class="w-2/3 mx-auto">
        <div class=" mb-4">
            <a href="{{ route('citizen.event.index') }}" class="btn btn-sm btn-success">Kembali</a>
        </div>
        <div class="bg-white shadow-md rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-end flex-wrap mb-2">
                    <div class="breadcrumbs w-full text-sm mb-4">
                        <ul class="flex space-x-2">
                            <li><a href="#" class="text-blue-500">Home</a></li>
                            <li><a href="#" class="text-blue-500">Event</a></li>
                            <li>Show Event</li>
                        </ul>
                    </div>

                    <div class="w-3/5">
                        <div class="flex items-end gap-5">
                            <div>
                                <h2 class="text-lg font-bold">{{ $event->title }}</h2>
                                <div class="text-xs text-slate-500">Diupload pada, {{ $event->updated_at }}</div>
                                <div class="text-xs text-slate-500">oleh {{ $event->author->name }}</div>
                            </div>
                        </div>
                    </div>
                    @if ($event->reviewers->where('id', $citizen->id)->isNotEmpty() || $event->author_id == $citizen->id)
                    <div class="w-1/5 flex justify-end">
                        <a href="{{ route('citizen.event.edit', ['id'=>$event->id]) }}" class="btn btn-sm btn-warning">Edit</a>
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
            </div>
        </div>
    </div>
    @if ($event->reviewers->where('id', $citizen->id)->isNotEmpty() || $event->author_id == $citizen->id)
        <div class="w-2/3 mx-auto mt-6">
            <div class="bg-white shadow-md rounded-lg mb-6">
                <div class="p-6">
                    <table class="table-auto w-full text-left">
                        <thead>
                            <tr class="bg-gray-100">
                                <th colspan="5" class="text-center py-3">Reviewer</th>
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
                                <tr class="border-b">
                                    <th class="py-4">{{ $index++ }}</th>
                                    <td>{{ $reviewer->name }}</td>
                                    <td>{{ $reviewer->nik }}</td>
                                </tr>
                            @endforeach
                          @else
                            <tr>
                                <td colspan="5" class="py-2 text-center bg-stone-100">Belum ada yang mengumpulkan</td>
                            </tr>
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="w-2/3 mx-auto mt-6">
            <div class="bg-white shadow-md rounded-lg mb-6">
                <div class="p-6">
                    <table class="table-auto w-full text-left">
                        <thead>
                            <tr class="bg-gray-100">
                                <th colspan="5" class="text-center py-3">Data Pengumpulan</th>
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
                                <tr class="border-b">
                                    <th class="py-4">{{ $index++ }}</th>
                                    <td>{{ $token->folder->owner->name }}</td>
                                    <td>{{ $token->folder->owner->nik }}</td>
                                    <td>{{ $token->created_at }}</td>
                                    <td>
                                        <a href="{{ route('citizen.token.show', ['token'=>$token->token]) }}" class="btn btn-sm">Open</a>
                                    </td>
                                </tr>
                            @endforeach
                          @else
                            <tr>
                                <td colspan="5" class="py-2 text-center bg-stone-100">Belum ada yang mengumpulkan</td>
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
