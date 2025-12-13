<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrasiSiswa extends Model
{
    use HasFactory;

    protected $table = 'administrasi_siswa';

    protected $fillable = [
        'siswa_id',
        'judul',
        'tahun_ajaran',
        'semester',
        'kategori',
        'file_path',
        'deskripsi',
    ];

    /**
     * Relasi ke Siswa (Pemilik administrasi).
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}