<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Golongan extends Model
{
    use HasFactory;
    protected $table = 'golongan';
    protected $primaryKey = 'id_Gol';
    protected $fillable = ['id_Gol', 'nama_Gol'];
    public $timestamps = false;

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_Gol');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalAkademik::class, 'id_Gol');
    }
}
