<?php

namespace App\Models;

use App\Contracts\SsrParsable;
use App\Models\Decorators\TagsFilterDecorator;
use App\Scopes\ReviewScope;
use Illuminate\Database\Eloquent\Model;
use App\Service\Cacher;
use App\Service\Months;
use App\Service\Ssr\SsrVariable;
use Cache;
use DB;
use App\Traits\{HasTags, HasFolders};

class Review extends Model implements SsrParsable
{
    use HasTags, HasFolders;

    protected $appends = ['date_string'];

    public function master()
    {
        return $this->belongsTo(Master::class);
    }

    public function getDateStringAttribute()
    {
        $date = $this->attributes['date'];
        return date('j ', strtotime($date)) . Months::SHORT[date('n', strtotime($date))] . date(' Y', strtotime($date));
    }


    public static function getParseItems($args, $page = 1)
    {
        if (!$args->ids && !$args->folders) {
            $final_query = (new TagsFilterDecorator(Review::with('master')))->withTags($args->tags)->orderBy('folder_id', 'asc')->orderByPosition();
        } else {
            $ids = array_filter(explode(',', $args->ids));

            if ($args->folders) {
                $folder_ids = array_filter(explode(',', $args->folders));

                // append all subfolders
                $subfolder_ids = [];
                foreach ($folder_ids as $folder_id) {
                    $subfolder_ids = array_merge($subfolder_ids, Folder::getSubfolderIds($folder_id));
                }
                $folder_ids = array_merge($folder_ids, $subfolder_ids);

                $ids_from_folders = [];
                foreach ($folder_ids as $folder_id) {
                    $ids_from_folders = array_merge($ids_from_folders, Review::where('folder_id', $folder_id)->orderByPosition()->pluck('id')->all());
                }

                $ids = array_merge($ids_from_folders, $ids);
            }

            $final_query = Review::with('master')->whereIn('id', $ids);
            if (count($ids)) {
                $final_query->orderBy(\DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));
            }
        }

        if (isset($args->firstThree)) {
            return $final_query->paginate(3);
        } else {
            $skipFirstThree = $final_query->take(3)->pluck('id');
            return $final_query->whereNotIn('id', $skipFirstThree)->paginate(10, ['*'], 'page', $page - 1);
        }
    }

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ReviewScope);
    }
}
