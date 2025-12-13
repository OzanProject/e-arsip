<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lulusan extends Model
{
    use HasFactory;

    protected $table = 'lulusan';

    protected $fillable = [
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'tahun_lulus',
        'nomor_ijazah',
        'nomor_skhun',
        'alamat',
        'telepon',
    ];

    /**
     * Casting field tanggal ke tipe Carbon agar konsisten.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}