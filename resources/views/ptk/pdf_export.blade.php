<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data PTK</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1e293b; }
        h2 { text-align: center; font-size: 13px; margin-bottom: 2px; }
        .subtitle { text-align: center; font-size: 9px; color: #64748b; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        thead tr { background-color: #4f46e5; color: white; }
        th { padding: 6px 8px; text-align: left; font-weight: bold; }
        td { padding: 5px 8px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        tr:nth-child(even) td { background-color: #f8f9fe; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 10px; font-size: 8px; font-weight: bold; }
        .badge-pns  { background: #e0e7ff; color: #4338ca; }
        .badge-pppk { background: #e0f2fe; color: #0369a1; }
        .badge-hon  { background: #fef3c7; color: #b45309; }
        .badge-gty  { background: #d1fae5; color: #065f46; }
        .badge-gtt  { background: #fee2e2; color: #b91c1c; }
        .footer { margin-top: 16px; text-align: right; font-size: 8px; color: #94a3b8; }
    </style>
</head>
<body>
    <h2>DAFTAR PENDIDIK DAN TENAGA KEPENDIDIKAN (PTK)</h2>
    <p class="subtitle">Dicetak pada: {{ now()->format('d F Y, H:i') }} &nbsp;|&nbsp; Total: {{ $data->count() }} PTK</p>

    <table>
        <thead>
            <tr>
                <th style="width:20px">#</th>
                <th>Nama Lengkap</th>
                <th>NIP / NUPTK</th>
                <th>Jabatan</th>
                <th>Bidang Studi</th>
                <th>Pendidikan</th>
                <th style="width:50px">Status</th>
                <th>No. Telepon</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $ptk)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $ptk->nama }}</strong><br><span style="color:#64748b;font-size:8px">{{ $ptk->jenis_kelamin }}</span></td>
                <td style="font-family:monospace">{{ $ptk->nip ?? ($ptk->nuptk ?? '-') }}</td>
                <td>{{ $ptk->jabatan }}</td>
                <td>{{ $ptk->bidang_studi ?? '-' }}</td>
                <td>{{ $ptk->pendidikan_terakhir }}</td>
                <td>
                    @php
                        $cls = match($ptk->status_pegawai) {
                            'PNS'    => 'badge-pns',
                            'PPPK'   => 'badge-pppk',
                            'GTY'    => 'badge-gty',
                            'GTT'    => 'badge-gtt',
                            default  => 'badge-hon',
                        };
                    @endphp
                    <span class="badge {{ $cls }}">{{ $ptk->status_pegawai }}</span>
                </td>
                <td>{{ $ptk->telepon ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:16px;color:#94a3b8">Belum ada data PTK.</td></tr>
            @endforelse
        </tbody>
    </table>
    <p class="footer">E-Arsip SMP &copy; {{ now()->year }}</p>
</body>
</html>
