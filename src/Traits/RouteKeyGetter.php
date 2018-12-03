<?php

namespace BoomDraw\Helpers\Traits;

use Request;

trait RouteKeyGetter
{
    public function getRouteKeyName()
    {
        if (Request::is('admin*')) {
            return 'id';
        } else {
            return 'slug';
        }
    }
}
