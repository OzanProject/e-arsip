<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NomorSurat; 

class BukuIndukArsip extends Model
{
    protected $table = 'buku_induk_arsip'; 
    
    // ======================================================
    // FIX KRITIS UNTUK MENGHINDARI KONFLIK ID vs UUID
    // ======================================================

    // 1. Tentukan bahwa PK adalah integer (default)
    protected $primaryKey = 'id';
    
    // 2. Tentukan bahwa PK adalah auto-incrementing (wajib jika menggunakan HasUuids di Model integer PK)
    public $incrementing = true; 
    
    // 3. Tentukan keyType adalah integer
    protected $keyType = 'int'; 

    // ======================================================
    
    protected $fillable = [
        'nomor_agenda',
        'jenis_surat',
        'tanggal_surat',
        'nomor_surat',
        'asal_surat',
        'tujuan_surat',
        'perihal',
        'klasifikasi_id', 
        'keterangan',
        'file_arsip', 
        'uuid',
        'created_by',
        'updated_by',
    ];

    public function getRouteKeyName()
    {
        return 'uuid'; // Laravel akan mencari arsip berdasarkan kolom UUID
    }

    public function klasifikasi()
    {
        return $this->belongsTo(NomorSurat::class, 'klasifikasi_id'); 
    }
}