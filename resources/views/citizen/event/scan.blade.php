@extends('layouts.citizen')

@section('title', 'Add Citizen')

@section('content')

<div class="container mx-auto px-4">
    <div class="mb-4">
        <a href="{{ route('citizen.event.index') }}" class="btn btn-sm btn-primary">Kembali</a>
    </div>

    <div class="card mx-auto max-w-lg bg-base-100">
        <div class="card-body">
            <h1 class="font-bold text-center">QR Code Scanner</h1>
            <div class="font-thin text-xs text-center mb-4">Point camera at QR code</div>
            <div id="reader" class="w-full"></div>
            <p class="text-xs text-center mt-4">Scanned Result: <span id="result">None</span></p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const resultElement = document.getElementById("result");

        const onScanSuccess = (decodedText, decodedResult) => {
            console.log(`Decoded Text: ${decodedText}`);
            resultElement.innerText = decodedText;
            window.location.href = decodedText;
        };

        const onScanFailure = (error) => {
            console.warn(`QR scan failed: ${error}`);
        };

        const html5QrCodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: { width: 250, height: 250 },
        });

        html5QrCodeScanner.render(onScanSuccess, onScanFailure);
    });
</script>
@endsection
