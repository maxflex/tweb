<?php

namespace App\Service\Ssr\Variables;

use App\Service\Ssr\SsrVariable;
use App\Models\Equipment as EquipmentModel;
use DB;

class Equipment extends SsrVariable {
    public function parse()
    {
        // $ids = explode(',', $args[0]);
        // $query = Equipment::with('photos');
        // if (count($ids) == 1) {
        //     $items = $query->whereId($ids[0])->first();
        // } else {
        //     $items = $query->whereIn('id', $ids)->get();
        // }

        $item = EquipmentModel::with('photos')->whereId($this->args->id)->first();

        // в cms есть случаи, когда висит старый несуществующий equipmentId
        if ($item === null) {
            return '';
        }

        return view($this->getViewName(), [
            'item' => $item,
            'args' => $this->args,
        ]);
    }
}
