<?php

namespace helper\traits;

trait Cache
{
    protected function _cache($key, $args, $instantiateCallback, $seconds = 3600)
    {
        $cache = \Yii::$app->getCache();
        $key = get_called_class() . $key . md5(serialize($args));
        if (!$cache->exists($key)) {
            $value = $instantiateCallback($args);
            $cache->set($key, $value, $seconds);
            return $value;
        }
        return $cache->get($key);
    }
}