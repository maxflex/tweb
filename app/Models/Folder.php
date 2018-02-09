<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public static function getSubfolderIds($folder_id)
    {
        $ids = self::where('folder_id', $folder_id)->pluck('id')->all();
        foreach($ids as $id) {
            $ids[] = self::getSubfolderIds($id);
        }
        return $ids;
    }
}
