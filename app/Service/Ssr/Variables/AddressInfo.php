<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class AddressInfo extends SsrVariable
{
    public function parse()
    {
        if ($this->args->map === 'all') {
            $ssrVariable = new AddressInfoAll('address-info-all', $this->page, $this->args);
            return $ssrVariable->parse();
        }
        return view($this->getViewName(), [
            'info' => (object) getMapInfo($this->args->map),
        ]);
    }
}
