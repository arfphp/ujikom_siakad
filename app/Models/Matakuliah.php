<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';
    protected $primaryKey = 'Kode_mk';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['Kode_mk', 'Nama_mk', 'sks', 'semester'];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'pengampu', 'Kode_mk', 'NIP');
    }

    public function presensi()
    {
        return $this->hasMany(PresensiAkademi::class, 'Kode_mk');
    }
    public function pengampu()
    {
        return $this->hasMany(Pengampu::class, 'Kode_mk');
    }
    public function jadwal()
    {
        return $this->hasMany(JadwalAkademik::class, 'kode_mk');
    }
}
