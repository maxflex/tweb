<?php

namespace App\Traits;
use DB;

trait HasFolders
{
    public function scopeOrderByPosition($query)
    {
        return $query->orderBy('position', 'asc')->orderBy('id', 'asc');
    }
}
