<?php

namespace App\Models;

use App\Models\PembacaanMeter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'pam_code',
        'name',
        'address',
        'phone',
        'golongan_id'
    ];

    public function latestPembacaanMeters()
    {
        return $this->hasOne(PembacaanMeter::class)->latest();
    }
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
