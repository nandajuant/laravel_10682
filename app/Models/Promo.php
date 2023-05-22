<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_promo',
        'nama',
        'jenis',
        'detail'
    ];

    public function Promo()
    {
    return $this->belongsTo(Promo::class, 'id_promo');
    }
}
