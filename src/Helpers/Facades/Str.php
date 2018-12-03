<?php

namespace BoomDraw\Helpers\Helpers\Facades;

use Illuminate\Support\Facades\Facade;
use BoomDraw\Helpers\Traits\ServiceNameGetter;

class Str extends Facade
{
    use ServiceNameGetter;

    protected static function getFacadeAccessor() { return self::getServiceName(); }
}
