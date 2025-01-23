<?php

namespace App\Models;

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
    ];
}
