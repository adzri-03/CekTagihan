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

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {

        $model->meter_awal = $model->meter_awal ?? 0;
        $model->pemakaian = $model->pemakaian ?? ($model->meter_akhir - $model->meter_awal);

        $tarifPerUnit = 1000; 
        $model->total = $model->total ?? ($model->pemakaian * $tarifPerUnit);
        if (is_null($model->pemakaian)) {
            $model->pemakaian = $model->meter_akhir - ($model->meter_awal ?? 0);
        }

        if (is_null($model->total)) {
            $tarifPerUnit = 1000;
            $model->total = $model->pemakaian * $tarifPerUnit;
        }
    });
}
}
