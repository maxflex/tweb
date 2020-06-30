<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class AddressDirections extends SsrVariable
{
    public function parse()
    {
        if (!$this->page->items()->exists()) {
            return '';
        }

        $firstItem = null;
        $items = $this->page->items->all();

        if ($items[0]->is_one_line) {
            $firstItem = array_shift($items);
        }

        return view($this->getViewName(), [
            'url' => $this->page->url,
            'firstItem' => $firstItem,
        ]);
    }
}
