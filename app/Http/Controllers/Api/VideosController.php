<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Video;

class VideosController extends Controller
{
    const PER_PAGE      = 10;   //
    const FIRST_PAGE    = 3;    // сколько отображать в начале

    public function index(Request $request)
    {
        $take = $request->page == 0 ? self::FIRST_PAGE : self::PER_PAGE;
        $skip = self::FIRST_PAGE + (self::PER_PAGE * ($request->page - 1));

        if ($skip < 0) {
            $skip = 0;
        }

        // attachment-refactored
        $videos = Video::skip($skip)->take($take)->orderBy('id', 'asc')->get();

        $has_more_videos = $videos->count() ? Video::where('id', '>', $videos->last()->id)->exists() : false;

        return compact('videos', 'has_more_videos');
    }
}
