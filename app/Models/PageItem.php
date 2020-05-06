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
        if (is_numeric($this->href_page_id)) {
            $query = Page::whereId($this->href_page_id);
            if ($query->exists()) {
                return $query->value('url');
            }
        }
        return $this->href_page_id ? $this->href_page_id : null;
    }

    // 500 limit

    public function getDescriptionAttribute($value)
    {
        preg_match_all('#\[link\|([\d]+)\|([\w\s]+)\]#um', $value, $m);
        foreach ($m[0] as $i => $to_be_replaced) {
            $url = Page::getUrl($m[1][$i]);
            $value = str_replace($to_be_replaced, "<a href=\"/{$url}/\">{$m[2][$i]}</a>", $value);
        }
        if ($this->position == 0 && $this->is_one_line) {
            if (strpos($value, "\n") !== false) {
                $value = explode("\n", $value);
                $value = array_map(function ($a) {
                    return '<div><img src="/img/svg/right-chevron.svg" />' . $a . '</div>';
                }, $value);
                $value = implode('', $value);
            }
            $value = str_replace("[walk]", '<i class="fas fa-walking"></i>', $value);
            $value = str_replace("[car]", '<i class="fas fa-car"></i>', $value);
            $value = str_replace("[bus]", '<i class="fas fa-bus"></i>', $value);
            $value = preg_replace("#\[line-(\d+)\]#", '<span class="metro-circle line-$1"></span>', $value);
            return $value;
        }
        return $value;
    }
}
