<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembacaanMeter extends Model
{
    use HasFactory;

    protected $fillable =[
        'pelanggan_id',
        'meter_awal',
        'meter_akhir',
        'pemakaian',
        'total',
    ];
}
