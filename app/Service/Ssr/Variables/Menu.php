<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
// use App\Models\MobileMenu;
use App\Models\MobileMenuSection;

class Menu extends SsrVariable
{
    public function parse()
    {
        return view($this->getViewName(), [
            'items' => $this->getItems(),
            'maps' => getMapInfo(),
        ]);
    }

    private function getItems()
    {
        return MobileMenuSection::where('type', $this->args->type)
            ->orderBy('position', 'asc')
            ->get();
    }
}
