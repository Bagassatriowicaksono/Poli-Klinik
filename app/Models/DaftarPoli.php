<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;

class DaftarPoli extends Model
{
    protected $table = 'daftar_poli';

    protected $fillable = [
        'id_pasien',
        'id_jadwal',
        'keluhan',
        'no_antrian',
    ];

    /**
     * Relasi ke pasien (user)
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    /**
     * Relasi ke jadwal periksa
     */
    public function jadwalPeriksa()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }

    /**
     * Relasi ke periksa
     * 1 daftar poli bisa punya 1 atau lebih periksa
     */
    public function periksas()
    {
        return $this->hasMany(Periksa::class, 'id_daftar_poli');
    }

    /**
     * Helper: cek apakah sudah pernah diperiksa
     */
    public function sudahDiperiksa(): bool
    {
        return $this->periksas()->exists();
    }
}
