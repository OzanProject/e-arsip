<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku Induk Arsip</title>
    <style>
        body { font-family: sans-serif; font-size: 8pt; margin: 1cm; }
        h3 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; font-size: 7pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h3>BUKU INDUK ARSIP {{ strtoupper($globalSettings->nama_sekolah ?? 'E-ARSIP SMP') }}</h3>
    <p>Tanggal Ekspor: {{ now()->format('d F Y H:i') }} | Total Data: {{ count($data) }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No.</th>
                <th>Tgl Surat</th>
                <th>Jenis</th>
                <th>No. Agenda / No. Surat</th>
                <th>Asal / Tujuan</th>
                <th>Perihal</th>
                <th>Kode Klasifikasi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}</td>
                    <td>{{ $item->jenis_surat }}</td>
                    <td>
                        <strong>Agenda:</strong> {{ $item->nomor_agenda }}<br>
                        <strong>Surat:</strong> {{ $item->nomor_surat ?? '-' }}
                    </td>
                    <td>
                        @if($item->jenis_surat == 'Masuk')
                            <strong>Asal:</strong> {{ $item->asal_surat ?? '-' }}
                        @else
                            <strong>Tujuan:</strong> {{ $item->tujuan_surat ?? '-' }}
                        @endif
                    </td>
                    <td>{{ $item->perihal }}</td>
                    <td>{{ $item->klasifikasi ? $item->klasifikasi->kode_klasifikasi : '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
