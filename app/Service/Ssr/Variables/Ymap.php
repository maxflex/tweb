<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class Ymap extends SsrVariable
{
    public function parse()
    {
        return view($this->getViewName(), [
            'balloonContent' => view('balloon-content')
        ]);
    }
}
