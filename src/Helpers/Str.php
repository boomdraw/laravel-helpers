<?php

namespace BoomDraw\Helpers\Helpers;

class Str
{
    public function between($string, $start, $end, $strict = true)
    {
        if ($strict && (!str_contains($string, $start) || !str_contains($string, $end))) {
            return false;
        }
        $string = str_replace_first(str_before($string, $start) . $start, '', $string);
        $string = str_replace_first($end . str_after($string, $end), '', $string);

        return $string;

    }

    public function wbetween($string, $start, $end, $strict = true)
    {
        if (($string = str_between($string, $start, $end, $strict)) !== false) {
            return $start . $string . $end;
        } else {
            return false;
        }
    }

    public function utrim($string)
    {
        return trim($string, " \t\n\r\0\x0B/\\");
    }
}
