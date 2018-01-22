<?php

namespace App\Models\Decorators;

use Illuminate\Database\Eloquent\Builder;

class TagsFilterDecorator
{
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function withTags($tags)
    {
        if ($tags) {
            if (is_string($tags)) {
                $tags = explode(',', $tags);
            }

            $tags = array_filter($tags);
            
            foreach($tags as $tag_id) {
                $this->builder->whereRaw("EXISTS(select 1 from tag_entities
                where tag_id={$tag_id}
                and entity_id = " . $this->builder->getModel()->getTable() . ".id
                and entity_type = '" . addslashes(get_class($this->builder->getModel())) . "'
                )");
            }
        }
        return $this->builder;
    }
}