<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    public function collection()
    {
        return Siswa::orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
    }

    public function map($siswa): array
    {
        return [
            $siswa->nisn,
            $siswa->nis,
            $siswa->nama,
            $siswa->jenis_kelamin,
            $siswa->tempat_lahir,
            \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d'),
            $siswa->kelas,
            $siswa->agama,
            $siswa->alamat,
            $siswa->nama_ayah,
            $siswa->nama_ibu,
            $siswa->telepon,
        ];
    }

    public function headings(): array
    {
        return [
            'NISN', 'NIS', 'NAMA', 'JENIS_KELAMIN', 'TEMPAT_LAHIR', 'TANGGAL_LAHIR (YYYY-MM-DD)', 
            'KELAS', 'AGAMA', 'ALAMAT', 'NAMA_AYAH', 'NAMA_IBU', 'TELEPON'
        ];
    }
}