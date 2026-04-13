<?php

namespace App\Imports;

use App\Models\BukuIndukArsip;
use App\Models\NomorSurat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Throwable;

class BukuIndukArsipImport implements ToCollection, WithStartRow, WithValidation, SkipsOnFailure
{
    use Importable;
    protected $failures = [];
    protected $klasifikasiMap = [];

    public function __construct()
    {
        // Memuat semua kode klasifikasi untuk mempercepat pencarian ID
        $this->klasifikasiMap = NomorSurat::pluck('id', 'kode_klasifikasi')->toArray();
    }

    public function startRow(): int { return 2; }

    public function rules(): array
    {
        return [
            // Kita lakukan validasi manual saja di collection untuk pesan error yang lebih detail per baris
        ];
    }

    public function collection(Collection $rows)
    {
        $dataToInsert = [];
        $currentRowNumber = $this->startRow() - 1; 

        foreach ($rows as $row) {
            $currentRowNumber++;
            
            // 0=No Agenda, 1=Jenis Surat, 2=Tanggal Surat, 3=Nomor Surat, 4=Asal Surat, 5=Tujuan Surat, 6=Perihal, 7=Kode Klasifikasi, 8=Keterangan

            $nomor_agenda = (string) ($row[0] ?? '');
            if (empty($nomor_agenda)) {
                continue; // Skip baris kosong
            }

            $jenis_surat = ucfirst(strtolower(trim((string) ($row[1] ?? ''))));
            if (!in_array($jenis_surat, ['Masuk', 'Keluar'])) {
                $this->failures[] = new Failure($currentRowNumber, 'jenis_surat', ['Jenis Surat harus Masuk atau Keluar.'], []);
                continue;
            }

            $raw_date = $row[2] ?? null;
            $tanggal_surat_mysql = null;

            try {
                if (is_numeric($raw_date) && $raw_date > 0) {
                    $tanggal_surat_mysql = Date::excelToDateTimeObject($raw_date)->format('Y-m-d');
                } elseif (is_string($raw_date) && !empty($raw_date)) {
                    $tanggal_surat_mysql = Carbon::parse($raw_date)->format('Y-m-d');
                } 
                
                if (!$tanggal_surat_mysql || str_starts_with($tanggal_surat_mysql, '1970') || str_starts_with($tanggal_surat_mysql, '0000')) {
                    throw new \Exception("Format tanggal tidak valid.");
                }
            } catch (Throwable $e) {
                $this->failures[] = new Failure($currentRowNumber, 'tanggal_surat', ['Tanggal Surat tidak valid.'], []);
                continue; 
            }

            $kode_klas = (string) ($row[7] ?? '');
            $klasifikasi_id = null;
            if (!empty($kode_klas)) {
                $klasifikasi_id = $this->klasifikasiMap[$kode_klas] ?? null;
            }

            $dataToInsert[] = [
                'nomor_agenda'   => $nomor_agenda,
                'jenis_surat'    => $jenis_surat,
                'tanggal_surat'  => $tanggal_surat_mysql,
                'nomor_surat'    => (string) ($row[3] ?? '-'),
                'asal_surat'     => (string) ($row[4] ?? ''),
                'tujuan_surat'   => (string) ($row[5] ?? ''),
                'perihal'        => (string) ($row[6] ?? ''),
                'klasifikasi_id' => $klasifikasi_id,
                'keterangan'     => (string) ($row[8] ?? ''),
                'uuid'           => (string) Str::uuid(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        if (!empty($dataToInsert)) {
            // Gunakan insertOrIgnore atau ubah batching untuk menghindari duplicate error jika no_agenda unik
            foreach (array_chunk($dataToInsert, 500) as $chunk) {
                DB::table('buku_induk_arsip')->insertOrIgnore($chunk);
            }
        }
    }

    public function onFailure(Failure ...$failures): void { array_push($this->failures, ...$failures); }
    public function getFailures(): array { return $this->failures; }
}
