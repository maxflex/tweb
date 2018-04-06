<?php

namespace App\Models;

class Equipment extends Service\Model
{
    use \App\Traits\HasPhotos;

    protected $appends = ['photo_url', 'contrast'];

    public function getContrastAttribute()
    {
        list($r, $g, $b) = sscanf($this->color, "#%02x%02x%02x");
        if (($r * 0.299 + $g * 0.587 + $b * 0.114) > 186) {
            return 'white';
        } else {
            return 'black';
        }
    }
}
