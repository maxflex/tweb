<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\{PriceSection, PricePosition};

class PricesController extends Controller
{
    public function index(Request $request)
    {
        $items = [];

        // Допустимые ID позиций, если указан folders или ids
        $allowed_ids = [];

        // Берем все допустимые ID из папок
        $ids_from_folders = [];
        if ($request->folders) {
            // append all subfolders
            $subfolder_ids = [];
            foreach($request->folders as $folder_id) {
                $subfolder_ids = array_merge($subfolder_ids, PriceSection::getSubsectionIds($folder_id));
            }
            $folder_ids = array_merge($request->folders, $subfolder_ids);

            foreach($folder_ids as $folder_id) {
                $allowed_ids = array_merge($allowed_ids, PricePosition::where('price_section_id', $folder_id)->orderBy('position')->pluck('id')->all());
            }
        }

        // Допустимые ID
        if ($request->ids) {
            $allowed_ids = array_merge($allowed_ids, $request->ids);
        }

        $allowed_ids = array_unique($allowed_ids);
        if (! count($allowed_ids)) {
            $allowed_ids = null;
        }

        $top_level_price_sections = PriceSection::whereNull('price_section_id')->orderBy('position')->get();
        foreach($top_level_price_sections as $section) {
            $item = $section->getItem($request->tags, $allowed_ids);
            if ($item !== null) {
                $items[] = $section->getItem($request->tags, $allowed_ids);
            }
        }

        return $items;
    }
}
