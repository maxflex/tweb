<?php

namespace App\Models;

use App\Scopes\ReviewScope;
use Illuminate\Database\Eloquent\Model;
use App\Service\Cacher;
use App\Service\Months;
use Cache;
use DB;
use App\Traits\{HasTags, HasFolders};

class Review extends Model
{
    use HasTags, HasFolders;

    protected $appends = ['date_string'];

    public function master()
    {
        return $this->belongsTo(Master::class);
    }

    public function getDateStringAttribute()
    {
        $date = $this->attributes['date'];
        return date('j ', strtotime($date)) . Months::SHORT[date('n', strtotime($date))] . date(' Y', strtotime($date));
    }


    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ReviewScope);
    }
}
