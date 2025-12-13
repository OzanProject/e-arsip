<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Siswa Aktif</title>
    <style>
        body { font-family: sans-serif; font-size: 8pt; margin: 1cm; }
        h3 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; font-size: 7pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h3>DATA SISWA AKTIF {{ strtoupper($globalSettings->nama_sekolah ?? 'E-ARSIP SMP') }}</h3>
    <p>Tahun Ajaran: {{ date('Y') }}/{{ date('Y') + 1 }} | Tanggal Ekspor: {{ now()->format('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No.</th>
                <th>NISN</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Tgl Lahir</th>
                <th>Nama Orang Tua</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nis }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kelas }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td>Ayah: {{ $item->nama_ayah }} / Ibu: {{ $item->nama_ibu }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>