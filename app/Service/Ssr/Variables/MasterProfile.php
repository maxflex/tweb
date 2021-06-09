<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Master;
use DB;

class MasterProfile extends SsrVariable
{
    public function parse()
    {
        return view($this->getViewName(), [
            'master' => $this->args->master,
        ]);
    }
}
