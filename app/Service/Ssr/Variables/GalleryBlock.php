<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Gallery;


class GalleryBlock extends SsrVariable
{
    public function parse()
    {
        // dd([@$this->args->ids, @$this->args->folders, @$this->page->tags]);
        $this->args->tags = @$this->page->tags;

        if (!@$this->args->ids && @$this->page->url === 'masters/:id') {
            $data = Gallery::whereId(-1)->paginate();
        } else {
            $data = Gallery::getParseItems($this->args);
        }

        if (@$this->page) {
            $alt = $this->page->url === "/"
                ? "Ремонт, ушив, перешив и утпеление одежды в Ателье Талисман. Фото до и после"
                : ($this->page->getClean('h1') .  " до и после");
        } else {
            $alt = "";
        }

        return view($this->getViewName(), [
            'args' => $this->args,
            'data' => $data,
            'alt' => $alt,
        ]);
    }
}
