<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Pastikan tidak ada use Spatie... di sini

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ptk extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ptk';

    protected $fillable = [
        'nip',
        'nuptk',
        'nama',
        // Hapus 'slug'
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'jabatan',
        'status_pegawai',
        'pendidikan_terakhir',
        'alamat',
        'telepon',
        // Tambahkan semua kolom lain yang Anda butuhkan (tmt_kerja, foto_path, dll)
        'tmt_kerja',
        'tugas_tambahan',
        'bidang_studi',
        'status_aktif',
        'foto_path',
        
    ];
    
    /**
     * Tentukan kolom mana yang harus digunakan untuk route model binding (URL).
     */
    public function getRouteKeyName()
    {
        return 'uuid'; // Menggunakan UUID untuk URL yang lebih aman
    }

    /**
     * Tentukan kolom yang harus di-generate UUID-nya.
     */
    public function uniqueIds()
    {
        return ['uuid'];
    }
}