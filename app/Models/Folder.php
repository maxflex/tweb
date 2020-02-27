<?php

namespace App\Models;

use App\Traits\HasFolders;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFolders;
    protected $appends = ['item_count', 'folder_count'];

    public function getItemCountAttribute()
    {
        $class = $this->class;
        return $class::where('folder_id', $this->id)->count();
    }

    public function getFolderCountAttribute()
    {
        return self::where('folder_id', $this->id)->count();
    }

    public static function getSubfolderIds($folder_id)
    {
        $ids = self::where('folder_id', $folder_id)->pluck('id')->all();

        $subfolder_ids = [];
        foreach ($ids as $id) {
            $subfolder_ids = array_merge($subfolder_ids, self::getSubfolderIds($id));
        }

        return array_merge($ids, $subfolder_ids);
    }
}
