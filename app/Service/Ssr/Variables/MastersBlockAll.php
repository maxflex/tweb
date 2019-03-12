<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Master;

class MastersBlockAll extends SsrVariable {
    public function parse()
    {
        $items = Master::with('photos')->get();
        $options = isMobile() ? ['show' => 4, 'showBy' => 4] : ['show' => 6, 'showBy' => 6];
        return view($this->getViewName(), [
            'title' => $this->args->title,
            'items' => $items,
            'options' => $options,
        ]);
    }
}
