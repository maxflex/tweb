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
            $this->builder->whereRaw("EXISTS(select 1 from tag_entities
                where tag_id in ({$tags})
                    and entity_id = " . $this->builder->getModel()->getTable() . ".id
                    and entity_type = '" . get_class($this->builder->getModel()) . "'
            )");
        }
    }
}