<?php
    namespace App\Models\Service;
    use App\Models\{Program, Variable, Photo, Gallery, Review, Page, Mater, Video, Equipment, Folder, Master};
    use DB;
    use Cache;
    use App\Models\Decorators\TagsFilterDecorator;
    use App\Service\Settings;
    use App\Service\Ssr\SsrParser;

    /**
     * Parser
     */
    class Parser
    {
        // обёртка для переменных
        const START_VAR = '[';
        const END_VAR   = ']';

        // обёртка для высчитываемых переменных типа [map|focus=trg]
        const START_VAR_CALC = '{';
        const END_VAR_CALC   = '}';

        public static function compileVars($html, $page = null)
        {
            preg_match_all('#\\' . static::interpolate('((?>[^\[\]]+)|(?R))*\\') . '#U', $html, $matches);
            $vars = $matches[0];
            foreach ($vars as $var) {
                $var = trim($var, static::interpolate());
                $ssrParser = new SsrParser($var, $page);
                if ($ssrParser->exists()) {
                    static::replace($html, $var, $ssrParser->parse());
                } else {
                    // если в переменной есть знак =, то воспроизводить значения
                    if (strpos($var, '=')) {
                        static::replace($html, $var, static::compileValues($var, $page));
                    } else {
                        $variable = Variable::findByName($var)->first();
                        if ($variable) {
                            static::replace($html, $var, $variable->html);
                        }
                    }
                }
            }
            // preg_match_all('#\\' . static::interpolate('[\S]+\\', self::START_VAR_CALC, self::END_VAR_CALC) . '#', $html, $matches);

            // compile functions after values & vars
            preg_match_all('#\\' . static::interpolate('[\S]+\\') . '#', $html, $matches);
            $vars = $matches[0];
            foreach($vars as $var) {
                // если функция содержит внутри {} – пропускать
                if (strpos($var, '{')) {
                    continue;
                }
                // @todo: пока в виде исключения теги
                if ($page && strpos($var, '[page.tags]') > 0) {
                    $old_var = $var;
                    $var = self::compilePage($page, trim($var, '[]'));
                    $html = str_replace($old_var, static::interpolate($var), $html);
                }
                $var = trim($var, static::interpolate());
                static::compileFunctions($html, $var);
            }
            return $html;
        }

        /**
         * Компилировать значения типа [map|center=95,23|branch=trg|deadline=[deadline]]
         */
        public static function compileValues($var_string, $page = null)
        {
            // map|a=1|b=2
            // tutor|{subject}|{count}
            $values = explode('|', $var_string);

            // первая часть – название переменной
            $html = Variable::findByName($values[0])->first();
            // $html = DB::table('variables')->whereName($values[0])->value('html');

            // если переменная нашлась
            if ($html !== null) {
                 // КОСТЫЛЬ СПЕЦИАЛЬНО ДЛЯ ADDRESS-PAGE
                 if ($values[0] === 'address-page') {
                    $newHtml = $html->getOriginal('html');
                    list($var_name, $var_val) = explode('=', $values[1]);
                    $newHtml = str_replace('{' . $var_name . '}', $var_val, $newHtml);
                    $html->html = $newHtml;
                }
                $html = $html->html;
                // убираем название переменной из массива
                array_shift($values);

                foreach($values as $value) {
                    // разбиваем a=1
                    list($var_name, $var_val) = explode('=', $value);
                    // если $var_val – это переменная
                    if (@$var_val[0] == self::START_VAR) {
                        // заменяем на значение переменной, если таковая найдена
                        $variable = Variable::findByName(trim($var_val, self::START_VAR . self::END_VAR))->first();
                        if ($variable) {
                            static::replace($html, $var_name, $variable->html, self::START_VAR_CALC, self::END_VAR_CALC);
                        }
                    } else {
                    // иначе просто заменяем на значение после =
                        static::replace($html, $var_name, $var_val, self::START_VAR_CALC, self::END_VAR_CALC);
                    }
                }

                return $html;
            } else {
                $var = array_shift($values);
                $ssrParser = new SsrParser($var, $page, $values);
                if ($ssrParser->exists()) {
                    return $ssrParser->parse();
                    // static::replace($html, $var, $ssrParser->parse());
                } else {
                    return $var_string;
                }
            }
        }

        /**
         * Компилирует функции типа [factory|subjects|name]
         */
        public static function compileFunctions(&$html, $var)
        {
            $replacement = '';
            // \Log::info($var);
            $args = explode('|', $var);
            if (count($args) > 1) {
                $function_name = $args[0];
                array_shift($args);
                switch ($function_name) {
                    case 'mobile':
                        $replacement = isMobile(true) ? 'is-mobile' : 'is-desktop';
                        break;
                    case 'factory':
                        $replacement = fact(...$args);
                        break;
                    case 'version':
                        $replacement = DB::table('settings')->where('key', 'version')->value('value');
                        break;
                    // is|test
                    case 'is':
                        $replacement = isTestSubdomain() ? 'true' : 'false';
                        break;
                    // case 'seo':
                    //     $replacement = view('seo.links');
                    //     return;
                    case 'masters':
                        if ($args[0] == 'all') {
                            $replacement = Master::with('photos')->get();
                        } else {
                            $ids = array_filter(explode(',', $args[0]));
                            $query = Master::with('photos')->whereIn('id', $ids);
                            if (count($ids)) {
                                $query->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));
                            }
                            $replacement = $query->get();
                        }
                        break;
                    case 'header-message':
                        $header = trim(Settings::get('header'));
                        if ($header) {
                            $replacement = "<div class='header-message'>{$header}</div>";
                        } else {
                            $replacement = '';
                        }
                        break;
                    case 'equipment':
                        $ids = explode(',', $args[0]);
                        $query = Equipment::with('photos');
                        if (count($ids) == 1) {
                            $replacement = $query->whereId($ids[0])->first();
                        } else {
                            $replacement = $query->whereIn('id', $ids)->get();
                        }
                        break;
                    case 'articles':
                        $replacement = Page::where('folder_id', 29)->select('url', 'title')->get()->toJson();
                        break;
                    case 'filesize':
                        $replacement = getSize($args[0], 0);
                        break;
                    case 'reviews':
                        if ($args[0] === 'random') {
                            $replacement = Review::get(1, true)->toJson();
                        } else {
                            $replacement = Review::get(...$args)->toJson();
                        }
                        break;
                    case 'abtest':
                        $replacement = \App\Service\ABTest::parse(...$args);
                        break;
                    case 'abtest-if':
                        $key = 'abtest-' . $args[0];
                        $val = isset($GLOBALS[$key]) ? $GLOBALS[$key] : @$_COOKIE[$key];
                        $replacement = $val ? 'true' : 'false';
                        break;
                    case 'const':
                        $replacement = Factory::constant($args[0]);
                        break;
                    case 'session':
                        $replacement = json_encode(@$_SESSION[$args[0]]);
                        break;
                    case 'param':
                        $replacement = json_encode(@$_GET[$args[0]]);
                        break;
                    case 'year':
                        $replacement = date('Y');
                        break;
                    case 'subject':
                        $replacement = json_encode(Page::getSubjectRoutes());
                        break;
                    case 'university-image':
                        $folder = 'img/university/';
                        $replacement = file_exists($folder . $args[0] . '.jpg') ? '/' . $folder . $args[0] . '.jpg' : '/img/university/' . (strpos($args[0], 'big') !== false ? 'big/' : '') . 'no-university.jpg';
                        break;
                    case 'link':
                        // получить ссылку либо по [link|id_раздела] или по [link|math]
                        $replacement = is_numeric($args[0]) ? Page::getUrl($args[0]) : Page::getSubjectUrl($args[0]);
                        break;
                    case 'gallery':
                        $replacement = self::_parseGallery(...$args);
                        break;
                    case 'video':
                        $ids = array_filter(explode(',', $args[0]));
                        $query = Video::whereIn('id', $ids);
                        if (count($ids)) {
                            $query->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'));
                        }
                        $replacement = $query->get()->toJson();
                        break;
                    case 'photo':
                        $replacement = Photo::find($args[0])->url;
                        break;
                    case 'program':
                        $replacement = view('pages.program', ['program' => Program::find($args[0])]);
                        break;
                    case 'price':
                        $replacement = \App\Service\Price::parse(...$args);
                        break;
                    case 'faq':
                        $replacement = \App\Models\FaqGroup::getAll()->toJson();
                        break;
                    case 'photo-reviews':
                        $replacement = Review::getStudent(...$args)->toJson();
                        break;
                    case 'count':
                        $type = array_shift($args);
                        switch($type) {
                            case 'clients': {
                                $replacement = egecrm(DB::raw("(select 1 from contract_info group by id_student) as x"))->count();
                                break;
                            }
                            case 'reviews':
                                if (@$args[0] == 'egerep') {
                                    $replacement = egerep('reviews')->where('state', 'published')->count();
                                } else {
                                    $replacement = Review::count();
                                }
                                break;
                        }
                    break;
                }
                static::replace($html, $var, $replacement);
            }
        }

        /**
         * Компиляция значений страницы
         * значения типа [page.h1]
         */
        public static function compilePage($page, $html)
        {
            preg_match_all('#\\' . static::interpolate('page\.[\S]+?\\') . '#', $html, $matches);
            $vars = $matches[0];
            foreach ($vars as $var) {
                $var = trim($var, static::interpolate());
                $field = explode('.', $var)[1];
                static::replace($html, $var, @$page->{$field});
            }
            return $html;
        }

        /**
         * Компилировать страницу сущности
         */
        public static function compileMaster($id, &$page)
        {
            $html = $page->getHtml();
            $title = $page->title;
            $master = Master::whereId($id)->first();


            $masterProfileVariable = new \App\Service\Ssr\Variables\MasterProfile('master-profile', $page, (object)['master' => $master]);
            static::replace($html, 'master-profile', $masterProfileVariable->parse());

            static::replace($title,  'master-name', implode(' ', [$master->last_name, $master->first_name, $master->middle_name]));
            static::replace($html, 'current_master_gallery_ids', Gallery::where('master_id', $master->id)->pluck('id')->implode(','));
            static::replace($html, 'current_master_video_ids', Video::where('master_id', $master->id)->pluck('id')->implode(','));
            $page->html = $html;
            $page->title = $title;
        }

        public static function interpolate($text = '', $start = null, $end = null)
        {
            if (! $start) {
                $start = self::START_VAR;
            }
            if (! $end) {
                $end = self::END_VAR;
            }
            return $start . $text . $end;
        }

        /**
         * Произвести замену переменной в html
         */
        public static function replace(&$html, $var, $replacement, $start = null, $end = null)
        {
            $html = str_replace(static::interpolate($var, $start, $end), $replacement, $html);
        }

        /**
         * Заменить переносы строки и двойные пробелы,
         * а так же пробел перед запятыми, пробелы на краях
         */
        private static function _cleanString($text)
        {
            return str_replace(' ,', ',',
                trim(
                    preg_replace('!\s+!', ' ',
                        str_replace(PHP_EOL, ' ', $text)
                    )
                )
            );
        }

        private static function _parseGallery($gallery_ids, $tags, $folder_ids)
        {
            /**
             * Если не указаны ID фото и ID папок, то автозаполнение по тегам
             */
            if (! $gallery_ids && ! $folder_ids) {
                return (new TagsFilterDecorator(Gallery::with('master')))->withTags($tags)->orderBy('folder_id', 'asc')->orderByPosition()->get()->toJson();
            } else {
                $gallery_ids = array_filter(explode(',', $gallery_ids));

                if ($folder_ids) {
                    $folder_ids = array_filter(explode(',', $folder_ids));

                    // append all subfolders
                    $subfolder_ids = [];
                    foreach($folder_ids as $folder_id) {
                        $subfolder_ids = array_merge($subfolder_ids, Folder::getSubfolderIds($folder_id));
                    }
                    $folder_ids = array_merge($folder_ids, $subfolder_ids);

                    $gallery_ids_from_folders = [];
                    foreach($folder_ids as $folder_id) {
                        $gallery_ids_from_folders = array_merge($gallery_ids_from_folders, Gallery::where('folder_id', $folder_id)->orderByPosition()->pluck('id')->all());
                    }

                    $gallery_ids = array_merge($gallery_ids_from_folders, $gallery_ids);
                }

                $query = Gallery::with('master')->whereIn('id', $gallery_ids);
                if (count($gallery_ids)) {
                    $query->orderBy(DB::raw('FIELD(id, ' . implode(',', $gallery_ids) . ')'));
                }

                return $query->get()->toJson();
            }
        }

        /**
         *  НЕ ИСПОЛЬЗУЕТСЯ
            Автозаполнение по тегам
            если параметры ids и folder пустые, то фотографии отображаются по тэгам, то есть автоматически
            подробный механизм автоматического отображения фотографий (он будет применяться не только в фото,
            но и в отзывах и, возможно, еще с какими-либо items):

            например, на странице указаны тэги "а", "b", "c". Это значит система должна найти фото, соответствующие этим критериям минимум.
            То есть в самом верху отобразить фото, в которых будет указаны как минимум все эти тэги

            "а", "b", "с"
            "а", "b", "с", "d"
            "а", "b", "с", "d", "e"
            "с", "d", "а", "b"
            далее система думает какие фотографии отобразить ниже: она смотрит на оставшиеся тэги и думает какой тэг выбросить.
            Система смотрит на встречаемость тэгов "а", "b" и "с" в фотографиях и видит, что "а" встретился 450 раз, "b" встретился 5 раз, "c"
            встретился 100 раз. Значит система как бы "выбрасывает" тэг "b", так как он встречается меньше всех и ниже начинает
            отображать фотографии, соответствующие набору тэгов "а", "с" и так далее до того момента, как останется только 1 тэг.
            Далее система отображает фотографии, у которых указан только оставшийся этот последний тэг. Дальше система уже никакие
            фото не отображает. все фотографии должны быть одображены 1 раз, то есть при выводе не должно быть дублирований
         */
        public static function findPhotosByTags($tags)
        {
            if ($tags) {
                if (is_string($tags)) {
                    $tags = explode(',', $tags);
                }
                $combinations = getCombinations($tags);
                $combination_counts = [];
                $ids = [];
                foreach($combinations as $combinations_chunk) {
                    // для дебага
                    // foreach($combinations_chunk as $index => $combination) {
                    //     $ids[implode('-', $combination)] = (new TagsFilterDecorator(Gallery::query()))->withTags($combination)->pluck('id')->all();
                    // }
                    $combination_counts = [];
                    foreach($combinations_chunk as $index => $combination) {
                        $combination_counts[$index] = (new TagsFilterDecorator(Gallery::query()))->withTags($combination)->whereNotIn('id', $ids)->count();
                    }
                    arsort($combination_counts);
                    foreach($combination_counts as $combination_index => $count) {
                        $ids = array_merge($ids, (new TagsFilterDecorator(Gallery::query()))->withTags($combinations_chunk[$combination_index])->whereNotIn('id', $ids)->orderByPosition()->pluck('id')->all());
                    }
                }
                return Gallery::whereIn('id', $ids)->orderBy('folder_id', 'asc')->orderByPosition()->get()->toJson();
            }
            return [];
        }

        public static function getPostfixed($html, $page, $postfix = '-mobile')
        {
            preg_match_all('#\\' . static::interpolate('((?>[^\[\]]+)|(?R))*\\') . '#U', $html, $matches);
            $vars = $matches[0];
            foreach ($vars as $var) {
                $var = trim($var, static::interpolate());
                // если мобильная версия, добавлять '-mobile'
                $var_without_params = explode('|', $var)[0];
                if (! preg_match("#{$postfix}#", $var_without_params)) {
                    if (Variable::findByName($var_without_params)->exists()) {
                        $var_mobile = str_replace($var_without_params, $var_without_params . $postfix, $var);
                        $html = str_replace($var, $var_mobile, $html);
                        // $var = $var_mobile;
                    }
                }
            }
            return $html;
        }
    }
