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
        return Tag::whereIn('id', $this->tags()->pluck('tag_id'))->get();
    }

    public function setTagsAttribute($tags)
    {
        $this->tags()->delete();
        foreach($tags as $tag) {
            DB::table('tag_entities')->insert([
                'entity_type' => self::class,
                'entity_id' => $this->id,
                'tag_id' => $tag['id'],
            ]);
        }
    }
}
