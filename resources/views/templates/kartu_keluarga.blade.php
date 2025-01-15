@extends('layouts.template')

@section('title', 'KTP Template');
@section('content')
<div id="content" class="card bg-base-100 shadow-xl aspect-video">
    <table class="table table-xs">
        <thead>
          <tr>
            <th class="py-5"></th>
            <th class="border-r">Nama</th>
            <th class="border-r">NIK</th>
            <th class="border-r">Tempat / Tgl Lahir</th>
            <th class="border-r">Pekerjaan</th>
            <th class="border-r">Posisi</th>
          </tr>
        </thead>
        <tbody>
            @if (isset($members) && $members!=null && count($members) > 0)
            @php
                $index = 1;
            @endphp
            @foreach($members as $member)
                <tr>
                    <th>{{ $index++ }}</th>
                    <td>{{ $member['name'] }}</td>
                    <td>
                        {{ $member['nik'] }}
                    </td>
                    <td>
                        {{ $member['birth_place'] }}, {{ $member['birth_date'] }}
                    </td>
                    <td>
                        {{ $member['job'] }}
                    </td>
                    <td>
                        {{ $member['role'] }}
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
</div>

@endsection
