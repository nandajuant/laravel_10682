<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalUmum extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_pegawai',
        'id_kelas',
        'hari',
        'waktu',
        'jenis_kelas'
    ];

    public function jadwalUmum()
    {
    return $this->belongsTo(JadwalUmum::class, 'id_jadwal_umum');
    }
}
