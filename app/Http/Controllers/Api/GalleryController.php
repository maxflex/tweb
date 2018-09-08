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
        $gallery_ids = $request->ids;
        $folder_ids = $request->folders;
        $tags = $request->tags;

        /**
         * Если не указаны ID фото и ID папок, то автозаполнение по тегам
         */
        if (! $gallery_ids && ! $folder_ids) {
            return (new TagsFilterDecorator(Gallery::with('master')))->withTags($tags)->orderBy('folder_id', 'asc')->orderByPosition()->get()->toJson();
        } else {
            $gallery_ids = array_filter(explode(',', $gallery_ids));

            if ($folder_ids) {
                $folder_ids = array_filter(explode(',', $folder_ids));

                // append all subfolders
                $subfolder_ids = [];
                foreach($folder_ids as $folder_id) {
                    $subfolder_ids = array_merge($subfolder_ids, Folder::getSubfolderIds($folder_id));
                }
                $folder_ids = array_merge($folder_ids, $subfolder_ids);

                $gallery_ids_from_folders = [];
                foreach($folder_ids as $folder_id) {
                    $gallery_ids_from_folders = array_merge($gallery_ids_from_folders, Gallery::where('folder_id', $folder_id)->orderByPosition()->pluck('id')->all());
                }

                $gallery_ids = array_merge($gallery_ids_from_folders, $gallery_ids);
            }

            $query = Gallery::with('master')->whereIn('id', $gallery_ids);
            if (count($gallery_ids)) {
                $query->orderBy(DB::raw('FIELD(id, ' . implode(',', $gallery_ids) . ')'));
            }

            return $query->get()->toJson();
        }
    }
}
