<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\{Review, Video, Gallery};

class DataController extends Controller
{
    public function get(Request $request)
    {
        switch ($request->class) {
            case 'video':
                $class = Video::class;
                break;
            case 'review':
                $class = Review::class;
                break;
            case 'gallery':
                $class = Gallery::class;
                break;
        }

        return $class::getParseItems((object) $request->args, $request->page);
    }
}
