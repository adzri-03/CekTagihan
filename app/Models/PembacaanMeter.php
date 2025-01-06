<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembacaanMeter extends Model
{
    use HasFactory;

    protected $fillable =[
        'customer_id',
        'meter_awal',
        'meter_akhir',
        'pemakaian',
        'total',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
