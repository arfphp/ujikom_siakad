<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'NIM';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['NIM', 'Nama', 'Alamat', 'Nohp', 'Semester', 'id_Gol', 'user_id'];
    protected $hidden = [
        'remember_token',
    ];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'id_Gol');
    }

    public function krs()
    {
        return $this->hasMany(KRS::class, 'NIM');
    }

    public function presensi()
    {
        return $this->hasMany(PresensiAkademi::class, 'NIM');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
