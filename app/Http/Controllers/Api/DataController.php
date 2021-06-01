<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Video;

class DataController extends Controller
{
    public function get(Request $request)
    {
        switch ($request->class) {
            case 'video': {
                    $class = Video::class;
                    break;
                }
            case 'review': {
                    $class = Review::class;
                    break;
                }
        }

        return $class::getParseItems((object) $request->args, $request->page);
    }
}
