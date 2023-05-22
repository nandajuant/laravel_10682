<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_aktivasi',
        'id_member',
        'nama',
        'tanggal',
        'waktu',
        'masa_aktif',
        'id_pegawai',
        'nama_pegawai',
    ];

    public function Aktivasi()
    {
    return $this->belongsTo(Aktivasi::class, 'id_aktivasi');
    }
}
