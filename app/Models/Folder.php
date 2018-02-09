<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public static function getSubfolderIds($folder_id)
    {
        $ids = self::where('folder_id', $folder_id)->pluck('id')->all();

        $subfolder_ids = [];
        foreach($ids as $id) {
            $subfolder_ids = array_merge($subfolder_ids, self::getSubfolderIds($id));
        }

        return array_merge($ids, $subfolder_ids);
    }
}
