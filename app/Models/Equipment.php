<?php

namespace App\Models;

class Equipment extends Service\Model
{
    use \App\Traits\HasPhotos;

    protected $appends = ['photo_url'];
}
