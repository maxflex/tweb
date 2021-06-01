<?php

namespace App\Contracts;

interface SsrParsable
{
    public static function getParseItems($args, $page);
}
