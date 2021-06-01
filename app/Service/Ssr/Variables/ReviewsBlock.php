<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Review;

class ReviewsBlock extends SsrVariable
{
    public function parse()
    {
        if (!$this->args->ids && !$this->args->folders && !isset($this->args->tags)) {
            $this->args->tags = $this->page->tags;
        }

        $args = clone $this->args;
        $args->firstThree = true;

        return view($this->getViewName(), [
            'data' => Review::getParseItems($args),
            'args' => $this->args,
        ]);
    }
}
