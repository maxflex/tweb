<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;

class AddressInfo extends SsrVariable
{
    const MAPS = [
        'len' => [
            'address' => 'Ленинский проспект 25',
            'phone' => 'доб. 1',
            'mobile' => '+7 903 763 15 21',
            'route' => 'https://yandex.ru/maps/-/CBBLqNGlGC',
        ],
        'pol' => [
            'address' => 'Куусинена 6 корпус 3',
            'phone' => 'доб. 2',
            'mobile' => '+7 905 746 44 81',
            'route' => 'https://yandex.ru/maps/-/CBBLqGcYhD',
        ],
        'delegat' => [
            'address' => 'Делегатская 11',
            'phone' => 'доб. 3',
            'mobile' => '+7 965 374 32 47',
            'route' => 'https://yandex.ru/maps/-/CGCXiJib',
        ],

    ];

    public function parse()
    {
        if ($this->args->map === 'all') {
            $ssrVariable = new AddressInfoAll('address-info-all', $this->page, $this->args);
            return $ssrVariable->parse();
        }
        return view($this->getViewName(), [
            'info' => (object) self::MAPS[$this->args->map],
        ]);
    }
}
