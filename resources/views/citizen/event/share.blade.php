@extends('layouts.citizen')

@section('title', 'Add Citizen')

@section('content')
<input type="hidden" value="{{ route('citizen.event.show', ['id'=>$event->id]) }}" id="qrScanUrl">
<div class="container-fluid">
    <div class="w-1/2 aspect-square mx-auto">
        <div class="card bg-white w-full h-full rounded-lg">
            <div class="card-body ">
                <div>
                    <h1 class="font-bold text-2xl text-center w-full">SCAN ME</h1>
                    <p class="text-center text-sm font-thin w-full">Open QR scanner to scan this qr</p>
                    <img src="" alt="" id="qrDisplay" class="w-1/2 mx-auto block">
                    <p class="text-center text-sm font-thin w-full">Or open this link <br> <a href="{{ route('citizen.event.show', ['id'=>$event->id]) }}" class="underline">{{ route('citizen.event.show', ['id'=>$event->id]) }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.4.4/qrcode.js" integrity="sha512-oxrVyBhqnzQ0BzuM0A/6dEIk0alz0p4SpDRaWvtuUoarIc8rnL5lVniHG5Dp21MRFojcQcmKHjaskNXhSaUPPw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const qrDisplay = document.getElementById('qrDisplay')
    const qrScanUrl = document.getElementById('qrScanUrl').value;
    async function GenerateQr()
    {
        return QRCode.toDataURL(qrScanUrl)
    }
    async function LoadQR()
    {
        const dataUrl = await GenerateQr()
        qrDisplay.src = dataUrl
    }
    LoadQR();
</script>
@endsection
