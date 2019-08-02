<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileMenuSection extends Model
{
    protected $with = ['items'];

    protected $table = 'menu_sections';

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(MobileMenu::class, 'section_id')->whereNull('menu_id')->orderBy('position', 'asc');
    }

    public function onlyLinks()
    {
        return $this->items()->where('is_link', 0)->count() === 0;
    }
}
