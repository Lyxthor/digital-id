<?php

namespace App\Helpers;

class ImageCipherHelper
{
    private static $cipher = 'AES-256-CBC'; // Algoritma enkripsi
    private static $key = null;

    /**
     * Set kunci enkripsi
     */
    private static function getKey()
    {
        if (self::$key === null) {
            self::$key = env('EN'); // Menggunakan APP_KEY dari .env
            self::$key = substr(self::$key, 0, 32); // Panjang kunci AES-256 adalah 32 byte
        }
        return self::$key;
    }

    /**
     * Encrypt data
     */
    public static function encrypt($data)
    {
        $key = self::getKey();
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher)); // Generate IV
        $encrypted = openssl_encrypt($data, self::$cipher, $key, 0, $iv);

        return base64_encode($iv . $encrypted); // Gabungkan IV dengan data terenkripsi
    }

    /**
     * Decrypt data
     */
    public static function decrypt($data)
    {
        $key = self::getKey();
        $data = base64_decode($data);
        $ivLength = openssl_cipher_iv_length(self::$cipher);
        $iv = substr($data, 0, $ivLength); // Ambil IV
        $encrypted = substr($data, $ivLength); // Ambil data terenkripsi

        return openssl_decrypt($encrypted, self::$cipher, $key, 0, $iv);
    }
}
