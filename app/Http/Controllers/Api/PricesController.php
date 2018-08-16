<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PriceSection;

class PricesController extends Controller
{
    public function index(Request $request)
    {
        $items = [];
        $top_level_price_sections = PriceSection::whereNull('price_section_id')->orderBy('position')->get();
        foreach($top_level_price_sections as $section) {
            $item = $section->getItem($request->tags, $request->folders, $request->ids);
            if ($item !== null) {
                $items[] = $section->getItem($request->tags, $request->folders, $request->ids);
            }
        }
        return $items;
    }
}
