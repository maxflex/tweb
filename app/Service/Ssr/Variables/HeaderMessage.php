<?php

namespace App\Service\Ssr\Variables;

use App\Service\Settings;
use App\Service\Ssr\SsrVariable;

class HeaderMessage extends SsrVariable
{
    public function parse()
    {
        $header = trim(Settings::get('header'));
        if ($header === '') {
            return;
        }
        $lines = explode("\n", $header);
        $firstLine = null;
        if (count($lines) > 1) {
            $firstLine = array_shift($lines);
        }
        return view($this->getViewName(), compact('lines', 'firstLine'));
    }
}
