<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\{HasTags, HasPhotos, HasFolders};
use App\Models\Decorators\TagsFilterDecorator;
use DB;

class Gallery extends Model
{
    use HasTags, HasPhotos, HasFolders;

    protected $casts = [
        'watermark' => 'boolean',
        'before_and_after' => 'boolean',
    ];

    protected $appends = ['url', 'total_price', 'components'];

    // public function taggs()
    // {
    //     return $this->morphMany(TagEntity::class, 'entity');
    // }

    public function master()
    {
        return $this->belongsTo(Master::class);
    }

    public function getDateAttribute($value)
    {
        return dateFormat($value, true);
    }

    public function getTotalPriceAttribute()
    {
        $sum = 0;
        foreach(range(1, 6) as $i) {
            $sum += intval($this->attributes['price_' . $i]);
        }
        return $sum;
    }

    public function getUrlAttribute()
    {
        return config('app.crm-url') . 'img/gallery/' . $this->id . '.webp';
    }

    public function getComponentsAttribute()
    {
        $components = [];
        foreach(range(1, 6) as $component_index) {
            if ($this->{"component_" . $component_index}) {
                $components[] = [
                    'name' => $this->{"component_" . $component_index},
                    'price' => $this->{"price_" . $component_index},
                ];
            }
        }
        return $components;
    }

    public static function getItems($gallery_ids, $folder_ids, $tags)
    {
        /**
         * Если не указаны ID фото и ID папок, то автозаполнение по тегам
         */
        if (! $gallery_ids && ! $folder_ids) {
            return (new TagsFilterDecorator(Gallery::with('master')))->withTags($tags)->orderBy('folder_id', 'asc')->orderByPosition();
        } else {
            $gallery_ids = array_filter(explode(',', $gallery_ids));

            if ($folder_ids) {
                $folder_ids = array_filter(explode(',', $folder_ids));

                // append all subfolders
                $subfolder_ids = [];
                foreach($folder_ids as $folder_id) {
                    $subfolder_ids = array_merge($subfolder_ids, Folder::getSubfolderIds($folder_id));
                }
                $folder_ids = array_merge($folder_ids, $subfolder_ids);

                $gallery_ids_from_folders = [];
                foreach($folder_ids as $folder_id) {
                    $gallery_ids_from_folders = array_merge($gallery_ids_from_folders, Gallery::where('folder_id', $folder_id)->orderByPosition()->pluck('id')->all());
                }

                $gallery_ids = array_merge($gallery_ids_from_folders, $gallery_ids);
            }

            $query = Gallery::with('master')->whereIn('id', $gallery_ids);
            if (count($gallery_ids)) {
                $query->orderBy(DB::raw('FIELD(id, ' . implode(',', $gallery_ids) . ')'));
            }

            return $query;
        }
    }
}
