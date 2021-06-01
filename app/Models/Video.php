<?php

namespace App\Models;

use App\Contracts\SsrParsable;
use App\Service\Ssr\SsrVariable;
use App\Traits\HasFolders;
use Illuminate\Database\Eloquent\Model;

class Video extends Model implements SsrParsable
{
    use HasFolders;

    protected $appends = ['title_short', 'url'];

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

    public static function getParseItems($args, $page = 1)
    {
        $ids = array_filter(explode(',', $args->ids));
        $query = Video::whereIn('id', $ids);
        if (count($ids)) {
            $query->orderBy(\DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));
        } else {
            $query->orderByPosition();
        }
        return $query->paginate(3, ['*'], 'page', $page);
    }
}
