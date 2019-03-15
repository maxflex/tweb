<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Gallery;


class GalleryBlock extends SsrVariable {
    public function parse()
    {
        return view($this->getViewName(), [
            'items' => $this->getItems(),
            'args' => $this->args,
            'tags' => $this->page->tags,
        ]);
    }

    private function getItems()
    {
        return Gallery::getItems(@$this->args->ids, @$this->args->folders, @$this->args->tags)->take(9)->get();
    }
}
