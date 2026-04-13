<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Siswa Aktif</title>
    <style>
        body { font-family: sans-serif; font-size: 8pt; margin: 1cm; }
        h3 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; font-size: 7pt; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; padding: 6px; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; color: #1e293b; }
        tr:nth-child(even) { background-color: #f8fafc; }
    </style>
</head>
<body>
    <h3>DATA SISWA AKTIF {{ strtoupper($globalSettings->nama_sekolah ?? 'E-ARSIP SMP') }}</h3>
    <p>Tahun Ajaran: {{ date('Y') }}/{{ date('Y') + 1 }} | Tanggal Ekspor: {{ now()->format('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 30px">No.</th>
                <th>NISN / NIS</th>
                <th>Nama Siswa</th>
                <th style="width: 50px">Kelas</th>
                <th>Tgl Lahir</th>
                <th style="width: 150px">Alamat</th>
                <th>Nama Orang Tua</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nisn }}<br><span style="color:#64748b; font-size:7pt">{{ $item->nis }}</span></td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td style="text-align:center">{{ $item->kelas }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td style="font-size: 7pt">{{ $item->alamat_lengkap }}</td>
                    <td>Ayah: {{ $item->nama_ayah }}<br>Ibu: {{ $item->nama_ibu }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>