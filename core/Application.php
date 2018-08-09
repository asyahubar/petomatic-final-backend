<?php
namespace Petomatic\Core;

class Application
{
    public static $registry = [];

    public static function put($key, $value)
    {
        static::$registry[$key] = $value;
    }

    public static function get($key)
    {
         return  static::$registry[$key];
    }
}