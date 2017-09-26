<?php

namespace App\Traits;

use App\Models\Photo;

trait HasPhotos
{
    public function photos()
    {
        return $this->morphMany(Photo::class, 'entity');
    }

    public function getPhotoUrlAttribute()
    {
        if (count($this->photos)) {
            return config('app.crm-url') . 'photos/cropped/' . $this->photos[0]->cropped;
        } else {
            return '/img/icons/nocropped.png';
        }
    }
}
