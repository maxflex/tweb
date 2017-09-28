<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageItem extends Model
{
    public $timestamps = false;

    protected $appends = ['photo_url', 'link_url'];

    public function getPhotoUrlAttribute()
    {
        if ($this->file) {
            return config('app.crm-url') . 'storage/pageitems/' . $this->file;
        } else {
            return '/img/icons/nocropped.png';
        }
    }

    public function getLinkUrlAttribute()
    {
        if ($this->href_page_id) {
            $query = Page::whereId($this->href_page_id);
            if ($query->exists()) {
                return $query->value('url');
            }
        }
        return null;
    }
}
