<?php

if (!function_exists('str_between')) {
    function str_between($string, $start, $end, $strict = true)
    {
        return StrHelper::between($string, $start, $end, $strict);
    }
}

if (!function_exists('str_wbetween')) {
    function str_wbetween($string, $start, $end, $strict = true)
    {
        return StrHelper::wbetween($string, $start, $end, $strict);
    }
}

if (!function_exists('utrim')) {
    function utrim($string)
    {
        return StrHelper::utrim($string);
    }
}
