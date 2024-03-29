<?php

use App\Models\Variable;

const NAME_VALIDATION_REGEX = '/^[A-Za-zа-яА-ЯёЁ\-\s]*$/u';
const TEXT_VALIDATION_REGEX = '/^[0-9A-Za-zа-яА-ЯёЁ\(\)\-\.\,\s]*$/u';
const PHONE_REGEX = '/^\+7 \([4|9]{1}[\d]{2}\) [\d]{3}-[\d]{2}-[\d]{2}$/';
const MOBILE_PHONE_REGEX = '/^\+7 \(9[\d]{2}\) [\d]{3}-[\d]{2}-[\d]{2}$/';
const MAX_COMMENT_LENGTH = 1000;
const MAX_NAME_LENGTH    = 60;

function dateRange($strDateFrom, $strDateTo)
{
    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2),     substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2),     substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

function preType($Object)
{
    echo '<pre>';
    print_r($Object);
    echo '</pre>';
}

function emptyObject()
{
    return (object)[];
}

function setOrNull($var)
{
    return (isset($var) && $var) ? $var : null;
}

/**
 * Форматировать дату в наш формат.
 *
 */
function dateFormat($date, $notime = false)
{
    $date = date_create($date);
    return date_format($date, $notime ? "d.m.Y" : "d.m.Y в H:i");
}

/**
 * Деформатировать дату
 */
function fromDotDate($date)
{
    $parts = explode('.', $date);
    return implode('-', array_reverse($parts));
}

/**
 * Возвратить чистый номер телефона.
 *
 */
function cleanNumber($number, $add_seven = false)
{
    return ($add_seven ? '7' : '') . preg_replace("/[^0-9]/", "", $number);
}

/**
 * Пребежать по номерам телефона
 * функция должна возвращать номер телефона
 * @example throughNumbers($tutor, function($number)) {
 *              return $number . '123';
 *          }
 *
 */
function throughNumbers(&$object, $func)
{
    foreach (App\Traits\Person::$phone_fields as $phone_field) {
        $object->{$phone_field} = $func($object->{$phone_field});
    }
}

/**
 * Очистить номера телефонов у объекта
 */
function cleanNumbers(&$object)
{
    throughNumbers($object, 'cleanNumber');
}

/*
	 * В формат ангуляра
	 */
function ngInitOne($name, $Object)
{
    return $name . " = " . htmlspecialchars(json_encode($Object, JSON_NUMERIC_CHECK)) . "; ";
}

/*
	 * Инициализация переменных ангуляра
	 * $array – [var_name = {var_values}; ...]
	 * @return строка вида 'a = {test: true}; b = {var : 12};'
	 */
function ngInit($array)
{
    $return = '';
    foreach ($array as $var_name => $var_value) {
        // Если значение не установлено, то это пустой массив по умолчанию
        // if (!$var_value && !is_int($var_value)) {
        // 	$var_value = "[]";
        // } else {
        // иначе кодируем объект в JSON
        // $var_value = htmlspecialchars(json_encode($var_value, JSON_NUMERIC_CHECK));
        // $var_value = htmlspecialchars(json_encode($var_value, JSON_FORCE_OBJECT));
        $var_value = json_encode($var_value, JSON_FORCE_OBJECT);
        // }
        $return .= $var_name . " = " . $var_value . "; ";
    }

    return ['nginit' => $return];
}

function isProduction()
{
    return app()->environment() == 'production';
}

/**
 * Возвратить user id из сесси или 0 (system)
 */
function userIdOrSystem()
{
    return \App\Models\User::loggedIn() ? \App\Models\User::fromSession()->id : 0;
}

function noww($no_time = false)
{
    return date('Y-m-d' . ($no_time ? '' : ' H:i:s'));
}

function isBlank($value)
{
    return empty($value) && !is_numeric($value);
}

function notBlank($value)
{
    return !isBlank($value);
}

function isFilled($value)
{
    return (isset($value) && !empty($value));
}

/**
 * Разбить enter'ом
 */
