<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Video;
use DB;

class VideoBlock extends SsrVariable {
    public function parse()
    {
        $ids = array_filter(explode(',', $this->args->ids));
        $query = Video::whereIn('id', $ids);
        if (count($ids)) {
            $query->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));
        }
        $items = $query->get();
        return view($this->getViewName(), [
            'title' => $this->args->title,
            'items' => $items,
            'options' => [
                'show' => isset($this->args->show) ? $this->args->show : 3,
                'showBy' => 3,
            ],
        ]);
    }
}
