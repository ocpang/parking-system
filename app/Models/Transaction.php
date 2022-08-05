<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'id', 'code', 'vehicle_no', 'check_in', 'check_out', 'hours', 'price', 'total',
        'user_created', 'user_updated', 'created_at', 'updated_at',
    ];
}
