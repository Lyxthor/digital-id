<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ImageCipherHelper;
use Illuminate\Support\Facades\Storage;
use App\Helpers\TextCipherHelper;

class ImageController extends Controller
{
    public function show($filename)
    {
        $filePath = 'images/'.$filename;

        // Pastikan file ada
        if (!Storage::disk('public')->exists($filePath)) {
            dd($filePath);
            abort(404, 'File not found.');
        }

        // Baca dan dekripsi konten file
        $encryptedContent = Storage::disk('public')->get($filePath);
        $decryptedContent = ImageCipherHelper::decrypt($encryptedContent);

        // Tentukan MIME type berdasarkan ekstensi file
        $mimeType = 'image/' . pathinfo($filename, PATHINFO_EXTENSION);

        // Kembalikan respons gambar
        return response($decryptedContent, 200)->header('Content-Type', $mimeType);
    }
    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'image' => 'required|string',
            ]);
            $generateHashedName = function ($file) {
                return hash('sha256', uniqid('', true)) . '.enc'; // Menggunakan ekstensi .enc untuk file terenkripsi
            };
            // Extract the base64 string (assuming it's a PNG image)
            $imageData = $request->input('image');
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);

            // Decode the base64 string
            $decodedImage = base64_decode($imageData);

            // Define a file name (you can also use unique IDs)
            $fileName = 'image_' . time() . '.png';

            $encryptedContent = ImageCipherHelper::encrypt($decodedImage); // Enkripsi konten file
            $fileName = TextCipherHelper::encrypt($imageData, env('ENCRIPTION_KEY')); // Nama file hash dengan ekstensi
            $fileName = $generateHashedName($fileName);
            // Simpan file terenkripsi ke path tujuan
            Storage::disk('public')->put("images/$fileName", $encryptedContent);

            // Simpan nama file ke database
            return response()->json([
                "message"=>"success",
                "filename"=>$fileName,
                "success"=>true
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                "message"=>"error",
                "success"=>false
            ], 500);
        }
    }
    public static function saveImage($file) // Save and return the image path
    {
        $generateHashedName = function ($file) {
            return hash('sha256', uniqid('', true)) . '.enc'; // Menggunakan ekstensi .enc untuk file terenkripsi
        };

        $fileContent = file_get_contents($file);
        $encryptedContent = ImageCipherHelper::encrypt($fileContent); // Enkripsi konten file
        $fileName = TextCipherHelper::encrypt($file, env('ENCRIPTION_KEY')); // Nama file hash dengan ekstensi
        $fileName = $generateHashedName($file);
        // Simpan file terenkripsi ke path tujuan
        Storage::disk('public')->put("images/$fileName", $encryptedContent);

        // Simpan nama file ke database
        return $fileName;

    }
}
