<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama',
        'no_hp',
        'alamat',
    ];

    public function instruktur()
    {
    return $this->belongsTo(Instruktur::class, 'id_instruktur');
    }
}