function breakLines($array)
{
    return implode('

', array_filter($array));
}


/**
 * Удалить пустые строки
 */
function filterParams($a)
{
    return (object)array_filter((array)$a, function ($e) {
        return $e !== '';
    });
}

/**
 * Склоняем словоформу
 * @author runcore
 * @source https://habr.com/ru/post/53210/
 */
function morph($n, array $f1f2f5)
{
    $n = abs(intval($n)) % 100;
    if ($n > 10 && $n < 20) return $f1f2f5[2];
    $n = $n % 10;
    if ($n > 1 && $n < 5) return $f1f2f5[1];
    if ($n == 1) return $f1f2f5[0];
    return $f1f2f5[2];
}

function pluralize($one, $few, $many, $n)
{
    return $n . ' ' . morph($n, [$one, $few, $many]);
}

/**
 * Get from factory
 */
function fact($table, $key = 'id', $select = null)
{
    return \App\Models\Service\Factory::json($table, $key, $select);
}

/**
 * Egerep connection helper
 */
function egerep($table)
{
    return \DB::connection('egerep')->table($table);
}

/**
 * Egerep connection helper
 */
function egecrm($table)
{
    return \DB::connection('egecrm')->table($table);
}

/**
 * Factory connection helper
 * @return [type]  [description]
 */
function dbFactory($table)
{
    return \DB::connection('factory')->table($table);
}


function isAssoc(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function getSize($file, $precision = 1)
{
    // $size = filesize('public/' . $file);
    $size = filesize($file);
    $base = log($size, 1024);
    $suffixes = array('байт', 'Кб', 'Мб', 'Гб', 'Тб');
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}

function yearsPassed($year)
{
    return date('Y') - $year;
}

function isMobile($raw = false)
{
    $agent = new \Jenssegers\Agent\Agent;
    $is_mobile = ($agent->isMobile() && !$agent->isTablet());
    if ($raw) {
        return $is_mobile;
    } else {
        return (($is_mobile && !isset($_SESSION['force_full'])) || (isset($_SESSION['force_mobile'])));
    }
}

function fileExists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpCode == 200) {
        return true;
    }
}

function cacheKey($key, $id = null)
{
    return "tweb:$key" . ($id ? ":$id" : '');
}


function flatten($collection, $child)
{
    return $collection->flatMap(function ($value) use ($child) {
        return $value->$child;
    });
}

function isTestSubdomain()
{
    if (App::environment('local')) {
        return true;
    }
    return array_shift((explode('.', @$_SERVER['HTTP_HOST']))) === 'test';
}


/**
 * getCombinations(['a', 'b', 'c']);
     [
         [
           [
             "a",
             "b",
             "c",
           ],
         ],
         [
           [
             "a",
             "b",
           ],
           [
             "a",
             "c",
           ],
           [
             "b",
             "c",
           ],
         ],
         [
           [
             "a",
           ],
           [
             "b",
           ],
           [
             "c",
           ],
         ],
       ]
 */
function getCombinations($words)
{
    $elements = pow(2, count($words)) - 1;

    $result = array();

    for ($i = 1; $i <= $elements; $i++) {
        $bin = decbin($i);
        $padded_bin = str_pad($bin, count($words), "0", STR_PAD_LEFT);

        $res = array();
        for ($k = 0; $k < count($words); $k++) {
            //append element, if binary position says "1";
            if ($padded_bin[$k] == 1) {
                $res[] = $words[$k];
            }
        }

        sort($res);
        $result[] = $res;
    }
    sort($result);

    // @custom
    // в каждом элементе массива хранятся пермутации одной и той же длинны
    // [0] => [a], [b], [c]
    // [1] => [ab], [ac]

    $current_chunk = 0;
    $chunked_result[$current_chunk] = [$result[0]];
    foreach (range(1, count($result) - 1) as $i) {
        if (count($result[$i]) > count($result[$i - 1])) {
            $current_chunk++;
        }
        $chunked_result[$current_chunk][] = $result[$i];
    }

    return array_reverse($chunked_result);
}

function getMapInfo($map = null)
{
    $info = json_decode(Variable::find(1100)->html, true);
    if ($map === null) {
        return $info;
    }
    return @$info[$map];
}
