<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;

class SiswaImport implements 
    ToCollection, WithStartRow, WithMapping, WithValidation, SkipsOnFailure, WithColumnFormatting, WithBatchInserts, WithChunkReading
{
    use Importable;
    protected $failures = [];

    public function startRow(): int { return 2; }

    public function map($row): array
    {
        // 0=NISN, 1=NIS, 2=Nama, 3=Jenis Kelamin, 4=Tempat Lahir, 5=Tanggal Lahir (Excel), 6=Kelas, 7=Agama, 
        // 8=Kampung, 9=RT, 10=RW, 11=Desa, 12=Kota, 13=Provinsi, 
        // 14=Nama Ayah, 15=Nama Ibu, 16=Telepon
        
        return [
            'nisn'              => (string) ($row[0] ?? ''),
            'nis'               => (string) ($row[1] ?? ''),
            'nama'              => (string) ($row[2] ?? ''),
            'jenis_kelamin'     => (string) ($row[3] ?? ''),
            'tempat_lahir'      => (string) ($row[4] ?? ''),
            'tanggal_lahir_excel' => $row[5] ?? null, 
            'kelas'             => (string) ($row[6] ?? ''),
            'agama'             => (string) ($row[7] ?? ''),
            'kampung'           => (string) ($row[8] ?? ''),
            'rt'                => (string) ($row[9] ?? ''),
            'rw'                => (string) ($row[10] ?? ''),
            'desa'              => (string) ($row[11] ?? ''),
            'kota'              => (string) ($row[12] ?? ''),
            'provinsi'          => (string) ($row[13] ?? ''),
            'nama_ayah'         => (string) ($row[14] ?? ''),
            'nama_ibu'          => (string) ($row[15] ?? ''),
            'telepon'           => (string) ($row[16] ?? ''),
        ];
    }
    
    public function rules(): array
    {
        return [
            'nisn'          => ['required', 'string', 'max:15'],
            'nis'           => ['required', 'string', 'max:10'],
            'nama'          => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'  => ['required', 'string', 'max:100'],
            'tanggal_lahir_excel' => ['required'],
            'kelas'         => ['required', 'string', 'max:10'],
            'agama'         => ['required', 'string', 'max:50'],
            // Alamat opsional di Excel tapi disarankan
            'kampung'       => ['nullable', 'string', 'max:100'],
            'rt'            => ['nullable', 'string', 'max:5'],
            'rw'            => ['nullable', 'string', 'max:5'],
            'desa'          => ['nullable', 'string', 'max:100'],
            'kota'          => ['nullable', 'string', 'max:100'],
            'provinsi'      => ['nullable', 'string', 'max:100'],
            'nama_ayah'     => ['required', 'string', 'max:255'],
            'nama_ibu'      => ['required', 'string', 'max:255'],
        ];
    }

    public function collection(Collection $rows)
    {
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
                } elseif (is_string($raw_date) && !empty($raw_date)) {
                    $tanggal_lahir_mysql = Carbon::parse($raw_date)->format('Y-m-d');
                } 
                
                if (!$tanggal_lahir_mysql || str_starts_with($tanggal_lahir_mysql, '1970') || str_starts_with($tanggal_lahir_mysql, '0000')) {
                    throw new \Exception("Format tanggal tidak valid.");
                }

            } catch (Throwable $e) {
                $this->failures[] = new Failure($currentRowNumber, 'tanggal_lahir_excel', ['Tanggal Lahir tidak valid atau format tidak dikenali.'], []);
                continue; 
            }

            // Gunakan updateOrCreate untuk menghindari duplikasi dan memungkinkan update massal
            // Logika Smart Import: Pastikan kelas ada di Manajemen Kelas
            $className = trim($row['kelas']);
            $class = \App\Models\SchoolClass::firstOrCreate(
                ['name' => $className],
                ['slug' => \Illuminate\Support\Str::slug($className), 'angkatan' => date('Y') . '/' . (date('Y') + 1)]
            );

            \App\Models\Siswa::updateOrCreate(
                ['nisn' => $row['nisn']],
                [
                    'nis'           => $row['nis'] ?? null,
                    'nama'          => $row['nama'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'tempat_lahir'  => $row['tempat_lahir'],
                    'tanggal_lahir' => $tanggal_lahir_mysql,
                    'kelas'         => $class->name, // Menggunakan name dari model class yang sudah dipastikan ada
                    'agama'         => $row['agama'],
                    'nama_ayah'     => $row['nama_ayah'] ?? null,
                    'nama_ibu'      => $row['nama_ibu'] ?? null,
                    'telepon'       => $row['telepon'] ?? null,
                    'kampung'       => $row['kampung'] ?? null,
                    'rt'            => $row['rt'] ?? null,
                    'rw'            => $row['rw'] ?? null,
                    'desa'          => $row['desa'] ?? null,
                    'kota'          => $row['kota'] ?? null,
                    'provinsi'      => $row['provinsi'] ?? null,
                ]
            );
        }
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // NISN
            'B' => NumberFormat::FORMAT_TEXT, // NIS
        ];
    }
    
    // ... (metode batchSize, chunkSize, onFailure, getFailures, customValidationAttributes/Messages lainnya)
    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
    public function onFailure(Failure ...$failures): void { $this->failures = array_merge($this->failures, $failures); }
    public function getFailures(): array { return $this->failures; }
    public function customValidationAttributes()
    {
        return [
            'nisn'          => 'NISN',
            'nis'           => 'NIS',
            'nama'          => 'Nama',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tempat_lahir'  => 'Tempat Lahir',
            'tanggal_lahir_excel' => 'Tanggal Lahir',
            'kelas'         => 'Kelas',
            'agama'         => 'Agama',
            'nama_ayah'     => 'Nama Ayah',
            'nama_ibu'      => 'Nama Ibu',
            'telepon'       => 'Telepon',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'required'      => 'Kolom :attribute wajib diisi.',
            'unique'        => ':attribute sudah terdaftar di sistem.',
            'in'            => 'Isian :attribute tidak valid.',
            'max'           => 'Isian :attribute terlalu panjang (maksimal :max karakter).',
            'string'        => 'Isian :attribute harus berupa teks.',
        ];
    }

}