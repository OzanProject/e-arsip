<?php

namespace App\Imports;

use App\Models\Ptk;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;

class PtkImport implements ToCollection, WithStartRow, SkipsOnFailure
{
    use Importable;

    protected $failures = [];

    public function startRow(): int { return 2; }

    public function collection(Collection $rows)
    {
        $existingNips   = Ptk::whereNotNull('nip')->pluck('nip')->toArray();
        $existingNuptks = Ptk::whereNotNull('nuptk')->pluck('nuptk')->toArray();
        $rowNumber = $this->startRow() - 1;

        foreach ($rows as $row) {
            $rowNumber++;

            // Kolom: 0=NIP, 1=NUPTK, 2=Nama, 3=JK, 4=TempatLahir, 5=TglLahir,
            //         6=Jabatan, 7=StatusPegawai, 8=Pendidikan, 9=BidangStudi,
            //         10=TMTKerja, 11=TugasTambahan, 12=Alamat, 13=Telepon

            $nama = trim((string)($row[2] ?? ''));
            if (empty($nama)) continue; // skip baris kosong

            $nip   = trim((string)($row[0] ?? '')) ?: null;
            $nuptk = trim((string)($row[1] ?? '')) ?: null;

            // Skip duplikat NIP
            if ($nip && in_array($nip, $existingNips)) {
                $this->failures[] = new Failure($rowNumber, 'nip', ["NIP '{$nip}' sudah terdaftar."], []);
                continue;
            }
            // Skip duplikat NUPTK
            if ($nuptk && in_array($nuptk, $existingNuptks)) {
                $this->failures[] = new Failure($rowNumber, 'nuptk', ["NUPTK '{$nuptk}' sudah terdaftar."], []);
                continue;
            }

            $jk = trim((string)($row[3] ?? ''));
            if (!in_array($jk, ['Laki-laki', 'Perempuan'])) {
                $this->failures[] = new Failure($rowNumber, 'jenis_kelamin', ['Jenis Kelamin harus Laki-laki atau Perempuan.'], []);
                continue;
            }

            // Parse tanggal dari format dd/mm/yyyy
            $tglLahir = null;
            if (!empty($row[5])) {
                try {
                    $tglLahir = \Carbon\Carbon::createFromFormat('d/m/Y', trim($row[5]))->format('Y-m-d');
                } catch (\Exception $e) {
                    $this->failures[] = new Failure($rowNumber, 'tanggal_lahir', ['Format tanggal lahir tidak valid (gunakan dd/mm/yyyy).'], []);
                    continue;
                }
            }

            $tmtKerja = null;
            if (!empty($row[10])) {
                try {
                    $tmtKerja = \Carbon\Carbon::createFromFormat('d/m/Y', trim($row[10]))->format('Y-m-d');
                } catch (\Exception $e) {
                    $tmtKerja = null;
                }
            }

            if ($nip) $existingNips[] = $nip;
            if ($nuptk) $existingNuptks[] = $nuptk;

            Ptk::create([
                'uuid'                => (string) Str::uuid(),
                'nip'                 => $nip,
                'nuptk'               => $nuptk,
                'nama'                => $nama,
                'jenis_kelamin'       => $jk,
                'tempat_lahir'        => trim((string)($row[4] ?? '')),
                'tanggal_lahir'       => $tglLahir,
                'jabatan'             => trim((string)($row[6] ?? '')),
                'status_pegawai'      => trim((string)($row[7] ?? 'Honorer')),
                'pendidikan_terakhir' => trim((string)($row[8] ?? '')),
                'bidang_studi'        => trim((string)($row[9] ?? '')) ?: null,
                'tmt_kerja'           => $tmtKerja,
                'tugas_tambahan'      => trim((string)($row[11] ?? '')) ?: null,
                'alamat'              => trim((string)($row[12] ?? '')),
                'telepon'             => trim((string)($row[13] ?? '')) ?: null,
            ]);
        }
    }

    public function onFailure(Failure ...$failures): void { array_push($this->failures, ...$failures); }
    public function getFailures(): array { return $this->failures; }
}
