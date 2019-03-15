<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Page;

class ArticleBlock extends SsrVariable {
    public function parse()
    {
        return view($this->getViewName(), [
            'items' => $this->getItems(),
        ]);
    }

    private function getItems()
    {
        return Page::where('folder_id', 29)->select('url', 'title')->get();
    }
}
