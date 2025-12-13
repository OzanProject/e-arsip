<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarpras extends Model
{
    use HasFactory;

    protected $table = 'sarpras';

    protected $fillable = [
        'kode_inventaris',
        'nama_barang',
        'kategori',
        'ruangan',
        'jumlah',
        'satuan',
        'kondisi',
        'tahun_pengadaan',
        'keterangan',
    ];
}