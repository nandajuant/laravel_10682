<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinInstruktur extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_izin';
    protected $keyType = 'string';
    protected $table = 'izin_instrukturs';
    protected $fillable = [
        
        'id_instruktur',
        'id_jadwal_harian',
        'nama',
        'tanggal',
        'status',
        'keterangan',
        'id_pegawai'
    ];

    public function izinInstruktur()
    {
    return $this->belongsTo(IzinInstruktur::class, 'id_izin');
    }
}
