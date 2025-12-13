<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrasiGuru extends Model
{
    use HasFactory;

    protected $table = 'administrasi_guru';

    protected $fillable = [
        'ptk_id',
        'judul',
        'tahun_ajaran',
        'kategori',
        'file_path',
        'deskripsi',
    ];

    /**
     * Relasi ke PTK (Pemilik administrasi).
     */
    public function ptk()
    {
        return $this->belongsTo(Ptk::class, 'ptk_id');
    }
}