<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPetugas extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'deskripsi',
        'jenis_tindakan',
        'related_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembacaanMeter()
    {
        return $this->belongsTo(PembacaanMeter::class, 'related_id');
    }
}
