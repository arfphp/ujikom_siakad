<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresensiAkademi extends Model
{
    use HasFactory;
    protected $table = 'presensi_akademi';
    public $timestamps = false;
    protected $fillable = ['hari', 'tanggal', 'status_kehadiran', 'NIM', 'Kode_mk'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'Kode_mk');
    }
}
