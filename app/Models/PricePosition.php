<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricePosition extends Model
{
    public function getUnitAttribute($value)
    {
        switch($value) {
            case 1: return 'изделие';
            case 2: return 'штука';
            case 3: return 'сантиметр';
            case 4: return 'пара';
            case 5: return 'метр';
            case 6: return 'дм²';
            case 7: return 'см²';
            case 8: return 'мм²';
            case 9: return 'элемент';
        }
    }

    public function getPriceAttribute($value)
    {
        $value = round($value / 10) * 10;
        return number_format($value, 0, ',', ' ');
    }
}
