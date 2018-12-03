<?php

namespace BoomDraw\Helpers\Traits;

trait TableNameGetter
{
    public static function getTableName()
    {
        return ((new self)->getTable());
    }

    public static function getMorphName()
    {
        return (new self)->getMorphClass();
    }
}
