<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;


class BannerBlock extends SsrVariable {
    public function parse()
    {
        $lines = [];
        if (isset($this->args->lines)) {
            $lines = explode('#', $this->args->lines);
        }
        return view($this->getViewName(), [
            'h1' => $this->page->h1,
            'args' => $this->args,
            'lines' => $lines,
        ]);
    }
}
