<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuIndukArsipTemplateExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return new Collection([
            [
                'AG-0001/24',
                'Masuk',
                '2024-10-12',
                '112/SMP/X/2024',
                'Dinas Pendidikan Wilayah II',
                '',
                'Undangan Rapat Koordinasi Kurikulum',
                '005',
                'Segera ditindaklanjuti',
            ],
            [
                'AG-0002/24',
                'Keluar',
                '2024-10-15',
                '090/SMP4/X/2024',
                '',
                'Orang Tua Siswa Kelas IX',
                'Surat Pemberitahuan Ujian Akhir',
                '421',
                '-',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Nomor Agenda',
            'Jenis Surat',
            'Tanggal Surat (YYYY-MM-DD)',
            'Nomor Surat',
            'Asal Surat',
            'Tujuan Surat',
            'Perihal',
            'Kode Klasifikasi',
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
