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
            return config('app.crm-url') . 'photos/small/' . $this->photos[0]->id . '.jpg';
        } else {
            return '/img/icons/nocropped.png';
        }
    }
}
