<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $fillable =[
        'kode_pam',
        'nama',
        'alamat',
        'golongan_id',
    ];
}
