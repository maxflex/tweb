<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class AddressInfo extends SsrVariable
{
    const MAPS = [
        'all' => [
            'address' => 'Ленинский проспект 25',
            'phone' => 'доб. 1',
            'route' => 'https://yandex.ru/maps/-/CBBLqNGlGC',
        ],
        'len' => [
            'address' => 'Ленинский проспект 25',
            'phone' => 'доб. 1',
            'route' => 'https://yandex.ru/maps/-/CBBLqNGlGC',
        ],
        'pol' => [
            'address' => 'Куусинена 6 корпус 3',
            'phone' => 'доб. 2',
            'route' => 'https://yandex.ru/maps/-/CBBLqGcYhD',
        ],
        'delegat' => [
            'address' => 'Делегатская 11',
            'phone' => 'доб. 3',
            'route' => 'https://yandex.ru/maps/-/CGCXiJib',
        ],

    ];

    public function parse()
    {
        return view($this->getViewName(), [
            'info' => (object) self::MAPS[$this->args->map],
        ]);
    }
}
