<?php

namespace helper\traits;

trait Memorize
{
    protected static $memory = [];
    
    /**
     * @param          $key
     * @param array    $args
     * @param callable $instantiateCallback
     * @return mixed
     * @throws Exception
     */
    protected function _memorize($key, $args, $instantiateCallback)
    {
        return self::_memorizeStatic($key, $args, $instantiateCallback);
    }
    
    /**
     * @param          $key
     * @param array    $args
     * @param callable $instantiateCallback
     * @return mixed
     */
    protected static function _memorizeStatic($key, $args, $instantiateCallback)
    {
        $key = get_called_class() . $key . md5(serialize($args));
        if (!array_key_exists($key, self::$memory)) {
            self::$memory[$key] = $instantiateCallback($args);
        }
        return self::$memory[$key];
    }
    
}