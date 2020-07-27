<?php

namespace App\Service\Ssr\Variables;

class AddressInfoAll extends AddressInfo
{
    public function parse()
    {
        return view($this->getViewName(), [
            'maps' => getMapInfo(),
        ]);
    }
}
