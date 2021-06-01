<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Video;

class VideoBlock extends SsrVariable
{
    public function parse()
    {
        return view($this->getViewName(), [
            'title' => $this->args->title,
            'data' => Video::getParseItems($this->args),
            'args' => $this->args,
        ]);
    }
}
