<?php

namespace App\Models;

class Master extends Service\Model
{
    use \App\Traits\HasPhotos;

    protected $appends = ['photo_url'];
}
