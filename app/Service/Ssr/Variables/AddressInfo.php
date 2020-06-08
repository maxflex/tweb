<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class AddressInfo extends SsrVariable
{
    public function parse()
    {
        $maps = [
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

        return view($this->getViewName(), [
            'info' => (object) $maps[$this->args->map],
        ]);
    }
}
