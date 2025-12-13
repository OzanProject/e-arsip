<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiKelas extends Model
{
    use HasFactory;

    protected $table = 'absensi_kelas';

    protected $fillable = [
        'kelas',
        'bulan',
        'tahun',
    ];
}