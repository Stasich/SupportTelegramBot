<?php

namespace Models\Stasich;

class ClassConfig
{
    private static $config = [];
    public static function setConfig($arr)
    {
        self::$config = $arr;
    }
    public static function getConfig()
    {
        return self::$config;
    }
    private function __construct()
    {
    }
}