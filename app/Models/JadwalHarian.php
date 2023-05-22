<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalHarian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_jadwal_harian',
        'id_pegawai',
        'hari',
        'waktu',
        'keterangan',
        'tanggal',
        'jenis_kelas'
    ];

    public function jadwalHarian()
    {
    return $this->belongsTo(JadwalHarian::class, 'id_jadwal_harian');
    }
}
