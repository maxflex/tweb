<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    const UPLOAD_DIR = '/request-photos/';

    public static function getDir()
    {
        return public_path() . self::UPLOAD_DIR;
    }
}
