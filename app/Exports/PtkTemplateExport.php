<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PtkTemplateExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return new Collection([
            [
                '196501011990031005', '1234567890123456', 'Budi Santoso, S.Pd.',
                'Laki-laki', 'Bandung', '01/01/1965', 'Guru Kelas', 'PNS',
                'S1', 'Matematika', '01/03/1990', 'Wali Kelas 7A',
                'Jl. Merdeka No. 1, Bandung', '081234567890',
            ],
            [
                '', '9876543210987654', 'Siti Aminah, S.Pd.I.',
                'Perempuan', 'Surabaya', '15/07/1985', 'Guru PAI', 'Honorer',
                'S1', 'Pendidikan Agama Islam', '01/07/2010', '-',
                'Jl. Sudirman No. 5, Surabaya', '082233445566',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'NIP', 'NUPTK', 'Nama Lengkap', 'Jenis Kelamin (Laki-laki/Perempuan)',
            'Tempat Lahir', 'Tanggal Lahir (dd/mm/yyyy)', 'Jabatan',
            'Status Pegawai (PNS/PPPK/Honorer/GTY/GTT)', 'Pendidikan Terakhir',
            'Bidang Studi', 'TMT Kerja (dd/mm/yyyy)', 'Tugas Tambahan',
            'Alamat', 'No. Telepon',
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
