<?php
    namespace App\Models\Service;
    use App\Models\Program;
    use App\Models\Variable;
    use App\Models\Photo;
    use App\Models\Gallery;
    use App\Models\Review;
    use App\Models\Page;
    use App\Models\Master;
    use App\Models\Video;
    use App\Models\Equipment;
    use DB;
    use Cache;
    use App\Models\Decorators\TagsFilterDecorator;

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
            $html = Variable::findByName($values[0])->first()->html;
            // $html = DB::table('variables')->whereName($values[0])->value('html');

            // если переменная нашлась
            if ($html !== null) {
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
                // если переменная не нашлась, возвращаем неизменную $var_string
                return $var_string;
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
                    case 'tutor':
                        $replacement = Tutor::find($args[0])->toJson();
                        break;
                    // is|test
                    case 'is':
                        $replacement = isTestSubdomain() ? 'true' : 'false';
                        break;
                    case 'masters':
                        if ($args[0] == 'all') {
                            $replacement = Master::with('photos')->get();
                        } else {
                            $replacement = Master::with('photos')->whereIn('id', explode(',', $args[0]))->take(3)->get();
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
                        $ids = explode(',', $args[0]);
                        $replacement = Video::whereIn('id', $ids)->orderBy(DB::raw('FIELD(id, ' . implode(',', $ids) . ')'))->get()->toJson();
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
                            case 'tutors':
                                if (@$args[0] == 'egerep') {
                                    $replacement = egerep('tutors')->where('public_desc', '!=', '')->count();
                                } else {
                                    $replacement = Tutor::count(...$args);
                                }
                                break;
                            case 'reviews':
                                if (@$args[0] == 'egerep') {
                                    $replacement = egerep('reviews')->where('state', 'published')->count();
                                } else {
                                    $replacement = Review::count();
                                }
                                break;
                            case 'subjects':
                                $counts = [];
                                foreach(range(1, 11) as $subject_id) {
                                    $counts[$subject_id] = Tutor::whereSubject($subject_id)->count();
                                }
                                $replacement = json_encode($counts);
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
        public static function compileMaster($id, &$html)
        {
            $master = Master::whereId($id)->first();
            static::replace($html, 'subject', $master->subjects_string);
            static::replace($html, 'master-name', implode(' ', [$master->last_name, $master->first_name, $master->middle_name]));
            static::replace($html, 'current_master', $master->toJson());
            static::replace($html, 'current_master_gallery_ids', Gallery::where('master_id', $master->id)->pluck('id')->implode(','));
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
            $gallery_ids = array_filter(explode(',', $gallery_ids));

            if ($folder_ids) {
                $folder_ids = array_filter(explode(',', $folder_ids));
                $ids_by_folder = [];
                $max_size = -1;
                // мерджим фотки из папок по типу
                // 1 3
                // 2 4
                // 5
                // 6
                // => 1,3,2,4,5,6
                foreach($folder_ids as $folder_id) {
                    $ids_by_folder[$folder_id] = Gallery::where('folder_id', $folder_id)->orderBy('position')->pluck('id')->all();
                    $size = count($ids_by_folder[$folder_id]);
                    if ($size > $max_size) {
                        $max_size = $size;
                    }
                }

                $ordered_ids = [];
                foreach(range(0, $max_size - 1) as $i) {
                    foreach($folder_ids as $folder_id) {
                        if (isset($ids_by_folder[$folder_id][$i])) {
                            $ordered_ids[] = $ids_by_folder[$folder_id][$i];
                        }
                    }
                }
                $gallery_ids = array_merge($gallery_ids, $ordered_ids);
            }

            $query = Gallery::with('master')->whereIn('id', $gallery_ids)
                ->orderBy(DB::raw('FIELD(id, ' . implode(',', $gallery_ids) . ')'));

            $query = (new TagsFilterDecorator($query))->withTags($tags);

            return $query->get()->toJson();
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
