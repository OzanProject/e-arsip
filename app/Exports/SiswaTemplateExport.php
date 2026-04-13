<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaTemplateExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return new Collection([
            [
                '0012345678', '2425001', 'Aditiya Pratama', 'Laki-laki', 'Bandung', '01/01/2012', 
                '7A', 'Islam', 'Kp. Durian Runtuh', '001', '002', 'Sukajadi', 'Bandung', 'Jawa Barat',
                'Budi Santoso', 'Siti Aminah', '081234567890'
            ],
            [
                '0023456789', '2425002', 'Siti Rahmawati', 'Perempuan', 'Jakarta', '15/05/2012', 
                '7B', 'Islam', 'Jl. Melati No. 5', '005', '001', 'Menteng', 'Jakarta Pusat', 'DKI Jakarta',
                'Hasan Basri', 'Ani Wijaya', '082233445566'
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'NISN', 'NIS', 'NAMA', 'JENIS_KELAMIN (Laki-laki/Perempuan)', 'TEMPAT_LAHIR', 
            'TANGGAL_LAHIR (DD/MM/YYYY)', 'KELAS', 'AGAMA', 'KAMPUNG/GANG', 'RT', 'RW', 
            'DESA/KELURAHAN', 'KOTA/KABUPATEN', 'PROVINSI', 'NAMA_AYAH', 'NAMA_IBU', 'TELEPON'
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
