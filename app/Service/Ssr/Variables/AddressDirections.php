<?php

namespace App\Service\Ssr\Variables;

use App\Models\Page;
use App\Service\Ssr\SsrVariable;
use Illuminate\Support\Facades\Request;

class AddressDirections extends SsrVariable
{
    public function parse()
    {
        $page = Page::whereUrl(Request::path())->first();

        if (!$page->items()->exists()) {
            return '';
        }

        $firstItem = null;
        $items = $page->items->all();

        if ($items[0]->is_one_line) {
            $firstItem = array_shift($items);
        }

        return view($this->getViewName(), [
            'map' => $this->args->map,
            'firstItem' => $firstItem,
        ]);
    }
}
