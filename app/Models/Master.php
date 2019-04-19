<?php

namespace App\Models;

class Master extends Service\Model
{
    use \App\Traits\HasPhotos;

    const URL = 'masters';

    protected $appends = ['photo_url'];

    public function reviews()
    {
        return $this->hasMany(Review::class)->orderBy('date', 'desc');
    }

    public function getDescriptionShortAttribute()
    {
        $description = $this->attributes['description'];
        if (strlen($description) > 150) {
            return mb_strimwidth($description, 0, 150) . '...';
        }
        return $description;
    }
}
