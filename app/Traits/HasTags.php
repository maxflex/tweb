<?php

namespace App\Traits;
use DB;
use App\Models\Tag;

trait HasTags
{
    public function tags()
    {
        return DB::table('tag_entities')->where('entity_type', self::class)->where('entity_id', $this->id);
    }

    public function getTagsAttribute()
    {
        return implode(',', $this->tags()->pluck('tag_id')->all());
        // return Tag::whereIn('id', $this->tags()->pluck('tag_id'))->get();
    }
}
