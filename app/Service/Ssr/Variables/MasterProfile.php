<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Master;
use DB;

class MasterProfile extends SsrVariable {
    public function parse()
    {
        $reviewsBlockVariable = new ReviewsBlock('reviews-block', $this->page, (object)[
            'items' => $this->args->master->reviews,
            'show' => 5,
        ]);

        return view($this->getViewName(), [
            'master' => $this->args->master,
            'reviewsBlock' => $reviewsBlockVariable->parse(),
        ]);
    }
}
