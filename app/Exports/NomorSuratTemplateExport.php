<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NomorSuratTemplateExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return new Collection([
            [
                '005',
                'Undangan',
                'Digunakan untuk klasifikasi surat undangan resmi.',
            ],
            [
                '421',
                'Sekolah',
                'Digunakan untuk klasifikasi administrasi dan kegiatan sekolah.',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Kode Klasifikasi',
            'Nama Klasifikasi',
            'Keterangan',
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4F46E5']]
            ],
        ];
    }
}
