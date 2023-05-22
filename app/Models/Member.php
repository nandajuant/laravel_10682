<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_member';
    protected $keyType = 'string';
    protected $table = 'members';
    protected $fillable = [
        // 'id',
        // 'id_member',
        'nama',
        'no_hp',
        'alamat',
        'jml_dep_kelas',
        'jml_dep_uang',
        'kadaluarsa_member',
        'kadaluarsa_deposit',
        'status'
    ];

    public function member()
    {
    return $this->belongsTo(Member::class, 'id_member');
    }
}
