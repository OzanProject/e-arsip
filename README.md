# 🏫 E-Arsip SMP Modern (Sistem Informasi Sekolah Terpadu)

**E-Arsip SMP** adalah sistem manajemen informasi sekolah berbasis web yang modern dan responsif. Aplikasi ini dirancang untuk mendigitalisasi pengelolaan arsip surat, data siswa, pendidik (PTK), dan aset sekolah dalam satu platform terintegrasi dengan antarmuka pengguna (UI) yang elegan dan pengalaman pengguna (UX) yang interaktif.

![Laravel](https://img.shields.io/badge/Laravel-11/12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0+-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.0+-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![AdminLTE](https://img.shields.io/badge/AdminLTE-3.0+-green?style=for-the-badge&logo=adminlte&logoColor=white)

---

## ✨ Fitur Unggulan

Aplikasi ini telah dimodernisasi dengan standar "CEO Modern Kekinian" untuk memberikan kesan premium dan profesional:

### 1. 🎨 Modern & Responsive UI/UX
- **Landing Page Elegan**: Halaman depan publik dengan hero section menarik, pencarian arsip, dan widget informasi terbaru.
- **Admin Dashboard Premium**: Dashboard admin dengan statistik realtime, grafik, dan shortcut akses cepat.
- **Micro-Interactions**: Efek hover, transisi halus, dan animasi elemen untuk pengalaman yang hidup.
- **AOS (Animate On Scroll)**: Integrasi animasi scroll di seluruh halaman (Landing & Admin) untuk tampilan yang dinamis.
- **Dynamic Preloader**: Loading screen kontekstual yang halus ("Memuat Data...", "Memproses...") namun cerdas (tidak mengganggu saat submit form).

### 2. 📨 Manajemen Arsip Digital
- **Klasifikasi Surat**: Kelola kode klasifikasi surat masuk dan keluar sesuai standar.
- **Buku Induk Arsip**: Pencatatan surat masuk/keluar lengkap dengan upload file digital.
- **Pencarian Cepat**: Temukan arsip berdasarkan nomor surat, perihal, atau tanggal dalam hitungan detik.
- **Export Laporan**: Cetak agenda surat masuk/keluar dalam format Excel atau PDF.

### 3. 🎓 Manajemen Data Kependidikan
- **Data Siswa Aktif**: Database lengkap siswa dengan foto, NISN, dan data pribadi.
- **Sorting Cerdas**: Data siswa otomatis diurutkan berdasarkan Kelas (7, 8, 9) -> Sub-Kelas -> Nama.
- **Data PTK (Guru & Staf)**: Manajemen biodata pendidik dan tenaga kependidikan.
- **Import/Export Data**: Fitur import Excel untuk input data massal dan export PDF/Excel untuk laporan.

### 4. 📝 Fitur Akademik & Absensi
- **Cetak Absensi Kelas**: Generator PDF daftar hadir bulanan otomatis dengan Kop Surat sekolah.
- **Manajemen Lulusan**: Arsip data alumni yang terpisah dari siswa aktif.
- **Pengaturan Tahun Ajaran**: Konfigurasi tahun ajaran dan semester aktif secara dinamis.

### 5. 🛠 Administrasi Sistem & Bantuan
- **User Guide PDF**: Panduan penggunaan lengkap yang digenerate otomatis ("Buka Panduan" di Dashboard).
- **Global SweetAlert2**: Notifikasi popup modern untuk sukses, error, peringatan, dan konfirmasi hapus data yang aman.
- **Pengaturan Sekolah**: Ubah Nama Sekolah, Alamat, Kepala Sekolah, dan Logo secara mandiri melalui menu Settings.

---

## 🚀 Teknologi yang Digunakan

- **Backend**: Laravel 11/12 (PHP 8.2+)
- **Frontend**: Blade Templating, Tailwind CSS
- **Interaktivitas**: Alpine.js (Modal, Dropdown), Vanilla JS
- **Database**: MySQL / MariaDB
- **Library Tambahan**:
  - `maatwebsite/excel`: Export & Import Data
  - `barryvdh/laravel-dompdf`: Cetak Laporan PDF
  - `sweetalert2`: Notifikasi & Alert
  - `aos`: Animate On Scroll Library
  - `fontawesome`: Ikon Vektor

---

## 📦 Instalasi & Penggunaan

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal Anda:

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/OzanProject/e-arsip.git
   cd e-arsip
   ```

2. **Install Dependensi PHP & JS**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` ke `.env` dan sesuaikan koneksi database Anda.
   ```bash
   cp .env.example .env
   # Edit .env sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD
   ```

4. **Generate Key & Migrasi Database**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```
   *(Gunakan `--seed` untuk mengisi data dummy awal seperti akun admin default)*

5. **Jalankan Development Server**
   Buka dua terminal terpisah:
   
   **Terminal 1 (Laravel Server):**
   ```bash
   php artisan serve
   ```
   
   **Terminal 2 (Vite Build):**
   ```bash
   npm run dev
   ```

6. **Akses Aplikasi**
   Buka browser dan kunjungi `http://127.0.0.1:8000`.

---

## 🔐 Akun Default (Seeder)

Jika Anda menggunakan seeder bawaan, gunakan kredensial berikut untuk masuk:

- **Email**: `admin@smpn4kdp.sch.id`
- **Password**: `password` (atau `12345678`)

---

## 📜 Lisensi

Project ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">
  <small>Dibuat dengan ❤️ untuk kemajuan pendidikan Indonesia.</small>
</p>
