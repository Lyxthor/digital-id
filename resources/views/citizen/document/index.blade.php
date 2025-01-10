@extends('layouts.citizen')

@section('title', 'Documents')

@section('content')
<table class="table table-xs">
    <thead>
      <tr>
        <th></th>
        <th>Document</th>
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
                    <a href="#">Show Document</a>
                </td>
            </tr>
        @endforeach
      @else
        <tr>
            <td colspan="3" class="py-2 text-center bg-stone-100">
                Belum ada document
            </td>
        </tr>
      @endif



    </tbody>
  </table>
@endsection
