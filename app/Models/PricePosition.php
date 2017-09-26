<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricePosition extends Model
{
    protected $fillable = [
        'name',
        'price',
        'unit',
        'price_section_id',
        'position'
    ];
}
