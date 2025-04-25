<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang';
    protected $primaryKey = 'id_ruang';
    public $timestamps = false;
    protected $fillable = ['id_ruang', 'nama_ruang'];

    public function jadwal()
    {
        return $this->hasMany(JadwalAkademik::class, 'id_ruang');
    }
}
