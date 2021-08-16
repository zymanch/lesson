<?php

namespace components;

class Env
{
    public static function isWindows()
    {
        return \DIRECTORY_SEPARATOR === '\\';
    }
}