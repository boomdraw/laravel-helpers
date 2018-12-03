<?php

namespace BoomDraw\Helpers\Traits;

trait ServiceNameGetter
{
    public static function getServiceName($class = self::class)
    {
        $class = snake_case(class_basename($class));
        $class = str_before($class, '_facade');

        return ends_with($class, '_helper') ? $class : $class . '_helper';
    }
}
