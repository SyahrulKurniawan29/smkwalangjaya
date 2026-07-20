# SMK Walang Jaya — Aplikasi Bimbingan Konseling & Absensi (Initial scaffold)

Ini adalah commit awal (scaffold) untuk aplikasi bimbingan konseling siswa dan absensi.

Stack: Laravel + Inertia + Vue + PostgreSQL

Fitur awal yang disertakan:
- Struktur project dasar (models, migrations, seeders)
- Auth: arah penggunaan Laravel Breeze + Inertia (tidak disertakan paket, jalankan composer/installer lokal)
- Migrasi & seeder contoh untuk roles, users (admin/guru_bk/wali_kelas), 1 kelas, 5 siswa

Instruksi instalasi lokal (ringkas):

1. Clone repo dan pindah ke folder:
   git clone git@github.com:SyahrulKurniawan29/smkwalangjaya.git
   cd smkwalangjaya

2. Install PHP deps (jalankan di mesin lokal):
   composer install

3. Install JS deps dan build assets:
   npm install
   npm run dev

4. Copy .env dan sesuaikan DB (default di .env.example menggunakan PostgreSQL):
   cp .env.example .env
   php artisan key:generate

5. Migrasi dan seeder:
   php artisan migrate --seed

6. Jalankan server:
   php artisan serve

Contoh login (dihasilkan oleh seeder):
- admin@example.com / password
- guru-bk@example.com / password
- walikelas@example.com / password

Selanjutnya: setelah Anda jalankan composer & npm di lokal, pasang Laravel Breeze (Inertia + Vue) dengan:
php artisan breeze:install inertia
npm install && npm run dev

---

Silakan lihat direktori database/migrations dan database/seeders untuk migrasi & seed sample.
