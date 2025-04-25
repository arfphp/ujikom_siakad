<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengampu extends Model
{
    use HasFactory;

    protected $table = 'pengampu';
    public $timestamps = false;

    // protected $primaryKey = ['Kode_mk', 'NIP'];
    // public $incrementing = false;

    protected $fillable = ['Kode_mk', 'NIP'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'NIP');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'Kode_mk');
    }
}
