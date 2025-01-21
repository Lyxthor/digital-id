@extends('layouts.dukcapil')

@section('title', 'Add Citizen')

@section('content')
<div class="container flex justify-center">
    <div class="w-2/3">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                    <ul class="flex justify-between w-full">
                        <div class="breadcrumbs text-sm">
                            <ul>
                                <li><a>Home</a></li>
                                <li><a>Data User</a></li>
                            </ul>
                        </div>
                        <li><a href="{{ route('dukcapil.citizen.index') }}" class="btn btn-sm btn-primary">Kembali</a></li>
                    </ul>
                <div class="grid grid-cols-2 justify-between items-end flex-wrap">
                    <div class="border h-full flex justify-center items-center">
                        <img src="{{ route('image.show',['filename'=>$citizen->pp_img_path]) }}" alt="" class="w-1/2 aspect-square object-cover">
                    </div>
                    <div class="border">
                        <table class="table table-xs">
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ $citizen->name }}</td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>{{ $citizen->nik }}</td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>{{ $citizen->gender == 'f' ? 'female' : 'male' }}</td>
                                </tr>
                                <tr>
                                    <td>Date & Birth Place</td>
                                    <td>{{ $citizen->birth_place }}, {{ $citizen->birth_date }}</td>
                                </tr>
                                <tr>
                                    <td>Blood Type</td>
                                    <td>{{ $citizen->blood_type }}</td>
                                </tr>
                                <tr>
                                    <td>Religion</td>
                                    <td>{{ $citizen->religion }}</td>
                                </tr>
                                <tr>
                                    <td>Education</td>
                                    <td>{{ $citizen->education }}</td>
                                </tr>
                                <tr>
                                    <td>Job</td>
                                    <td>{{ $citizen->job }}</td>
                                </tr>
                                <tr>
                                    <td>Marriage</td>
                                    <td>{{ $citizen->marriage_status }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>
                                        {{ $citizen->address }},
                                        {{ $citizen->village }},
                                        {{ $citizen->district }},
                                        {{ $citizen->regency }},
                                        {{ $citizen->province }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="w-full">
                    <table class="table table-xs border">
                        <thead>
                            @php
                                $index = 0;

                                $claim_request_exists = (isset($citizen->claim_requests) &&
                                $citizen->claim_requests != null &&
                                $citizen->claim_requests->count() > 0)
                            @endphp
                            <tr>
                                <th
                                colspan="{{ $claim_request_exists ? 7 : 6 }}"
                                class="text-center">
                                    <span class="text-md">User Data</span>
                                </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th class="border-r">Username & Email</th>

                                <th class="border-r">No. Telp</th>
                                <th class="border-r">Status</th>
                                <th class="border-r">Token</th>
                                <th class="border-r">Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            @if(isset($citizen->user) && $citizen->user != null)
                            <tr>
                                <th >{{ ++$index }}</th>
                                <td>
                                    <div>
                                        <address class="not-italic font-bold">
                                            {{ $citizen->user->username }}
                                        </address>
                                    </div>
                                    <div>
                                        <address class="not-italic font-thin">
                                            {{ $citizen->user->email }}
                                        </address>
                                    </div>
                                </td>

                                <td>{{ $citizen->user->mobile }}</td>
                                <td>
                                    <div
                                        class="badge badge-outline badge-sm badge-info">
                                        active
                                    </div>
                                </td>
                                <td>-</td>
                                <td class="py-4">
                                    <form
                                    action="{{ route('dukcapil.user.destroy', ['id'=>$citizen->user->id]) }}"
                                    method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button
                                        class="btn btn-error btn-xs rounded-full mb-2">
                                            Remove User
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @if($claim_request_exists)
                                @foreach ($citizen->claim_requests as $claim)
                                <tr>
                                    <th >{{ ++$index }}</th>
                                    <td>
                                        <div>
                                            <address class="not-italic font-bold">
                                                {{ $claim->username }}
                                            </address>
                                        </div>
                                        <div>
                                            <address class="not-italic font-thin">
                                                {{ $claim->email }}
                                            </address>
                                        </div>
                                    </td>

                                    <td>{{ $claim->mobile }}</td>
                                    <td>
                                        <div
                                        class="badge badge-outline badge-sm {{ $claim->status=='waiting' ? 'badge-warning' : 'badge-error'  }}">
                                        {{ $claim->status }}
                                        </div>
                                    </td>
                                    <td>{{ $claim->token }}</td>
                                    <td class="py-4">
                                        <form
                                        action="{{ route('dukcapil.user.accept', ['id'=>$claim->id]) }}"
                                        method="post">
                                            @csrf
                                            <button
                                            type="submit"
                                            class="btn btn-success btn-xs rounded-full mb-2">
                                                Accept
                                            </button>
                                        </form>

                                        @if($claim->status != 'denied')
                                        <form
                                        action="{{ route('dukcapil.user.deny', ['id'=>$claim->id]) }}"
                                        method="post">
                                            @csrf
                                            <button
                                            type="submit"
                                            class="btn btn-warning btn-xs rounded-full">
                                                Deny
                                            </button>
                                        </form>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td
                                    colspan="6"
                                    class="text-center py-3 bg-stone-100">
                                        Belum ada data user
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="w-full">
                    <table class="table table-xs border">
                        <thead>
                            <tr>
                                <th
                                colspan="4"
                                class="text-center py-4">
                                    <span class="text-sm">Document Data</span>
                                </th>
                            </tr>
                            <tr>
                                <th class="py-5"></th>
                                <th class="border-r">Document</th>
                                <th class="border-r">Last Modified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($documents) && $documents != null && $documents->count() > 0)
                                @php
                                    $index = 1;
                                @endphp
                                @foreach ($documents as $doc)
                                    <tr>
                                        <th>{{ $index++ }}</th>
                                        <td>{{ $doc->type->name }}</td>
                                        <td>
                                            {{ $doc->updated_at }}
                                        </td>
                                        <td class="flex gap-2">
                                            <div x-data="{ isOpen: false }">
                                                <button x-on:click="isOpen = true" class="btn btn-xs">
                                                    show
                                                </button>
                                                <div class="modal-container fixed w-screen z-50 h-screen top-0 left-0 bg-slate-800 bg-opacity-55"
                                                    x-show="isOpen" x-transition.opacity x-on:click="isOpen = false">
                                                    <div id="modal{{ $index }}" class="h-full">
                                                        <div class="modal-body h-full flex justify-center items-center">
                                                            <img src="{{ route('image.show', ['filename' => $doc->filename]) }}"
                                                                alt="" class="h-full">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('dukcapil.document.destroy', ['id'=>$doc->id]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-error">delete</button>
                                            </form>
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
                </div>
            </div>

          </div>
    </div>
</div>

@endsection
