<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class ServiceList extends SsrVariable {
    public function parse()
    {
        $firstItem = null;
        $items = $this->page->items->all();

        if ($items[0]->is_one_line) {
            $firstItem = array_shift($items);
        }

        return view($this->getViewName(), [
            'page' => $this->page,
            'items' => $items,
            'firstItem' => $firstItem,
            'options' => [
                'showAllItems' => $firstItem === null,
                'show' => 6,
            ],
        ]);
    }
}
