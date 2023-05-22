<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Pegawai extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_pegawai';
    protected $keyType = 'string';
    protected $table = 'pegawais';
    protected $fillable = [
        // 'id_pegawai',
        'nama',
        'jabatan',
        'no_hp',
        'alamat',
    ];



    public function pegawai()
    {
    return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
