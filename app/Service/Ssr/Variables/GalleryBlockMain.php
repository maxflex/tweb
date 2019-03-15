<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Gallery;


class GalleryBlockMain extends SsrVariable {
    public function parse()
    {
        return view($this->getViewName(), [
            'items' => $this->getItems(),
            'args' => $this->args,
        ]);
    }

    private function getItems()
    {
        return Gallery::getItems('', '713,714' , '')->take(20)->get();
    }
}
