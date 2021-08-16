<?php

namespace helper\traits;

trait Create
{
    public static function create()
    {
        return new static;
    }
}