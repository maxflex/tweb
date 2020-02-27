<?php

namespace App\Traits;

trait HasFolders
{
    public function scopeOrderByPosition($query)
    {
        return $query->orderBy('position', 'asc')->orderBy('id', 'asc');
    }

    public function scopeSearchByFolder($query, $folder_id)
    {
        if ($folder_id) {
            $query->where('folder_id', $folder_id);
        } else {
            $query->whereNull('folder_id');
        }
        return $query;
    }
}
