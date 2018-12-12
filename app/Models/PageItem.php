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

    // 500 limit

    public function getDescriptionAttribute($value)
    {
        preg_match_all('#\[link\|([\d]+)\|([\w\s]+)\]#um', $value, $m);
        foreach($m[0] as $i => $to_be_replaced) {
            $url = Page::getUrl($m[1][$i]);
            $value = str_replace($to_be_replaced, "<a href=\"/{$url}\">{$m[2][$i]}</a>", $value);
        }
        if ($this->position == 0 && $this->is_one_line) {
            if (strpos($value, "\n") !== false) {
                $value = explode("\n", $value);
                $value = array_map(function($a) {
                    return '<div><img src="/img/svg/right-chevron.svg" />' . $a . '</div>';
                }, $value);
                $value = implode('', $value);
            }
            return $value;
        }
        return $value;
    }
}
