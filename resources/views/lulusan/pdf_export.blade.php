<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Lulusan</title>
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
    <h3>DATA LULUSAN {{ strtoupper($globalSettings->nama_sekolah ?? 'E-ARSIP SMP') }}</h3>
    <p>Tanggal Ekspor: {{ now()->format('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No.</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Tgl Lahir</th>
                <th>Tahun Lulus</th>
                <th>No. Ijazah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td>{{ $item->tahun_lulus }}</td>
                    <td>{{ $item->nomor_ijazah ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>