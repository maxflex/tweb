<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\{Review, Folder};
use DB;
use Cache;
use App\Service\Cacher;
use App\Models\Service\Factory;
use App\Models\Decorators\TagsFilterDecorator;

class ReviewsController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->ids && ! $request->folders) {
            $final_query = (new TagsFilterDecorator(Review::with('master')))->withTags($request->tags)->orderBy('folder_id', 'asc')->orderByPosition();
        } else {
            $ids = array_filter(explode(',', $request->ids));

            if ($request->folders) {
                $folder_ids = array_filter(explode(',', $request->folders));

                // append all subfolders
                $subfolder_ids = [];
                foreach($folder_ids as $folder_id) {
                    $subfolder_ids = array_merge($subfolder_ids, Folder::getSubfolderIds($folder_id));
                }
                $folder_ids = array_merge($folder_ids, $subfolder_ids);

                $ids_from_folders = [];
                foreach($folder_ids as $folder_id) {
                    $ids_from_folders = array_merge($ids_from_folders, Review::where('folder_id', $folder_id)->orderByPosition()->pluck('id')->all());
                }

                $ids = array_merge($ids_from_folders, $ids);
            }

            $final_query = Review::with('master')->whereIn('id', $ids);
            if (count($ids)) {
                $final_query->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));
            }
        }

        return $final_query->get();
    }

    public function show($id)
    {
        return Review::where('master_id', $id)->orderBy('date', 'desc')->get();
    }
}
