<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kelas';
    protected $keyType = 'string';
    protected $table = 'kelas';
    protected $fillable = [
        'id_kelas',
        'id_instruktur',
        'nama_instruktur',
        'nama_kelas',
        'tarif',
        'deskripsi'
    ];

    public function Kelas()
    {
    return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
