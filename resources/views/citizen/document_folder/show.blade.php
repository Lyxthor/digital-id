@extends('layouts.citizen')

@section('content')
<div class="container mx-auto h-96">
    <div class="card bg-white h-full">
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
    </form>
    </div>
</div>
@endsection
