<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingReguler extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_booking_reg';
    protected $keyType = 'string';
    protected $table = 'booking_regulers';
    protected $fillable = [
        'id_booking_reg',
        'id_member',
        'nama',
        'id_instruktur',
        'id_jadwal_harian',
        'nama_instruktur',
        'nama_kelas',
        'tanggal',
        'waktu',
        'tarif',
        'sisa_deposit',
        'status',
    ];

    public function BookingReguler()
    {
    return $this->belongsTo(BookingReguler::class, 'id_booking_reg');
    }
}
