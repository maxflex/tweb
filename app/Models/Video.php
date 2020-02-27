<?php

namespace App\Models;

use App\Traits\HasFolders;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFolders;

    public function getTitleShortAttribute()
    {
        $title = $this->attributes['title'];
        if (strlen($title) > 20) {
            return mb_strimwidth($title, 0, 20) . '...';
        }
        return $title;
    }

    public function getUrlAttribute()
    {
        return config('app.crm-url') . 'img/video/' . $this->id . '.jpg';
    }
}
