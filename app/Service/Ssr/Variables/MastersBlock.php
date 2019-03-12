<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Master;
use DB;

class MastersBlock extends SsrVariable {
    public function parse()
    {
        $all = $this->args->ids === 'all';

        if ($all) {
            $items = Master::with('photos')->get();
        } else {
            $ids = array_filter(explode(',', $this->args->ids));
            $query = Master::with('photos')->whereIn('id', $ids);
            if (count($ids)) {
                $query->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));
            }
            $items = $query->get();
        }

        return view($this->getViewName(), [
            'title' => @$this->args->title,
            'desc' => @$this->args->desc,
            'all' => $all,
            'items' => $items,
        ]);
    }
}
