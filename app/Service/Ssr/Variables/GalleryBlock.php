<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Gallery;


class GalleryBlock extends SsrVariable
{
    public function parse()
    {
        // dd([@$this->args->ids, @$this->args->folders, @$this->page->tags]);
        return view($this->getViewName(), [
            'items' => $this->getItems(),
            'args' => $this->args,
            'tags' => @$this->page->tags,
        ]);
    }

    private function getItems()
    {
        if (!@$this->args->ids && @$this->page->url === 'masters/:id') {
            return [];
        }
        return Gallery::getItems(@$this->args->ids, @$this->args->folders, @$this->page->tags)->take(9)->get();
    }
}
