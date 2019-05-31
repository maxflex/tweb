<?php

namespace App\Traits;

use App\Models\Photo;
use App\Models\Master;

trait HasPhotos
{
    public function photos()
    {
        return $this->morphMany(Photo::class, 'entity');
    }

    public function getPhotoUrlAttribute()
    {
        if (count($this->photos)) {
            if (static::class === Master::class) {
                return config('app.crm-url') . 'photos/small/' . $this->photos[0]->id . '.jpg';
            } else {
                return config('app.crm-url') . 'photos/cropped/' . $this->photos[0]->cropped;
            }
        } else {
            return '/img/icons/nocropped.png';
        }
    }
}
