@extends('layouts.citizen')

@section('title', 'Share Event')

@section('content')
<input type="hidden" value="{{ route('citizen.event.show', ['id'=>$event->id]) }}" id="qrScanUrl">
<div class="container mx-auto py-8">
    <div class="mb-4">
        <a href="{{ route('citizen.event.index') }}" class="btn btn-sm btn-success">Kembali</a>
    </div>
    <div class="flex justify-center">
        <div class="card bg-white shadow-lg rounded-lg overflow-hidden w-full max-w-md">
            <div class="card-body p-6">
                <h1 class="font-bold text-2xl text-center mb-4">SCAN ME</h1>
                <p class="text-center text-sm font-thin mb-4">Open QR scanner to scan this QR</p>
                <div class="flex justify-center mb-4">
                    <img src="" alt="QR Code" id="qrDisplay" class="w-1/2">
                </div>
                <p class="text-center text-sm font-thin">Or open this link:</p>
                <p class="text-center text-sm font-thin">
                    <a href="{{ route('citizen.event.show', ['id'=>$event->id]) }}" class="underline text-blue-600">{{ route('citizen.event.show', ['id'=>$event->id]) }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.4.4/qrcode.js" integrity="sha512-oxrVyBhqnzQ0BzuM0A/6dEIk0alz0p4SpDRaWvtuUoarIc8rnL5lVniHG5Dp21MRFojcQcmKHjaskNXhSaUPPw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const qrDisplay = document.getElementById('qrDisplay');
    const qrScanUrl = document.getElementById('qrScanUrl').value;

    async function GenerateQr() {
        return QRCode.toDataURL(qrScanUrl);
    }

    async function LoadQR() {
        const dataUrl = await GenerateQr();
        qrDisplay.src = dataUrl;
    }

    LoadQR();
</script>
@endsection
