<!DOCTYPE html>
<html>
<head>
    <title>Panduan Penggunaan Aplikasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 10px;
            background-color: #f0f0f0;
            padding: 5px 10px;
        }
        .step {
            margin-bottom: 10px;
            padding-left: 15px;
        }
        .step-title {
            font-weight: bold;
            color: #444;
        }
        .icon {
            display: inline-block;
            font-family: 'FontAwesome';
            margin-right: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
        .toc {
            margin-bottom: 30px;
        }
        .toc-item {
            margin-bottom: 5px;
            border-bottom: 1px dotted #ccc;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>PANDUAN PENGGUNAAN APLIKASI</h1>
        <p><strong>{{ $setting->nama_sekolah }}</strong></p>
        <p>{{ $setting->alamat_sekolah }}</p>
    </div>

    {{-- INTRO & TOC --}}
    <div class="section">
        <p>
            Dokumen ini merupakan panduan resmi penggunaan sistem informasi E-Arsip SMP. 
            Panduan ini ditujukan untuk Administrator dan Operator Sekolah dalam mengelola data arsip, siswa, dan kepegawaian.
        </p>

        <div class="toc">
            <h3>Daftar Isi Panduan</h3>
            <div class="toc-item">1. Mengakses Sistem (Login)</div>
            <div class="toc-item">2. Memahami Dashboard Utama</div>
            <div class="toc-item">3. Manajemen Arsip (Surat Masuk/Keluar)</div>
            <div class="toc-item">4. Manajemen Data Siswa & Lulusan</div>
            <div class="toc-item">5. Manajemen Data PTK (Guru/Staff)</div>
            <div class="toc-item">6. Fitur Absensi & Sarpras</div>
            <div class="toc-item">7. Pengaturan Sistem</div>
        </div>
    </div>

    <div class="page-break"></div>

    {{-- 1. LOGIN --}}
    <div class="section">
        <div class="section-title">1. Mengakses Sistem (Login)</div>
        <div class="step">
            <div class="step-title">A. Halaman Masuk</div>
            <p>Buka alamat website aplikasi. Anda akan disambut halaman Login dengan tampilan background animasi.</p>
        </div>
        <div class="step">
            <div class="step-title">B. Kredensial</div>
            <p>Masukkan <strong>Email</strong> dan <strong>Kata Sandi</strong> yang telah terdaftar. Centang "Ingat Saya" jika menggunakan perangkat pribadi.</p>
        </div>
        <div class="step">
            <div class="step-title">C. Lupa Password</div>
            <p>Jika lupa kata sandi, hubungi Administrator utama untuk melakukan reset password akun Anda.</p>
        </div>
    </div>

    {{-- 2. DASHBOARD --}}
    <div class="section">
        <div class="section-title">2. Memahami Dashboard Utama</div>
        <p>Setelah berhasil login, Anda akan diarahkan ke Dashboard.</p>
        <div class="step">
            <div class="step-title">Kartu Statistik</div>
            <p>Menampilkan jumlah total Arsip, Siswa Aktif, Guru (PTK), Lulusan, dan Aset Sekolah secara real-time.</p>
        </div>
        <div class="step">
            <div class="step-title">Akses Cepat</div>
            <p>Tombol shortcut untuk menu yang sering digunakan, seperti "Arsip Baru" atau "Cetak Absen".</p>
        </div>
    </div>

    {{-- 3. ARSIP --}}
    <div class="section">
        <div class="section-title">3. Manajemen Arsip (Buku Induk)</div>
        <p>Menu ini adalah inti dari aplikasi E-Arsip. Digunakan untuk mencatat surat masuk dan keluar.</p>
        <table>
            <thead>
                <tr>
                    <th>Fitur</th>
                    <th>Fungsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Tambah Arsip</strong></td>
                    <td>Mencatat surat baru. Wajib mengisi: Nomor Surat, Perihal, Jenis (Masuk/Keluar), dan Tanggal.</td>
                </tr>
                <tr>
                    <td><strong>Upload File</strong></td>
                    <td>Anda dapat mengunggah scan dokumen (PDF/Gambar) sebagai lampiran arsip.</td>
                </tr>
                <tr>
                    <td><strong>Pencarian</strong></td>
                    <td>Gunakan kotak pencarian di pojok kanan atas tabel untuk mencari arsip berdasarkan Nomor atau Perihal.</td>
                </tr>
                <tr>
                    <td><strong>Cetak Agenda</strong></td>
                    <td>Mencetak laporan agenda surat masuk/keluar per periode tanggal tertentu.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    {{-- 4. SISWA --}}
    <div class="section">
        <div class="section-title">4. Manajemen Data Siswa</div>
        <div class="step">
            <div class="step-title">Data Siswa Aktif</div>
            <p>Menu "Data Siswa" menampilkan seluruh siswa aktif. Anda bisa melakukan Import Data dari Excel untuk mempercepat input data massal.</p>
        </div>
        <div class="step">
            <div class="step-title">Data Lulusan (Alumni)</div>
            <p>Siswa yang telah lulus dapat dipindahkan ke menu "Lulusan". Data alumni tetap tersimpan untuk kebutuhan legalisir atau arsip ijazah di masa depan.</p>
        </div>
    </div>

    {{-- 5. PTK dan ABSENSI --}}
    <div class="section">
        <div class="section-title">5. Data PTK & Fitur Lainnya</div>
        
        <div class="step">
            <div class="step-title">Data PTK (Pendidik & Tenaga Kependidikan)</div>
            <p>Mencatat data Guru dan Staff TU. Data ini terhubung dengan fitur pembuatan SK atau Surat Tugas otomatis.</p>
        </div>

        <div class="step">
            <div class="step-title">Cetak Daftar Hadir (Absensi)</div>
            <p>
                Menu <strong>Daftar Hadir</strong> digunakan untuk mencetak blangko absensi kelas bulanan.
                Sistem akan otomatis menyesuaikan kop surat dan daftar nama siswa berdasarkan kelas yang dipilih.
            </p>
        </div>

        <div class="step">
            <div class="step-title">Nomor Surat Otomatis</div>
            <p>Fitur untuk me-reservasi nomor surat agar tersusun rapi dan tidak ganda. Sangat berguna untuk administrasi TU.</p>
        </div>
    </div>

    {{-- 6. PENGATURAN --}}
    <div class="section">
        <div class="section-title">6. Pengaturan Sistem</div>
        <p>Menu "Pengaturan" hanya dapat diakses oleh Administrator level tertinggi.</p>
        <ul>
            <li><strong>Profil Sekolah:</strong> Ubah Nama Sekolah, Alamat, dan Logo yang muncul di Kop Surat/Laporan.</li>
            <li><strong>Kepala Sekolah:</strong> Atur nama Kepala Sekolah dan NIP untuk tanda tangan otomatis di laporan.</li>
            <li><strong>Tahun Ajaran:</strong> Ganti Tahun Ajaran aktif dan Semester (Ganjil/Genap) yang berlaku saat ini.</li>
        </ul>
    </div>

    <div class="footer">
        Dicetak pada: {{ $date }} oleh {{ $user->name }} | E-Arsip System v2.0
    </div>

</body>
</html>
