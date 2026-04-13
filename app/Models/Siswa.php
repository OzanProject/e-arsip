<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nis',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'kelas',
        'agama',
        // Alamat terpisah
        'kampung',
        'rt',
        'rw',
        'desa',
        'kota',
        'provinsi',
        // Alamat lama (tetap ada untuk kompatibilitas data lama)
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'telepon',
    ];

    /**
     * Gabungkan kolom alamat menjadi satu string lengkap.
     */
    public function getAlamatLengkapAttribute(): string
    {
        $parts = [];
        if ($this->kampung) $parts[] = 'Kp. ' . $this->kampung;
        if ($this->rt && $this->rw) $parts[] = 'RT ' . $this->rt . '/RW ' . $this->rw;
        elseif ($this->rt) $parts[] = 'RT ' . $this->rt;
        if ($this->desa) $parts[] = 'Desa ' . $this->desa;
        if ($this->kota) $parts[] = $this->kota;
        if ($this->provinsi) $parts[] = $this->provinsi;
        
        if (!empty($parts)) return implode(', ', $parts);
        return $this->alamat ?? '-';
    }
}