<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KRS extends Model
{
    use HasFactory;

    protected $table = 'krs';
    // protected $primaryKey = ['NIM', 'Kode_mk'];
    // public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['NIM', 'Kode_mk'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'NIM');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'Kode_mk');
    }
}
