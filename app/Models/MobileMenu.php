<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileMenu extends Model
{
    public $timestamps = false;
    protected $table = 'menu';
    protected $with = ['children'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'menu_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'menu_id')->orderBy('position', 'asc');
    }

    public static function boot()
    {
        parent::boot();

        self::addGlobalScope('exclude-hidden', function ($query) {
            $query->where('is_hidden', 0);
        });
    }
}
