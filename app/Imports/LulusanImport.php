<?php

namespace App\Imports;

use App\Models\Lulusan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;

class LulusanImport implements 
    ToCollection,     
    WithStartRow,     
    WithMapping,      
    WithValidation,   
    SkipsOnFailure,
    WithColumnFormatting,
    WithBatchInserts,
    WithChunkReading
{
    use Importable;

    /**
     * @var Failure[]
     */
    protected $failures = [];

    public function startRow(): int
    {
        return 2;
    }

    public function map($row): array
    {
        // Lakukan casting yang lebih kuat untuk mencegah tipe data ambigu
        return [
            'nisn'                  => (string) ($row[0] ?? ''),
            'nama'                  => (string) ($row[1] ?? ''),
            'jenis_kelamin'         => (string) ($row[2] ?? ''),
            'tempat_lahir'          => (string) ($row[3] ?? ''),
            'tanggal_lahir_excel'   => $row[4] ?? null, 
            'tahun_lulus'           => (string) ($row[5] ?? ''),
            'nomor_ijazah'          => (string) ($row[6] ?? ''),
            'nomor_skhun'           => (string) ($row[7] ?? ''),
            'alamat'                => (string) ($row[8] ?? ''),
            'telepon'               => (string) ($row[9] ?? ''),
        ];
    }
    
    public function rules(): array
    {
        return [
            'nisn'                  => ['required', 'string', 'max:15', 'unique:lulusan,nisn'],
            'nama'                  => ['required', 'string', 'max:255'],
            'jenis_kelamin'         => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'          => ['required', 'string', 'max:100'],
            'tanggal_lahir_excel'   => ['required'], 
            'tahun_lulus'           => ['required', 'string', 'max:4'],
            
            'nomor_ijazah'          => ['nullable', 'string', 'max:50', Rule::unique('lulusan', 'nomor_ijazah')], 
            'nomor_skhun'           => ['nullable', 'string', 'max:50', Rule::unique('lulusan', 'nomor_skhun')], 
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'tanggal_lahir_excel' => 'Tanggal Lahir',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nisn.unique'           => 'NISN sudah ada di sistem.',
            'required'              => 'Kolom :attribute wajib diisi.',
            'jenis_kelamin.in'      => 'Jenis kelamin harus Laki-laki atau Perempuan.',
        ];
    }

    public function collection(Collection $rows)
    {
        $dataToInsert = [];
        $currentRowNumber = $this->startRow() - 1; 

        foreach ($rows as $row) {
            $currentRowNumber++;

            if (empty($row['nisn']) || empty($row['nama'])) {
                continue; 
            }

            $raw_date = $row['tanggal_lahir_excel'];
            $tanggal_lahir_mysql = null;

            try {
                if (is_numeric($raw_date) && $raw_date > 0) {
                    $tanggal_lahir_mysql = Date::excelToDateTimeObject($raw_date)->format('Y-m-d');
                } elseif (is_string($raw_date)) {
                    $tanggal_lahir_mysql = Carbon::parse($raw_date)->format('Y-m-d');
                } 
                
                if (!$tanggal_lahir_mysql || str_starts_with($tanggal_lahir_mysql, '1970') || str_starts_with($tanggal_lahir_mysql, '0000')) {
                    throw new \Exception("Format tidak dikenali.");
                }

            } catch (Throwable $e) {
                $this->failures[] = new Failure(
                    $currentRowNumber,
                    'tanggal_lahir_excel', 
                    ['Tanggal Lahir tidak valid atau format tidak dikenali.'], 
                    []
                );
                continue; 
            }

            $dataToInsert[] = [
                'nisn'              => $row['nisn'],
                'nama'              => $row['nama'],
                'jenis_kelamin'     => $row['jenis_kelamin'],
                'tempat_lahir'      => $row['tempat_lahir'],
                'tanggal_lahir'     => $tanggal_lahir_mysql, 
                'tahun_lulus'       => $row['tahun_lulus'],
                'nomor_ijazah'      => $row['nomor_ijazah'] ?: null,
                'nomor_skhun'       => $row['nomor_skhun'] ?: null,
                'alamat'            => $row['alamat'] ?? null,
                'telepon'           => $row['telepon'] ?? null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }

        if (!empty($dataToInsert)) {
            DB::table('lulusan')->insert($dataToInsert);
        }
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, 
            'F' => NumberFormat::FORMAT_TEXT, 
        ];
    }
    
    public function batchSize(): int 
    { 
        return 1000; 
    }

    public function chunkSize(): int 
    { 
        return 1000; 
    }

    // =========================================================
    // PERBAIKAN TYPE HINTING (Sesuai Laporan Intelephense)
    // =========================================================
    
    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures): void // <-- Perbaikan Baris 147
    {
        $this->failures = array_merge($this->failures, $failures);
    }
    
    /**
     * @return Failure[]
     */
    public function getFailures(): array // <-- Perbaikan Baris 149
    {
        return $this->failures;
    }
}