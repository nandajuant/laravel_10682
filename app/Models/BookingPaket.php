<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPaket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_booking_pkt';
    protected $keyType = 'string';
    protected $table = 'booking_pakets';
    protected $fillable = [
        'id_booking_pkt',
        'id_member',
        'nama',
        'id_instruktur',
        'id_jadwal_harian',
        'nama_instruktur',
        'nama_kelas',
        'tanggal',
        'waktu',
        'tarif',
        'sisa_paket',
        'masa_berlaku',
        'status',
    ];

    public function BookingPaket()
    {
    return $this->belongsTo(BookingPaket::class, 'id_booking_pkt');
    }
}
