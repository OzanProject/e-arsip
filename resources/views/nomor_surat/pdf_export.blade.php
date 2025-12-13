<!DOCTYPE html>
<html>
<head>
    <title>Ekspor Klasifikasi Nomor Surat</title>
    {{-- Menggunakan charset dan viewport yang standar --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10pt; 
            margin: 20px; /* Tambahkan margin untuk print */
        }
        
        /* HEADER UTAMA */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 9pt;
            color: #555;
        }

        /* INFORMASI CETAK */
        .info {
            font-size: 8pt;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            display: flex;
            justify-content: space-between;
        }

        /* TABEL DATA */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 0; 
            table-layout: fixed; /* Memastikan lebar kolom tetap */
        }
        th, td { 
            border: 1px solid #000; 
            padding: 8px 10px; 
            text-align: left; 
            line-height: 1.3;
        }
        thead th {
            background-color: #f0f0f0; /* Latar belakang abu-abu di header */
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Garis zebra (striped) */
        }
        td:nth-child(1) {
            text-align: center; /* Kolom No. di tengah */
            width: 5%;
        }
        td:nth-child(2) {
            width: 15%; /* Kolom Kode */
        }
        td:nth-child(3) {
            width: 30%; /* Kolom Nama */
        }
        td:nth-child(4) {
            width: 50%; /* Kolom Keterangan */
        }

        /* FOOTER CETAK */
        .footer { 
            font-size: 8pt; 
            text-align: right; 
            margin-top: 30px; 
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    
    {{-- HEADER DOKUMEN --}}
    <div class="header">
        <h3>DATA KLASIFIKASI NOMOR SURAT</h3>
        <h3>{{ $globalSettings->nama_sekolah ?? 'E-ARSIP SMP DEFAULT' }}</h3>
    </div>
    
    {{-- INFORMASI CETAK --}}
    <div class="info">
        <span>Dicetak Oleh: {{ Auth::user()->name ?? 'Administrator' }}</span>
        <span>Tanggal Ekspor: {{ now()->format('d F Y, H:i:s') }} WIB</span>
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>KODE KLASIFIKASI</th>
                <th>NAMA KLASIFIKASI</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode_klasifikasi }}</td>
                    <td>{{ $item->nama_klasifikasi }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dibuat otomatis oleh Sistem E-Arsip.
    </div>
</body>
</html>