<?php

namespace App\Exports;

use App\Models\Ptk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PtkExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Ptk::orderBy('nama', 'asc')->get()->map(function ($ptk) {
            return [
                $ptk->nip ?? '-',
                $ptk->nuptk ?? '-',
                $ptk->nama,
                $ptk->jenis_kelamin,
                $ptk->tempat_lahir,
                $ptk->tanggal_lahir ? \Carbon\Carbon::parse($ptk->tanggal_lahir)->format('d/m/Y') : '-',
                $ptk->jabatan,
                $ptk->status_pegawai,
                $ptk->pendidikan_terakhir,
                $ptk->bidang_studi ?? '-',
                $ptk->tmt_kerja ?? '-',
                $ptk->tugas_tambahan ?? '-',
                $ptk->alamat ?? '-',
                $ptk->telepon ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIP', 'NUPTK', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir',
            'Tanggal Lahir', 'Jabatan', 'Status Pegawai', 'Pendidikan Terakhir',
            'Bidang Studi', 'TMT Kerja', 'Tugas Tambahan', 'Alamat', 'No. Telepon',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4F46E5']],
            ],
        ];
    }
}
