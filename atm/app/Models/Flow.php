<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    const UPDATED_AT = null;
    
    protected $fillable = [
        'amount',
        'type',
        'user_id',
    ];
}
