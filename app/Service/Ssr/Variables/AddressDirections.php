<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class AddressDirections extends SsrVariable
{
    public function parse()
    {
        $firstItem = null;
        $items = $this->page->items->all();

        if ($items[0]->is_one_line) {
            $firstItem = array_shift($items);
        }

        return view($this->getViewName(), [
            'firstItem' => $firstItem,
        ]);
    }
}
