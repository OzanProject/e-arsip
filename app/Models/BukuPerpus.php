<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuPerpus extends Model
{
    use HasFactory;

    protected $table = 'buku_perpus';

    protected $fillable = [
        'kode_eksemplar',
        'judul',
        'penulis',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'kategori',
        'jumlah_eksemplar',
        'eksemplar_tersedia',
        'kondisi',
        'deskripsi',
    ];
}