<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;


class BannerBlock3 extends SsrVariable
{
    public function parse()
    {
        $lines = [];
        if (isset($this->args->lines)) {
            $lines = explode('#', $this->args->lines);
        }
        if (isMobile() && isset($this->args->img)) {
            $this->args->img = preg_replace('/(.*).jpg/', '$1_mobile.jpg', $this->args->img);
        }
        return view($this->getViewName(), [
            'h1' => $this->page->h1,
            'args' => $this->args,
            'lines' => $lines,
        ]);
    }
}
