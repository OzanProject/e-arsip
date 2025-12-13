<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'alamat_sekolah',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'logo_path',
        'tahun_ajaran', // Ditambahkan
        'semester',     // Ditambahkan (Ganjil/Genap)
    ];
}