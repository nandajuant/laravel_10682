<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositPaket extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_deposit_pkt',
        'id_promo',
        'id_member',
        'nama',
        'tanggal',
        'waktu',
        'deposit',
        'biaya',
        'bonus',
        'jenis_kelas',
        'total_deposit',
        'masa_berlaku',
        'id_pegawai',
        'nama_pegawai'
    ];

    public function DepositPaket()
    {
    return $this->belongsTo(DepositPaket::class, 'id_deposit_pkt');
    }
}
