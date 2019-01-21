<?php

namespace App\Models;

use Shared\Model;
use App\Models\Variable;
use App\Models\Service\Parser;
use App\Scopes\PageScope;
use App\Models\Service\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTags;
use DB;

class Page extends Model
{
    use SoftDeletes, HasTags;

    protected $dates = ['deleted_at'];

    // Соответствия между разделами и ID предмета
    static $subject_page_id = [
        '1'   => 194,
        '2'   => 195,
        '3'   => 198,
        '4'   => 199,
        '5'   => 203,
        '6'   => 196,
        '7'   => 197,
        '8'   => 201,
        '9'   => 200,
        '10'  => 202,
        '1,2' => 247,
    ];

    // also serp fields
    protected $casts = [
       'id'         => 'int', // ID нужен, чтобы идентифицировать текущую страницу в search
       'place'      => 'string',
       'station_id' => 'string',
       'subjects'   => 'string',
       'sort'       => 'string',
   ];

    public function items()
    {
        return $this->hasMany(PageItem::class)->orderBy('position');
    }

    public function getSubjectsAttribute($value)
    {
        if ($value) {
            $subjects = explode(',', $value);
            foreach($subjects as $subject_id) {
                $return[$subject_id] = true;
            }
            return (object)$return;
        } else {
            return emptyObject();
        }
    }

    public function getSearchAttribute()
    {
        foreach($this->casts as $field => $type) {
            $data[$field] = $this->{$field};
        }
        if ($this->hidden_filter) {
            $data['hidden_filter'] = explode(',', str_replace(' ', '', mb_strtolower($this->hidden_filter)));
        }
        return json_encode($data, JSON_FORCE_OBJECT);
    }

    public function getSeoPageIdsAttribute($seo_page_ids)
    {
        if ($seo_page_ids) {
            $seo_page_ids = explode(',', $seo_page_ids);
            $seo_page_ids = array_map('trim', $seo_page_ids);

            // обрабатываем ссылки вида [370|тебя что-то не устраивает]
            $update_title = [];
            foreach($seo_page_ids as $index => $seo_page_id) {
                if ($seo_page_id[0] === '[') {
                    preg_match('/\[([\d]+)\|(.*)\]/', $seo_page_id, $m);
                    $seo_page_ids[$index] = $m[1];
                    $update_title[$m[1]] = $m[2];
                }
            }

            if (count($seo_page_ids)) {
                $pages = Page::select('id', 'url', 'keyphrase')->whereIn('id', $seo_page_ids)->orderBy(DB::raw('FIELD(id, ' . implode(',', $seo_page_ids) . ')'))->get();
                foreach($update_title as $page_id => $title) {
                    $pages->where('id', $page_id)->first()->keyphrase = $title;
                }
                return view('seo.links')->with(compact('pages'));
            }
        }
        return '';
    }

    public function getHtmlAttribute()
    {
        $value = $this->getHtml();
        // return "<textarea rows='50' style='width: 100%'>{$value}</textarea>";
        $value = Parser::compileVars($value, $this);
        return Parser::compilePage($this, $value);
    }

    public function setHtmlAttribute($value)
    {
        if (isMobile()) {
            $this->attributes['html_mobile'] = $value;
        } else {
            $this->attributes['html'] = $value;
        }
    }

    public function getH1Attribute($value)
    {
        if ($value) {
            return "<h1 class='h1-top'>{$value}</h1>";
        }
        return ' ';
    }

    public function getH1BottomAttribute($value)
    {
        if ($value) {
            return "<h1 class='h1-bottom'>{$value}</h1>";
        }
        return ' ';
    }

    public function scopeWhereSubject($query, $subject_id)
    {
        return $query->whereRaw("FIND_IN_SET($subject_id, subjects)");;
    }

    public function scopeFindByParams($query, $search)
    {
        @extract($search);

        $query->where('subjects', implode(',', $subjects));
        $query->where('place', setOrNull(@$place));
        $query->where('sort', setOrNull(@$sort));
        $query->where('station_id', setOrNull(@$station_id));
        $query->where('id', '!=', $id);

        return $query;
    }

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PageScope);
    }

    public static function getUrl($id)
    {
        return self::whereId($id)->value('url');
    }

    public static function getSubjectUrl($subject_eng)
    {
        return self::getUrl(Page::$subject_page_id[Factory::getSubjectId($subject_eng)]);
    }

    public static function getSubjectRoutes()
    {
        $subject_routes = [];
        foreach(self::$subject_page_id as $subject_id => $page_id) {
            // ссылки только к отдельным предметам
            if (strpos($subject_id, ',') === false) {
                $subject_routes[$subject_id] = self::getUrl($page_id);
            }
        }
        return $subject_routes;
    }

    /**
     * Главная страница серпа
     */
    public function isMainSerp()
    {
        return $this->id == 10;
    }

    public function getHtml()
    {
        if (isMobile() && empty(trim($this->attributes['html_mobile']))) {
            return Parser::getPostfixed($this->attributes['html'], $this);
        }
        return isMobile() ? $this->attributes['html_mobile'] : $this->attributes['html'];
    }
}
