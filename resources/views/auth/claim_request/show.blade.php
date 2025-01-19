@extends('layouts.auth')
@section('title', 'login')

@section('content')
<div class="bg-gray-100 h-screen flex items-start justify-center">
    <div class="w-1/2 bg-white">
        <table class="table table-xs border">
            <thead>
                <tr>
                    <th colspan="6" class="text-center">
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
                @if(isset($claimRequest) && $claimRequest != null)
                <tr>
                    <th></th>
                    <td>
                        <div>
                            <address class="not-italic font-bold">
                                {{ $claimRequest->username }}
                            </address>
                        </div>
                        <div>
                            <address class="not-italic font-thin">
                                {{ $claimRequest->email }}
                            </address>
                        </div>
                    </td>
                    <td>{{ $claimRequest->mobile }}</td>
                    <td>
                        <div
                            class="badge badge-outline badge-sm {{ $claimRequest->status == 'waiting' ? 'badge-warning' : 'badge-error' }}">
                            {{ $claimRequest->status }}
                        </div>
                    </td>
                    <td>
                        {{ $claimRequest->token }}
                    </td>
                    <td class="py-4">
                        @if($claimRequest->status == 'waiting')
                        <form
                        action="{{ route('register.cancel', ['token'=>$claimRequest->token]) }}"
                        method="post">
                            @csrf
                            <button
                            class="btn btn-error btn-xs rounded-full mb-2">
                                Cancel Request
                            </button>
                        </form>
                        @elseif($claimRequest->status == 'denied')
                        <form
                        action="{{ route('dukcapil.user.destroy', ['id'=>$claimRequest->id]) }}"
                        method="post">
                            @method('DELETE')
                            @csrf
                            <button
                            class="btn btn-info btn-xs rounded-full mb-2">
                                Resend Request
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
