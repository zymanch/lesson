<?php
/**
 * Created by PhpStorm.
 * User: s4urp
 * Date: 18.02.2019
 * Time: 15:23
 */

namespace helper;

class Validate
{
    /**
     * @param $value
     * @return bool
     */
    public static function isJSON($value)
    {
        if (empty($value)) {
            return false;
        }

        try {
            $decoded = \json_decode($value, true);
            if (is_null($decoded)) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
        }

        return false;
    }

    public static function isArrayKeyExists(array $array, array $keys)
    {
        if (empty($keys)) {
            return false;
        }

        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                return false;
            }
            $array = $array[$key];
        }

        return true;
    }

    public static function isStringContains(string $string, string $contains)
    {
        return strpos($string, $contains) !== false;
    }

}