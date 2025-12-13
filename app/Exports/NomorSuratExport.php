<?php

namespace App\Exports;

use App\Models\NomorSurat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Untuk ukuran kolom otomatis

class NomorSuratExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil data yang dibutuhkan, dan pastikan kolom sesuai urutan header
        return NomorSurat::select('kode_klasifikasi', 'nama_klasifikasi', 'keterangan')
                        ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'KODE KLASIFIKASI',
            'NAMA KLASIFIKASI',
            'KETERANGAN',
        ];
    }
}