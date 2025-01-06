<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPetugas extends Model
{
    use HasFactory;

    protected $fillable =[
        'users_id',
        'deskripsi',
        'jenis_tindakan',
        'related_id',
    ];
}
