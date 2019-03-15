<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\{Gallery, Folder};
use App\Models\Decorators\TagsFilterDecorator;
use DB;

class GalleryController extends Controller
{
    const PER_PAGE      = 10;   //
    const FIRST_PAGE    = 6;    // сколько отображать в начале

    public function index(Request $request)
    {
        // attachment-refactored
        $gallery = Gallery::with('master')->get();

        $has_more_gallery = $gallery->count() ? Gallery::where('id', '<', $gallery->last()->id)->exists() : false;

        return compact('gallery', 'has_more_gallery');
    }

    public function init(Request $request)
    {
        return Gallery::getItems($request->ids, $request->folders, $request->tags)->get()->toJson();
    }
}
