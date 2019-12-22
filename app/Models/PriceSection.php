<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Decorators\TagsFilterDecorator;

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

     public function getItem($tags = null, $allowed_ids = null)
     {
         $items = [];

         foreach($this->sections as $section) {
             $item = $section->getItem($tags, $allowed_ids);
             if ($item !== null) {
                 $items[] = [
                     'model'        => $section,
                     'is_section'   => true,
                     'items'        => $item['items'],
                     'position'     => $section->position,
                 ];
             }
         }
         foreach($this->getPositions($tags, $allowed_ids) as $position) {
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
     public function getPositions($tags = null, $allowed_ids = null)
     {
         $query = PricePosition::where('price_section_id', $this->id);
         if ($allowed_ids) {
             $query->whereIn('id', $allowed_ids);
         } else {
             $query = (new TagsFilterDecorator($query))->withTags($tags);
         }
         return $query->orderBy('position')->get();
     }

     public static function getSubsectionIds($section_id)
     {
        $ids = self::where('price_section_id', $section_id)->pluck('id')->all();

        $subsection_ids = [];
        foreach($ids as $id) {
            $subsection_ids = array_merge($subsection_ids, self::getSubsectionIds($id));
        }

        return array_merge($ids, $subsection_ids);
    }

    public static function boot()
    {
        parent::boot();

        self::addGlobalScope('exclude-hidden', function ($query) {
            $query->where('is_hidden', 0);
        });
    }
}
