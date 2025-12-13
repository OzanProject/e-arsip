<?php

namespace App\Exports;

use App\Models\Lulusan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping; // Tambahkan ini untuk formatting

class LulusanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lulusan::orderBy('tahun_lulus', 'desc')->get();
    }

    /**
     * @param Lulusan $lulusan
     */
    public function map($lulusan): array
    {
        // Mengubah format tanggal agar mudah dibaca di Excel
        return [
            $lulusan->nisn,
            $lulusan->nama,
            $lulusan->jenis_kelamin,
            $lulusan->tempat_lahir,
            \Carbon\Carbon::parse($lulusan->tanggal_lahir)->format('Y-m-d'), 
            $lulusan->tahun_lulus,
            $lulusan->nomor_ijazah,
            $lulusan->nomor_skhun,
            $lulusan->alamat,
            $lulusan->telepon,
        ];
    }

    public function headings(): array
    {
        return [
            'NISN',
            'NAMA LENGKAP',
            'JENIS KELAMIN',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR (YYYY-MM-DD)',
            'TAHUN LULUS',
            'NOMOR IJAZAH',
            'NOMOR SKHUN',
            'ALAMAT',
            'TELEPON',
        ];
    }
}