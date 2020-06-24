<?php

namespace App\Service\Ssr\Variables;

use App\Models\Page;
use App\Service\Ssr\SsrVariable;
use Illuminate\Support\Facades\Request;

class Ymap extends SsrVariable
{
    public function parse()
    {
        $page = Page::whereUrl(Request::path())->first();

        $map = $this->args->map;

        if ($map === 'all') {
            $maps = ['len', 'pol', 'delegat'];
            $zoom = isMobile() ? 11 : 12;
        } else {
            $maps = [$map];
            $zoom = 14;
        }

        return view($this->getViewName(true), [
            'map' => $map,
            'maps' => $maps,
            'zoom' => $zoom,
            'route' => (object) [
                'latLng' => $page->lat_lng,
                'mode' => $page->routing_mode,
            ],
            'latLng' => [
                'len' => '55.717295, 37.595088',
                'pol' => '55.781302, 37.516040',
                'delegat' => '55.776432, 37.614464',
                'all' => isMobile() ? '55.7497, 37.5700' : '55.7497, 37.6032',
            ]
        ]);
    }
}
