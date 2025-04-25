<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalAkademik extends Model
{
    use HasFactory;

    protected $table = 'jadwal_akademik';
    // protected $primaryKey = 'id';
    // protected $keyType = 'integer';
    public $timestamps = false;

    protected $fillable = ['hari', 'Kode_mk', 'id_ruang', 'id_Gol'];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'Kode_mk');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang');
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'id_Gol');
    }
}
