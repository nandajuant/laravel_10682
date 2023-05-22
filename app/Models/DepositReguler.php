<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositReguler extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_deposit_reg',
        'id_promo',
        'id_member',
        'nama',
        'tanggal',
        'waktu',
        'deposit',
        'bonus',
        'sisa',
        'total',
        'id_pegawai',
        'nama_pegawai'
    ];

    public function DepositReguler()
    {
    return $this->belongsTo(DepositReguler::class, 'id_deposit_reg');
    }
}
