<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingGym extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_gym';
    protected $keyType = 'string';
    protected $table = 'booking_gyms';
    protected $fillable = [
        'id_gym',
        'bulan',
        'tanggal',
        'waktu',
        'slot_waktu',
        'sisa_kuota',
        'id_member',
        'nama',
        'status',
    ];

    public function BookingGym()
    {
    return $this->belongsTo(BookingGym::class, 'id_gym');
    }
}
