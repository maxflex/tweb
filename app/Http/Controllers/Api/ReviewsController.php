<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Review;
use DB;
use Cache;
use App\Service\Cacher;
use App\Models\Service\Factory;
use App\Models\Decorators\TagsFilterDecorator;

class ReviewsController extends Controller
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

        $query = Review::with('master')->skip($skip)->take($take)->orderBy('id', 'desc');

        $query = (new TagsFilterDecorator($query))->withTags($request->tags);

        $reviews = $query->get();

        $has_more_reviews = $reviews->count() ? Review::where('id', '<', $reviews->last()->id)->exists() : false;

        return compact('reviews', 'has_more_reviews');
    }

    public function show($id)
    {
        return Review::where('master_id', $id)->orderBy('date', 'desc')->get();
    }
}
