<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;

class PembacaanMeter extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'meter_awal',
        'meter_akhir',
        'pemakaian',
        'total',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
