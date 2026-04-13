<?php

namespace App\Imports;

use App\Models\NomorSurat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\DB;
use Throwable;

class NomorSuratImport implements ToCollection, WithStartRow, WithValidation, SkipsOnFailure
{
    use Importable;
    protected $failures = [];

    public function startRow(): int { return 2; }

    public function rules(): array
    {
        return [];
    }

    public function collection(Collection $rows)
    {
        $dataToInsert = [];
        $currentRowNumber = $this->startRow() - 1; 

        // Untuk mengecek duplikat di DB agar tidak terbentur constraint
        $existingKodes = NomorSurat::pluck('kode_klasifikasi')->toArray();

        foreach ($rows as $row) {
            $currentRowNumber++;
            
            // 0=Kode Klasifikasi, 1=Nama Klasifikasi, 2=Keterangan
            $kode_klasifikasi = (string) ($row[0] ?? '');
            if (empty($kode_klasifikasi)) {
                continue; // Skip baris kosong
            }
            
            $nama_klasifikasi = (string) ($row[1] ?? '');
            if (empty($nama_klasifikasi)) {
                $this->failures[] = new Failure($currentRowNumber, 'nama_klasifikasi', ['Nama Klasifikasi tidak boleh kosong.'], []);
                continue;
            }

            // Hindari duplikasi langsung di script karena constraint unique
            if (in_array($kode_klasifikasi, $existingKodes)) {
                // Bisa di skip atau dilewati saja daripada return error 
                // $this->failures[] = new Failure($currentRowNumber, 'kode_klasifikasi', ["Kode Klasifikasi '{$kode_klasifikasi}' sudah ada di sistem."], []);
                continue;
            }

            // Tandai sudah diinsert di batch ini
            $existingKodes[] = $kode_klasifikasi;

            $dataToInsert[] = [
                'kode_klasifikasi' => $kode_klasifikasi,
                'nama_klasifikasi' => $nama_klasifikasi,
                'keterangan'       => (string) ($row[2] ?? ''),
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        if (!empty($dataToInsert)) {
            foreach (array_chunk($dataToInsert, 500) as $chunk) {
                DB::table('nomor_surat')->insertOrIgnore($chunk);
            }
        }
    }

    public function onFailure(Failure ...$failures): void { array_push($this->failures, ...$failures); }
    public function getFailures(): array { return $this->failures; }
}
