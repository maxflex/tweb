<?php
    namespace App\Service;

    use DB;

    /**
     * Translit
     */
    class Settings
    {
        public static function set($key, $value)
        {
            $query = DB::table('settings')->where('key', $key);

            if ($query->exists()) {
                $query->update([
                    'value' => $value
                ]);
            } else {
                DB::table('settings')->insert(['key' => $key, 'value' => $value]);
            }
        }

        public static function get($key)
        {
            return DB::table('settings')->where('key', $key)->value('value');
        }
    }
