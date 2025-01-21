@extends('layouts.auth')
@section('title', 'Request Login')

@section('content')
<div class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">User Data</h1>
        </div>
        <table class="table w-full table-zebra">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th>#</th>
                    <th>Username & Email</th>
                    <th>No. Telp</th>
                    <th>Status</th>
                    <th>Token</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($claimRequest) && $claimRequest != null)
                <tr>
                    <td class="text-center">1</td>
                    <td>
                        <div class="font-bold">{{ $claimRequest->username }}</div>
                        <div class="text-gray-500">{{ $claimRequest->email }}</div>
                    </td>
                    <td class="text-center">{{ $claimRequest->mobile }}</td>
                    <td class="text-center">
                        <div
                            class="badge {{ $claimRequest->status == 'waiting' ? 'badge-warning' : 'badge-error' }}">
                            {{ ucfirst($claimRequest->status) }}
                        </div>
                    </td>
                    <td class="text-center">{{ $claimRequest->token }}</td>
                    <td class="text-center">
                        @if($claimRequest->status == 'waiting')
                        <form action="{{ route('register.cancel', ['token'=>$claimRequest->token]) }}" method="post">
                            @csrf
                            <button class="btn btn-error btn-xs rounded-full">
                                Cancel Request
                            </button>
                        </form>
                        @elseif($claimRequest->status == 'denied')
                        <form action="{{ route('dukcapil.user.destroy', ['id'=>$claimRequest->id]) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-primary btn-xs rounded-full">
                                Resend Request
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @else
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        No data available
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
