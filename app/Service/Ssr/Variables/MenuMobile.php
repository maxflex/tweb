<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
// use App\Models\MobileMenu;
use App\Models\MobileMenuSection;

class MenuMobile extends SsrVariable {
    public function parse()
    {
        return view($this->getViewName(), [
            'items' => $this->getItems(),
        ]);
    }

    private function getItems()
    {
        return MobileMenuSection::orderBy('position', 'asc')->get();
    }
}
