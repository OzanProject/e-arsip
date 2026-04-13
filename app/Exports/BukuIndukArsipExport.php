<?php

namespace App\Exports;

use App\Models\BukuIndukArsip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BukuIndukArsipExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return BukuIndukArsip::with('klasifikasi')->orderBy('created_at', 'desc')->get();
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

    public function map($arsip): array
    {
        return [
            $arsip->nomor_agenda,
            $arsip->jenis_surat,
            $arsip->tanggal_surat,
            $arsip->nomor_surat,
            $arsip->asal_surat,
            $arsip->tujuan_surat,
            $arsip->perihal,
            $arsip->klasifikasi ? $arsip->klasifikasi->kode_klasifikasi : '',
            $arsip->keterangan,
        ];
    }
}
