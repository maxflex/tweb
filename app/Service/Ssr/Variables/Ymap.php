<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class Ymap extends SsrVariable
{
    public function parse()
    {
        $map = $this->args->map;

        if ($map === 'all') {
            $maps = ['len', 'pol', 'delegat'];
            $zoom = 12;
        } else {
            $maps = [$map];
            $zoom = 14;
        }

        return view($this->getViewName(), [
            'map' => $map,
            'maps' => $maps,
            'zoom' => $zoom,
            'latLng' => [
                'len' => '55.717295, 37.595088',
                'pol' => '55.781302, 37.516040',
                'delegat' => '55.776432, 37.614464',
                'all' => '55.7497, 37.6032',
            ]
        ]);
    }
}
