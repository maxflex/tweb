<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;
use App\Traits\HasPhotos;

class Gallery extends Model
{
    use HasTags, HasPhotos;

    protected $casts = [
        'watermark' => 'boolean',
        'before_and_after' => 'boolean',
    ];

    protected $appends = ['url', 'total_price'];

    public function getDateAttribute($value)
    {
        return dateFormat($value, true);
    }

    public function getTotalPriceAttribute()
    {
        $sum = 0;
        foreach(range(1, 6) as $i) {
            $sum += intval($this->attributes['price_' . $i]);
        }
        return $sum;
    }

    public function getUrlAttribute()
    {
        return config('app.crm-url') . 'img/gallery/' . $this->id . '.jpg';
    }
}
