<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use DB;

class GalleryController extends Controller
{
    const PER_PAGE      = 10;   //
    const FIRST_PAGE    = 6;    // сколько отображать в начале

    public function index(Request $request)
    {
        $take = $request->page == 0 ? self::FIRST_PAGE : self::PER_PAGE;
        $skip = self::FIRST_PAGE + (self::PER_PAGE * ($request->page - 1));

        if ($skip < 0) {
            $skip = 0;
        }

        // attachment-refactored
        $gallery = Gallery::skip($skip)->take($take)->orderBy('id', 'desc')->get();

        $has_more_gallery = $gallery->count() ? Gallery::where('id', '<', $gallery->last()->id)->exists() : false;

        return compact('gallery', 'has_more_gallery');
    }
}
