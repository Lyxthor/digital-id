@extends('layouts.dukcapil')

@section('content')
<div class="container px-6">
    <div class="w-full mb-6">
        <h2 class="text-lg font-bold capitalize">Daftar data penduduk</h2>
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a>Home</a></li>
                <li><a>Documents</a></li>
                <li>Add Document</li>
            </ul>
        </div>
        <div class="flex items-end justify-between">
            <label class="input input-bordered input-sm flex w-80 items-center gap-2">
                <input type="text" class="grow" placeholder="Search" />
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 16"
                    fill="currentColor"
                    class="h-4 w-4 opacity-70">
                    <path
                    fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd" />
                </svg>
            </label>

            <a href="{{ route('dukcapil.citizen.create') }}" class="btn btn-md btn-primary font-semibold">
                + New Citizen
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-xs">
          <thead>
            <tr>
              <th></th>
              <th>Name</th>
              <th>Gender</th>
              <th>Birth Place</th>
              <th>Job</th>
              <th>Age</th>
              <th>Action</th>
              <th>Document</th>
            </tr>
          </thead>
          <tbody>
            @if (isset($citizens) && $citizens!=null && $citizens->count() > 0)
                @php
                    $index = 1;
                @endphp
                @foreach($citizens as $c)
                <tr>
                    <th>{{ $index++ }}</th>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->gender }}</td>
                    <td>{{ $c->birth_place }}</td>
                    <td>{{ $c->job }}</td>
                    <td>{{ (int) $date->parse($c->birth_date)->diffInYears($date->now()) }}</td>
                    <td>
                        <a href="{{ route('dukcapil.citizen.edit',['id'=>$c->id]) }}" class="btn btn-xs btn-warning">
                            edit
                        </a>
                        <a href="{{ route('dukcapil.citizen.show',['id'=>$c->id]) }}" class="btn btn-xs btn-success">
                            show
                        </a>
                        <form action="{{ route('dukcapil.citizen.destroy',['id'=>$c->id]) }}" method="post" class="inline">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-xs btn-error">delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('dukcapil.document.create') }}?citizen={{ $c->id }}" class="btn btn-xs btn-primary">+ Add Document</a>
                    </td>
                  </tr>
                @endforeach
            @else

            @endif


          </tbody>
          <tfoot>
            <tr>
              <th></th>
              <th>Name</th>
              <th>Job</th>
              <th>company</th>
              <th>location</th>
              <th>Last Login</th>
              <th>Favorite Color</th>
            </tr>
          </tfoot>
        </table>
      </div>
</div>
@endsection
