<?php

namespace App\Models;

class Master extends Service\Model
{
    use \App\Traits\HasPhotos;

    const URL = 'masters';

    protected $appends = ['photo_url', 'reviews_count'];


    public function getReviewsCountAttribute()
    {
        return Review::where('master_id', $this->id)->count();
    }
}
