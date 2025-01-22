# DigiId

DigiId adalah sebuah aplikasi yang dirancang untuk mempermudah manajemen identitas digital dengan aman dan efisien. Proyek ini bertujuan untuk menyediakan solusi yang modern dan terpercaya dalam menyimpan, mengelola, dan memvalidasi identitas digital.

## Pengembang DigiId
1. Felix
2. Sindu
3. Sufyaan
4. Audi
5. Fara
6. Faris
7. Ilham

## Fitur Utama

- **Penyimpanan Data Aman**: Menggunakan enkripsi untuk menjaga kerahasiaan data pengguna.
- **Manajemen Identitas**: Memudahkan pengguna dalam mengelola beberapa identitas dalam satu aplikasi.
- **Verifikasi Identitas**: Fitur untuk memvalidasi identitas secara real-time.
- **Antarmuka yang Intuitif**: Desain UI/UX yang mudah digunakan oleh semua kalangan.

## Teknologi yang Digunakan

- **Backend**: Laravel (PHP)
- **Frontend**: Tailwind & DaisyUI
- **Database**: MySQL
- **Keamanan**: Implementasi enkripsi AES-256

## Cara Instalasi

1. Clone repositori ini:
   ```bash
   git clone https://github.com/Lyxthor/digital-id.git
   ```
2. Masuk ke direktori proyek:
   ```bash
   cd digital-id
   ```
3. Install dependensi backend:
   ```bash
   composer install
   ```
4. Install dependensi frontend:
   ```bash
   npm install
   ```
5. Konfigurasi file environment:
   - Salin file `.env.example` menjadi `.env`.

6. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```
7. Jalankan Seeder Database:
   ```bash
   php artisan db:seed
   ```
8. Jalankan server backend dan frontend:
   - Backend:
     ```bash
     php artisan serve
     ```
   - Frontend:
     ```bash
     npm run dev
     ```
9. Ketikan localhost anda:
   ```bash
   127.0.0.1:8000
   ```
## Kontribusi

Kami menyambut kontribusi dari siapa pun yang ingin membantu meningkatkan DigiId. Berikut langkah-langkah untuk berkontribusi:

1. Fork repositori ini.
2. Buat branch baru untuk fitur atau perbaikan Anda:
   ```bash
   git checkout -b nama-branch-anda
   ```
3. Lakukan perubahan yang diperlukan dan lakukan commit:
   ```bash
   git commit -m "Menambahkan fitur X"
   ```
4. Push branch Anda ke repositori forked:
   ```bash
   git push origin nama-branch-anda
   ```
5. Buat Pull Request ke branch `main` dari repositori ini.

Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami melalui email atau kanal komunitas.

**DigiId - Solusi Identitas Digital Anda!**
