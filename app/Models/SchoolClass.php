<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
  use HasFactory;

  protected $table = 'school_classes';

  protected $fillable = [
    'name',
    'slug',
    'angkatan',
    'wali_kelas_id',
  ];

  public function siswa()
  {
    // Assuming we will eventually relate to this model, 
    // but currently 'kelas' in Siswa is a string.
    // For now, this relationship might need to be defined carefully 
    // if we want to get students by class string.
    // But cleaner is to verify if we change Siswa table later.
    return $this->hasMany(Siswa::class, 'kelas', 'name');
  }

  public function waliKelas()
  {
    return $this->belongsTo(Ptk::class, 'wali_kelas_id');
  }
}
