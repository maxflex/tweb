<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSection extends Model
{
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
         return $this->getItem();
     }

     public function getItem($tags = null)
     {
         $items = [];

         foreach($this->sections as $section) {
             $item = $section->getItem($tags);
             if ($item !== null) {
                 $items[] = [
                     'model'        => $section,
                     'is_section'   => true,
                     'items'        => $item['items'],
                     'position'     => $section->position,
                 ];
             }
         }
         foreach($this->getPositions($tags) as $position) {
             $items[] = [
                 'model'        => $position,
                 'is_section'   => false,
                 'position'     => $position->position,
             ];
         }

         if (! count($items)) {
             return null;
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
      * @param array $tags
      */
     public function getPositions($tags = null)
     {
         $query = PricePosition::where('price_section_id', $this->id);

         if ($tags) {
             foreach($tags as $tag_id) {
                 $query->whereRaw("EXISTS(select 1 from tag_entities
                     where tag_id={$tag_id}
                         and entity_id = price_positions.id
                         and entity_type = 'App\\\Models\\\PricePosition'
                 )");
             }
         }

         return $query->orderBy('position')->get();
     }
}
