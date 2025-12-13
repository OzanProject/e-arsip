<!DOCTYPE html>
<html>
<head>
    <title>Daftar Hadir {{ $kelas }} - {{ $bulanNama }} {{ $tahun }}</title>
    <style>
        /* CSS Khusus untuk DomPDF (Dioptimalkan untuk Portrait A4/Narrow) */
        body {
            font-family: 'Times New Roman', Times, serif; 
            font-size: 7.5pt;
            margin: 0.8cm;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h3 {
            margin: 0;
            font-size: 14pt; 
            font-weight: bold;
        }
        .header p {
            margin: 1px 0;
            font-size: 9pt;
        }
        .header-logo {
            display: inline-block;
            float: left;
            margin-right: 15px;
            width: 70px; /* Lebar Logo */
        }
        .header-text {
            display: inline-block;
            text-align: center;
            width: 80%; /* Lebar Teks Header */
        }
        .info {
            margin-bottom: 10px;
            font-size: 8pt;
        }
        .info table {
            width: 50%;
            border-collapse: collapse;
            float: left;
            text-align: left;
        }
        .info td {
            padding: 1px 0;
            line-height: 1.2;
        }
        .table-absensi {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
        }
        .table-absensi th, .table-absensi td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            vertical-align: top;
            height: 14px;
        }
        .table-absensi th {
            background-color: #f0f0f0; 
            font-weight: bold;
        }
        
        /* Penyesuaian Lebar Kolom */
        .col-no { width: 3%; }
        .col-nama { width: 18%; text-align: left !important; padding-left: 5px; }
        .col-hari { width: 1.8%; font-size: 7pt; padding: 1px; }
        .col-ttd-gabungan { width: 17%; } 
        .col-rekap { width: 2%; }

        .footer-ttd {
            width: 100%;
            margin-top: 25px;
            font-size: 8pt;
        }
        .footer-ttd table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-ttd td {
            width: 33.33%;
            text-align: center;
            padding-top: 40px;
            vertical-align: top;
            line-height: 1.3;
        }
        .ttd-spacer {
            height: 30px;
        }
        .keterangan-ttd {
            width: 33.33%;
            text-align: left !important;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-logo">
            {{-- LOGO SEKOLAH DINAMIS --}}
            @if(isset($setting) && $setting->logo_path)
                <img src="{{ public_path('storage/' . $setting->logo_path) }}" 
                     alt="Logo" style="width: 100%; height: auto;">
            @endif
        </div>
        <div class="header-text">
            <h3>DAFTAR HADIR SISWA</h3>
            {{-- NAMA SEKOLAH DINAMIS --}}
            <p>{{ strtoupper($setting->nama_sekolah ?? 'NAMA SEKOLAH BELUM DIATUR') }}</p>
            <p>BULAN: {{ strtoupper($bulanNama) }} TAHUN: {{ $tahun }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="info">
        <table>
            <tr><td>Kelas</td><td>: <strong>{{ $kelas }}</strong></td></tr>
            <tr><td>Tahun Ajaran</td><td>: {{ ($tahun) }}/{{ ($tahun+1) }}</td></tr>
        </table>
        <div style="clear: both;"></div>
    </div>

    <table class="table-absensi">
        <thead>
            <tr>
                <th rowspan="2" class="col-no">No.</th>
                <th rowspan="2" class="col-nama">Nama Siswa</th>
                <th colspan="{{ $jumlahHari }}">Tanggal</th>
                <th colspan="2">Rekap</th>
                <th colspan="2" class="col-ttd-gabungan">Keterangan</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= $jumlahHari; $i++)
                    <th class="col-hari">{{ $i }}</th>
                @endfor
                <th class="col-rekap">H</th>
                <th class="col-rekap">I/S/A</th>
                <th class="col-ttd">TTD Guru</th>
                <th class="col-catatan">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="col-nama">{{ $s->nama }}</td>
                    @for ($i = 1; $i <= $jumlahHari; $i++)
                        <td></td> {{-- Kolom untuk paraf/tanda Hadir --}}
                    @endfor
                    <td></td> {{-- Rekap Hadir --}}
                    <td></td> {{-- Rekap Izin/Sakit/Alpha --}}
                    <td></td> {{-- TTD Guru --}}
                    <td></td> {{-- Catatan --}}
                </tr>
            @endforeach
            {{-- Tambahkan baris kosong jika jumlah siswa sedikit (memastikan minimal 30 baris) --}}
            @if(count($siswa) < 30)
                @for ($j = count($siswa); $j < 30; $j++)
                    <tr>
                        <td>{{ $j + 1 }}</td>
                        <td class="col-nama"></td>
                        @for ($i = 1; $i <= $jumlahHari; $i++)
                            <td></td>
                        @endfor
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>

    <table class="footer-ttd">
        <tr>
            <td class="keterangan-ttd">
                <br>
                <strong>Keterangan:</strong><br>
                H = Hadir, I = Izin, S = Sakit, A = Alpha
            </td>
            <td>
                {{-- Nama Kota/Kabupaten Diambil dari Alamat atau Diabaikan --}}
                {{-- Menggunakan Nama Sekolah jika Alamat kosong --}}
                {{ $setting->nama_sekolah ?? '............' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                
                <br>
                {{-- Jabatan Guru (Dibuat Kondisional) --}}
                @if(isset($guruMapel) && !empty($guruMapel))
                    Guru Mata Pelajaran
                @else
                    Wali Kelas / Guru Mata Pelajaran
                @endif
                <div class="ttd-spacer"></div>
                
                {{-- NAMA GURU/WALI KELAS - Kosongkan jika tidak ada data --}}
                <strong>{{ isset($namaGuru) ? $namaGuru : '(Nama Guru)' }}</strong>
                <br>NIP/NUPTK. ..................................
            </td>
            <td>
                Mengetahui,
                <br>Kepala Sekolah
                <div class="ttd-spacer"></div>
                
                {{-- NAMA KEPALA SEKOLAH DINAMIS (Dihilangkan kurung kurawal) --}}
                <strong>{{ $setting->kepala_sekolah ?? '(Nama Kepala Sekolah)' }}</strong>
                
                {{-- NIP KEPALA SEKOLAH DINAMIS --}}
                <br>NIP. {{ $setting->nip_kepala_sekolah ?? '..................................' }}
            </td>
        </tr>
    </table>

</body>
</html>