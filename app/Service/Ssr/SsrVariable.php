<?php

namespace App\Service\Ssr;

abstract class SsrVariable
{
    const VIEWS_FOLDER = 'ssr.';

    protected $variableName;
    protected $page;
    protected $args;

    public function __construct($variableName, $page, $args = [])
    {
        $this->variableName = $variableName;
        $this->page = $page;
        $this->args = $args;
    }

    public function getViewName($alwaysDesktop = false)
    {
        return self::VIEWS_FOLDER . ((isMobile() && !$alwaysDesktop) ? 'mobile.' : 'desktop.') . $this->variableName;
    }

    abstract public function parse();
}
