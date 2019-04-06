<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileMenu extends Model
{
    public $timestamps = false;
    protected $table = 'mobile_menu';
    protected $with = ['children'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'menu_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'menu_id')->orderBy('position', 'asc');
    }
}
