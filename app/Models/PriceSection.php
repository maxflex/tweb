<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSection extends Model
{
    protected $fillable = [
        'name',
        'price_section_id',
        'position'
    ];

    // protected $with = ['sections', 'positions'];

    // protected $appends = ['item'];

    public function positions()
    {
        return $this->hasMany(PricePosition::class)->orderBy('position');
    }

    public function sections()
    {
        return $this->hasMany(self::class);
    }

    /**
     *
     */
     public function getItemAttribute()
     {
         $items = [];

         foreach($this->sections as $section) {
             $items[] = [
                 'model'        => $section,
                 'is_section'   => true,
                 'items'        => $section->item['items'],
                 'position'     => $section->position,
             ];
         }
         foreach($this->positions as $position) {
             $items[] = [
                 'model'        => $position,
                 'is_section'   => false,
                 'position'     => $position->position,
             ];
         }

         usort($items, function($a, $b) {
             return $a['position'] - $b['position'];
         });

         return [
             'model' => $this,
             'is_section' => true,
             'items' => $items,
             'position' => $this->position
         ];
     }

    /**
     * Обновить цену у раздела
     */
    public static function changePrice($data)
    {
        $section = self::find($data->section_id);
        foreach($section->sections as $child_section) {
            $clone_data = clone $data;
            $clone_data->section_id = $child_section->id;
            self::changePrice($clone_data);
        }
        foreach($section->positions as $position) {
            if ($data->unit == 1) {
                $coeff = $position->price * ($data->value / 100);
            } else {
                $coeff = $data->value;
            }
            if ($data->type == 1) {
                $new_price = $position->price - $coeff;
            } else {
                $new_price = $position->price + $coeff;
            }
            PricePosition::whereId($position->id)->update([
                'price' => $new_price
            ]);
        }
    }
}
