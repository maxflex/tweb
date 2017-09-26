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

    protected $appends = ['url'];

    public function getDateAttribute($value)
    {
        return dateFormat($value, true);
    }

    public function getUrlAttribute()
    {
        return config('app.crm-url') . 'img/gallery/' . $this->id . '.jpg';
    }
}
