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

        if ($request->tags) {
            foreach($request->tags as $tag_id) {
                $query->whereRaw("EXISTS(select 1 from tag_entities
                    where tag_id={$tag_id}
                    and entity_id = reviews.id
                    and entity_type = 'App\\\Models\\\Review'
                )");
            }
        }

        $reviews = $query->get();

        $has_more_reviews = $reviews->count() ? Review::where('id', '<', $reviews->last()->id)->exists() : false;

        return compact('reviews', 'has_more_reviews');
    }
}
