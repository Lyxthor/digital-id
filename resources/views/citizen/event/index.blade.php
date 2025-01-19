@extends('layouts.citizen')

@section('title', 'Add Citizen')

@section('content')
<div class="container-fluid">
    <div class="w-full flex gap-3 justify-end mb-4">
        <a
        href="{{ route('citizen.event.scan') }}"
        class="btn btn-outline btn-primary">
            Scan Event
        </a>
        <a
        href="{{ route('citizen.event.create') }}"
        class="btn btn-primary">
            + Create Event
        </a>
    </div>
    <div class="row grid grid-cols-3 gap-4">
        @if (isset($events) && $events != null && $events->count() > 0)
            @foreach ($events as $event)
                <div class="card bg-white shadow">
                    <div class="card-body">
                        <h4 class="card-title font-bold">{{ $event->title }}</h4>
                        <p class="text-sm mb-2">
                            {{ $event->desc }}
                        </p>
                        <div class="grid grid-cols-3 justify-end gap-2">
                            <a
                            href="{{ route('citizen.event.edit', ['id'=>$event->id]) }}"
                            class="btn btn-xs rounded-sm btn-warning"
                            >
                                Edit
                            </a>
                            <a
                            href="{{ route('citizen.event.show', ['id'=>$event->id]) }}"
                            class="btn btn-xs rounded-sm btn-success"
                            >
                                Show
                            </a>
                            <button class="btn btn-xs rounded-sm btn-error ">Delete</button>
                            <a
                            href="{{ route('citizen.event.share', ['id'=>$event->id]) }}"
                            class="btn btn-xs rounded-sm btn-secondary ">Share</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        <div class="col-span-3">
            <h1 class="text-center">Event Not Found</h1>
        </div>
        @endif
    </div>
</div>
@endsection
