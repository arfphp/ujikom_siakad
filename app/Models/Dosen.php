<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\Notifiable;

class Dosen extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'dosen';
    protected $primaryKey = 'NIP';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['NIP', 'Nama', 'Alamat', 'Nohp', 'user_id'];
    protected $hidden = [
        'remember_token',
    ];

    public function matakuliah(): HasManyThrough
    {
        return $this->hasManyThrough(
            MataKuliah::class,
            Pengampu::class,
            'NIP',
            'kode_mk',
            'NIP',
            'kode_mk'
        );
    }

    public function jadwal()
    {
        return $this->hasManyThrough(
            JadwalAkademik::class,
            Pengampu::class,
            'NIP',
            'kode_mk',
            'NIP',
            'kode_mk'
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
