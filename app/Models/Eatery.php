<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eatery extends Model
{
    protected $fillable = [
        'district_id',
        'name',
        'slug',
        'address',
        'price_range',
        'specialty',
        'is_open',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];
}
